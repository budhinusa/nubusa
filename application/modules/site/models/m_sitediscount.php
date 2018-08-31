<?php
class M_sitediscount extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function discount_depan(){
    $discount = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount AS A"
      . " WHERE A.code LIKE '%|OTA DEPAN|%'"
      . " AND (A.bataswaktu = 2"
        . " OR ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate))"
      . " AND A.approve = 2"
      . " AND A.status = 1"
      . " ORDER BY A.sort ASC"
      . "");
    
    foreach ($discount AS $disc){
      $payment_channel = array();
      if($disc->is_payment_channel == 1){
        $pchannel = $this->global_models->get_query("SELECT A.*"
          . " ,(SELECT CONCAT(B.title, '|', B.code) FROM crm_payment_channel AS B WHERE B.id_crm_payment_channel = A.id_crm_payment_channel) AS semua"
          . " FROM crm_pos_discount_payment_channel AS A"
          . " WHERE A.id_crm_pos_discount = '{$disc->id_crm_pos_discount}'"
          . "");
        foreach ($pchannel AS $pc){
          $semua = explode("|", $pc->semua);
          $payment_channel[] = array(
            "id"        => $pc->id_crm_payment_channel,
            "title"     => $semua[0],
            "code"      => $semua[1],
          );
        }
      }
      $data['discount'][] = array(
        "id"                => $disc->id_crm_pos_discount,
        "title"             => $disc->title,
        "is_payment_channel"=> $disc->is_payment_channel,
        "payment_channel"   => $payment_channel,
        "is_voucher"        => $disc->is_voucher,
        "bataswaktu"        => $disc->bataswaktu,
        "startdate"         => $disc->startdate,
        "enddate"           => $disc->enddate,
        "type"              => $disc->type,
        "nilai"             => $disc->nilai,
      );
    }
    
    $hasil = array(
      "status"        => 2,
      "data"          => $data,
//      "debug"         => $data,
    );
    return $hasil;
  }
  
  function voucher_cek($code, $id_crm_payment_channel, $nilai){
    $this->load->model("crm/m_discount");
    
    $kirim = array(
      "id_crm_payment_channel"        => $id_crm_payment_channel,
      "voucher"                       => $code,
      "nilai"                         => $nilai,
      "minimum"                       => 1,
      "code"                          => "|OTA|",
      "date"                          => date("Y-m-d H:i:s"),
    );
    $discount = $this->m_discount->discount_list_get($kirim);
    if($discount['status'] == 2){
      $hasil = array(
        "status"      => 2,
        "data"        => $discount['data'],
      );
    }
    else{
      $hasil = array(
        "status"      => 3,
      );
    }
    return $hasil;
  }
  
  function voucher_set($data){
//    buat payment
    $this->load->model("site/m_site");
    $this->load->model("crm/m_discount");
    $timelimit = NULL;
    $total = 0;
    $this->m_site->limit_flight_get($timelimit, $total, $data['book']);
    $reguler['diskon'] = ($data['voucher']['data'][0]->type == 2 ? $data['voucher']['data'][0]->nilai : ($data['voucher']['data'][0]->nilai/100 * $total));
    $kirim = array(
      "id"          => $data['voucher']['data'][0]->id_crm_pos_discount,
      "id_voucher"  => $data['voucher']['data'][0]->voucher[0]->id_crm_pos_discount_voucher,
      "qty"         => 1,
      "source_table"=> "site_ticket_reservation",
      "source_id"   => $data['book']['detail']['bookers']['id'],
      "timelimit"   => date("Y-m-d H:i:s",$timelimit),
    );
    $voucher = $this->m_discount->voucher_book($kirim);
    if($voucher['status'] == 2){
      $return = $voucher;
    }
    else{
      $return = array(
        "status"  => 3
      );
    }
    return $return;
  }
}
?>
