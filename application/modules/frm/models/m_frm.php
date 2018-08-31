<?php
class M_frm extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function journal_period_cek($id_frm_journal_period = NULL){
    $frm_journal_period = $this->global_models->get("frm_journal_period", array("id_frm_journal_period" => $id_frm_journal_period));
    if($id_frm_journal_period AND $frm_journal_period){
      $status = 2;
      $data = array(
        "id"        => $frm_journal_period[0]->id_frm_journal_period,
        "title"     => $frm_journal_period[0]->title,
        "code"      => $frm_journal_period[0]->code,
        "code_users"=> $frm_journal_period[0]->code_users,
        "start"     => $frm_journal_period[0]->startdate,
        "end"       => $frm_journal_period[0]->enddate,
        "month"     => $frm_journal_period[0]->bulan,
        "year"      => $frm_journal_period[0]->tahun,
      );
    }
    else{
      $status = 3;
      $note = lang("ID Not Exists");
    }
    $return = array(
      "status"    => $status,
      "data"      => $data,
      "note"      => $note
    );
    return $return;
  }
  
  function journal_set($pst){
    $nomor = $this->global_models->generate_nomor_format('frm_journal', 'frm_journal', 'tanggal', date("Y-m-d H:i:s"));
//    $this->global_models->generate_id($id_frm_journal, "frm_journal");
    $frm_period = $this->journal_period_cek($pst['id_frm_journal_period']);
    $kirim = array(
      "id_frm_journal"        => $id_frm_journal,
      "id_frm_journal_period" => $pst['id_frm_journal_period'],
      "code_users"            => $pst['code_users'],
      "title"                 => $pst['title'],
      "source_table"          => $pst['source'],
      "source_id"             => $pst['id'],
      "code"                  => $pst['code'],
      "tanggal"               => $pst['tanggal'],
      "nomor"                 => $nomor['nomor'],
      "urut"                  => $nomor['urut'],
      "note"                  => $pst['note'],
      "status"                => $pst['status'],
      "create_by_users"       => $this->session->userdata("id"),
      "create_date"           => date("Y-m-d H:i:s")
    );
    $id_frm_journal = $this->global_models->insert("frm_journal", $kirim);
    $hasil = array(
      "status"      => 2,
      "data"        => array(
        "id"                    => $id_frm_journal,
        "code"                  => $kirim['code'],
        "title"                 => $kirim['title'],
        "nomor"                 => $kirim['nomor'],
        "code_users"            => $kirim['code_users'],
        "tanggal"               => $kirim['tanggal'],
      )
    );
    return $hasil;
  }
  
  function journal_update($pst, $id_frm_journal){
    $kirim = array(
      "update_by_users"       => $this->session->userdata("id"),
      "update_date"           => date("Y-m-d H:i:s")
    );
    foreach ($pst AS $key => $ps){
      $kirim[$key] = $ps;
    }
    $this->global_models->update("frm_journal", array("id_frm_journal" => $id_frm_journal), $kirim);
    $hasil = array(
      "status"      => 2,
      "data"        => array(
        "id"                    => $id_frm_journal,
      )
    );
    return $hasil;
  }
  
  function journal_get($pst){
    $frm_journal = $this->global_models->get("frm_journal", array("id_frm_journal" => $pst['id_frm_journal']));
    if($frm_journal){
      $return = array(
        "status"    => 2,
        "data"      => array(
          "id"        => $frm_journal[0]->id_frm_journal,
          "title"     => $frm_journal[0]->title,
          "tanggal"   => $frm_journal[0]->tanggal,
          "nomor"     => $frm_journal[0]->nomor,
          "code"      => $frm_journal[0]->code,
          "code_users"=> $frm_journal[0]->code_users,
        )
      );
    }
    else{
      $return = array(
        "status"    => 3,
        "note"      => ""
      );
    }
    return $return;
  }
  
  function journal_period_get($tgl, $code){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM frm_journal_period AS A"
      . " WHERE ('{$tgl}' BETWEEN A.startdate AND A.enddate)"
      . " AND A.code_users = '{$code}'");
      
    if($data){
      if($data[0]->status == 1){
        $status_set = 2;
      }
      else if($data[0]->status == 2){
        $status_set = 4;
        $note = lang("Period has been closed");
      }
      else{
        $status_set = 3;
        $note = lang("Period has been canceled");
      }
      $hasil = array(
        "status"    => $status_set,
        "note"      => $note,
        "data"      => array(
          "id"        => $data[0]->id_frm_journal_period,
          "title"     => $data[0]->title,
          "code"      => $data[0]->code,
          "code_users"=> $data[0]->code_users,
          "start"     => $data[0]->startdate,
          "end"       => $data[0]->enddate,
          "month"     => $data[0]->bulan,
          "year"      => $data[0]->tahun,
        )
      );
    }
    else{
      $this->global_models->generate_id($id_frm_journal_period, "frm_journal_period");
      $time = strtotime($tgl);
      $kirim = array(
        "id_frm_journal_period"     => $id_frm_journal_period,
        "title"                     => lang("Period")." ".date("M Y", $time),
        "code"                      => date("Ym", $time),
        "code_users"                => $code,
        "startdate"                 => date("Y-m-01 00:00:00", $time),
        "enddate"                   => date("Y-m-t 23:59:59", $time),
        "bulan"                     => date("m", $time),
        "tahun"                     => date("Y", $time),
        "status"                    => 1,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("frm_journal_period", $kirim);
      $hasil = array(
        "status"    => 2,
        "data"      => array(
          "id"        => $id_frm_journal_period,
          "title"     => $kirim['title'],
          "code"      => $kirim['code'],
          "code_users"=> $kirim['code_users'],
          "start"     => $data[0]->startdate,
          "end"       => $data[0]->enddate,
          "month"     => $data[0]->bulan,
          "year"      => $data[0]->tahun,
        )
      );
    }
    return $hasil;
  }
  
  function journal_detail_set($pst){
    $key = 1;
    foreach ($pst AS $ps){
//      $this->global_models->generate_id($id_frm_journal_detail, "frm_journal_detail", $key);
      $key++;
      $kirim[] = array(
//        "id_frm_journal_detail"     => $id_frm_journal_detail,
        "id_frm_journal"            => $ps['id_frm_journal'],
        "id_frm_journal_period"     => $pst['id_frm_journal_period'],
        "id_frm_account"            => $ps['id_frm_account'],
        "pos"                       => $ps['pos'],
        "nominal"                   => ($ps['pos'] == 2 ? $ps['nominal'] * -1 : $ps['nominal']),
        "note"                      => $ps['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
    }
    if($kirim){
      $this->global_models->insert_batch("frm_journal_detail", $kirim);
      $hasil = array(
        "status"  => 2,
        "data"    => $kirim
      );
    }
    else{
      $hasil = array(
        "status"  => 3,
        "note"    => lang("Fail")
      );
    }
    return $hasil;
  }
  
  function journal_pembalik($data = array(),$source = array()){
      
      return array("status" => 2);
  }
}
?>
