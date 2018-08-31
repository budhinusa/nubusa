<?php
class M_discount extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function voucher_cek_detail($kirim){
//    "id_crm_payment_channel"          => $id_crm_payment_channel,
//    "id_crm_pos_discount_voucher_use" => $pst['id_crm_pos_discount_voucher_use'],
//    "nilai"                           => $total,
//    "source_table"                    => "site_ticket_reservation",
//    "source_id"                       => $book[0]->id_site_ticket_reservation
    
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,B.nilai, B.type AS discount_type"
      . " ,(SELECT C.title FROM crm_pos_discount_voucher AS C WHERE C.id_crm_pos_discount_voucher = A.id_crm_pos_discount_voucher) AS voucher"
      . " FROM crm_pos_discount_voucher_use AS A"
      . " LEFT JOIN crm_pos_discount AS B ON A.id_crm_pos_discount = B.id_crm_pos_discount"
      . " WHERE A.id_crm_pos_discount_voucher_use = '{$kirim['id_crm_pos_discount_voucher_use']}'"
      . " AND A.timelimit >= '".date("Y-m-d H:i:s")."'"
      . " AND A.source_table = '{$kirim['source_table']}'"
      . " AND A.source_id = '{$kirim['source_id']}'"
      . "");
      
    if($data){
      $return = array(
        "status"              => 2,
        "voucher"             => $data[0]->voucher,
        "nilai"               => ($data[0]->discount_type == 2 ? $data[0]->nilai : ($data[0]->nilai/100 * $kirim['nilai'])),
        "id_crm_pos_discount" => $data[0]->id_crm_pos_discount,
        "timelimit"           => $data[0]->timelimit,
      );
    }
    else{
      $return = array(
        "status"              => 3,
      );
    }
    return $return;
  }
  
  function voucher_cek($voucher, $id_crm_pos_discount){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount_voucher AS A"
      . " WHERE A.id_crm_pos_discount = '{$id_crm_pos_discount}'"
      . " AND LOWER(A.title) = '".strtolower($voucher)."'"
      . "");
    $return = array(
      "status"      => 3
    );
    if($data){
      $sudah = $this->global_models->get_query("SELECT SUM(A.qty) AS jml"
        . " FROM crm_pos_discount_voucher_use AS A"
        . " WHERE A.id_crm_pos_discount_voucher = '{$data[0]->id_crm_pos_discount_voucher}'"
        . " AND A.status = 1"
        . " AND A.timelimit >= '".date("Y-m-d H:i:s")."'");
      if($data[0]->batas > $sudah[0]->jml){
        $return = array(
          "status"      => 2,
          "detail"      => $data
        );
      }
    }
    return $return;
  }
  
  function voucher_check($voucher){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount_voucher AS A"
      . " WHERE LOWER(A.title) = '".strtolower($voucher)."'"
      . " AND ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate)"
      . "");
    if($data){
      $sudah = $this->global_models->get_query("SELECT SUM(A.qty) AS jml"
        . " FROM crm_pos_discount_voucher_use AS A"
        . " WHERE A.id_crm_pos_discount_voucher = '{$data[0]->id_crm_pos_discount_voucher}'"
        . " AND A.status = 1"
        . " ");
      if($data[0]->batas > $sudah[0]->jml){
        $return = array(
          "status"      => 2,
          "note"        => lang("Available"),
          "detail"      => $data[0]
        );
      }
      else{
        $return = array(
          "status"      => 3,
          "note"        => lang("Sudah digunakan")
        );
      }
    }
    else{
      $return = array(
        "status"      => 3,
        "note"        => lang("Code Voucher tidak berlaku")
      );
    }
    return $return;
  }
  
  function payment_channel_cek($id_crm_payment_channel, $id_crm_pos_discount){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount_payment_channel AS A"
      . " WHERE A.id_crm_pos_discount = '{$id_crm_pos_discount}'"
      . " AND A.id_crm_payment_channel = '{$id_crm_payment_channel}'"
      . "");
    $return = array(
      "status"      => 3
    );
    if($data){
      $return = array(
        "status"      => 2,
        "detail"      => $data
      );
    }
    return $return;
  }
  
  function discount_list_get($kirim){
    $date = $kirim['date'];
    if($kirim['voucher']){
      $where .= " AND A.is_voucher = 1";
    }
    if($kirim['minimum'] == 1){
      $where .= " AND A.minimum <= '{$kirim['nilai']}'";
    }
//    if($kirim['id_crm_payment_channel']){
//      $where .= " AND A.is_payment_channel = 1";
//    }
//    else{
//      $where .= " AND A.is_payment_channel = 2";
//    }
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount AS A"
      . " WHERE A.status = 1"
      . " AND (A.bataswaktu = 2 OR ('{$date}' BETWEEN A.startdate AND A.enddate))"
      . " AND A.code LIKE '%{$kirim['code']}%'"
      . " {$where}"
      . " ORDER BY A.sort ASC, A.create_date DESC"
      . "");
    $return = $data;
    foreach ($data AS $key => $dt){
      if($dt->is_voucher == 1){
        $voucher_cek = $this->voucher_cek($kirim['voucher'], $dt->id_crm_pos_discount);
        if($voucher_cek['status'] == 2){
          $return[$key]->voucher = $voucher_cek['detail'];
        }
        else{
          unset($return[$key]);
        }
      }
      if($dt->is_payment_channel == 1){
        $payment_channel_cek = $this->payment_channel_cek($kirim['id_crm_payment_channel'], $dt->id_crm_pos_discount);
        if($payment_channel_cek['status'] == 2){
          $return[$key]->payment_channel = $payment_channel_cek['detail'];
        }
        else{
          unset($return[$key]);
        }
      }
    }
    
    if($return){
      $hasil = array(
        "status"    => 2,
        "data"      => $return,
      );
    }
    else{
      $hasil = array(
        "status"    => 3,
        "debug"     => $kirim
      );
    }
    return $hasil;
  }
  
  function voucher_book($kirim){
    $cek = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount_voucher_use AS A"
      . " WHERE A.id_crm_pos_discount_voucher = '{$kirim['id_voucher']}'"
      . " AND A.id_crm_pos_discount = '{$kirim['id']}'"
      . " AND A.source_table = '{$kirim['source_table']}'"
      . " AND A.source_id = '{$kirim['source_id']}'"
      . " AND A.timelimit >= '".date("Y-m-d H:i:s")."'");
      
    if($cek){
      $id_crm_pos_discount_voucher_use = $cek[0]->id_crm_pos_discount_voucher_use;
    }
    else{
      $this->global_models->generate_id($id_crm_pos_discount_voucher_use, "crm_pos_discount_voucher_use");
      $post = array(
        "id_crm_pos_discount_voucher_use" => $id_crm_pos_discount_voucher_use,
        "id_crm_pos_discount_voucher"     => $kirim['id_voucher'],
        "id_crm_pos_discount"             => $kirim['id'],
        "source_table"                    => $kirim['source_table'],
        "source_id"                       => $kirim['source_id'],
        "qty"                             => $kirim['qty'],
        "timelimit"                       => $kirim['timelimit'],
        "status"                          => 1,
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_discount_voucher_use", $post);
      $this->global_models->query("UPDATE crm_pos_discount_voucher"
        . " SET digunakan = (IF(digunakan IS NULL, 0, digunakan) + {$kirim['qty']})"
        . " WHERE id_crm_pos_discount_voucher = '{$kirim['id_voucher']}'");
    }
    
    $hasil = array(
      "status"      => 2,
      "id"          => $id_crm_pos_discount_voucher_use
    );
    return $hasil;
  }
}
?>
