<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_siklus_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
    $this->load->model("frm/m_frm");
  }
  
  function transaksi_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM frm_journal AS A"
      . " WHERE A.id_frm_journal_period = '{$pst['id_frm_journal_period']}'"
      . " AND A.status = 1"
      . " ORDER BY A.tanggal DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $detail = $this->global_models->get_query("SELECT A.*"
        . " ,B.title AS account, B.ref"
        . " FROM frm_journal_detail AS A"
        . " LEFT JOIN frm_account AS B ON B.id_frm_account = A.id_frm_account"
        . " WHERE A.id_frm_journal = '{$dt->id_frm_journal}'");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => strtotime($dt->tanggal),
            "class"   => "journal"
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title,
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_journal
      );
      foreach ($detail AS $det){
        $hasil['data'][] = array(
          "data"    => array(
            array(
              "view"    => "",
              "value"   => "",
            ),
//            array(
//              "view"    => $det->note,
//              "value"   => $det->note,
//            ),
            array(
              "view"    => $det->account,
              "value"   => $det->account,
            ),
            array(
              "view"    => "<a href='".site_url("frm/frm-siklus/buku-besar-detail/{$pst['id_frm_journal_period']}/".str_replace(" ", "-", $det->id_frm_account))."'>".$det->ref."</a>",
              "value"   => $det->ref,
            ),
            array(
              "view"    => ($det->pos == 1 ? number_format($det->nominal) : 0),
              "value"   => ($det->pos == 1 ? $det->nominal : 0),
              "class"   => "kanan"
            ),
            array(
              "view"    => ($det->pos == 2 ? number_format($det->nominal * -1) : 0),
              "value"   => ($det->pos == 2 ? ($det->nominal * -1) : 0),
              "class"   => "kanan"
            ),
          ),
          "select"  => false,
          "id"      => $dt->id_frm_journal_detail
        );
      }
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function transaksi_detail_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("frm_journal_detail", array("id_frm_journal_detail" => $pst['id_frm_journal_detail']));
    $return = array(
      "status"  => 2
    );
    print json_encode($return);
    die;
  }
  
  function transaksi_detail_get(){
    $pst = $this->input->post();
    $detail = $this->global_models->get_query("SELECT A.*"
      . " ,B.title AS account, B.ref"
      . " FROM frm_journal_detail AS A"
      . " LEFT JOIN frm_account AS B ON B.id_frm_account = A.id_frm_account"
      . " WHERE A.id_frm_journal = '{$pst['id_frm_journal']}'"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    foreach ($detail AS $det){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $det->create_date,
            "value"   => strtotime($det->create_date),
          ),
          array(
            "view"    => $det->account,
            "value"   => $det->account,
          ),
          array(
            "view"    => "<a href='".site_url("frm/frm-siklus/buku-besar-detail/{$pst['id_frm_journal_period']}/".str_replace(" ", "-", $det->id_frm_account))."'>".$det->ref."</a>",
            "value"   => $det->ref,
          ),
          array(
            "view"    => ($det->pos == 1 ? number_format($det->nominal) : 0),
            "value"   => ($det->pos == 1 ? $det->nominal : 0),
            "class"   => "kanan"
          ),
          array(
            "view"    => ($det->pos == 2 ? number_format($det->nominal * -1) : 0),
            "value"   => ($det->pos == 2 ? ($det->nominal * -1) : 0),
            "class"   => "kanan"
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm detail-delete' isi='{$det->id_frm_journal_detail}'><i class='fa fa-times'></i></button>",
            "value"   => $det->id_frm_journal_detail,
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_journal_detail
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function transaksi_detail_set(){
    $pst = $this->input->post();
    $true = array(
      "true"  => 1,
      "false" => 2
    );
    $frm_journal = $this->m_frm->journal_get($pst['id_frm_journal']);
    $status = 2;
    $this->global_models->trans_begin();
    if($frm_journal['status'] != 2){
      $frm_journal_period = $this->m_frm->journal_period_get($pst['tanggal'], $this->session->userdata("code_users"));
      if($frm_journal_period['status'] == 2){
        $kirim_journal = array(
          "id_frm_journal_period" => $frm_journal_period['data']['id'],
          "title"             => $pst['title'],
          "tanggal"           => $pst['tanggal'],
          "status"            => 5,
          "code_users"        => $this->session->userdata("code_users"),
        );
        $frm_journal = $this->m_frm->journal_set($kirim_journal);
        $status = 2;
      }
      else{
        $status = 3;
        $note =$frm_journal_period['note'];
        $this->global_models->trans_rollback();
      }
    }
    if($status == 2){
      $kirim_detail[] = array(
        "id_frm_journal"    => $frm_journal['data']['id'],
        "id_frm_journal_period" => $frm_journal_period['data']['id'],
        "id_frm_account"    => $pst['id_frm_account'],
        "pos"               => $true[$pst['pos']],
        "nominal"           => $pst['nominal'],
      );
      $frm_journal_detail = $this->m_frm->journal_detail_set($kirim_detail);
      $data = array(
        "id_frm_journal"    => $frm_journal['data']['id']
      );
      $this->global_models->trans_commit();
    }
    
    $return = array(
      "status"  => $status,
      "data"    => $data,
      "note"    => $note,
    );
    print json_encode($return);
    die;
  }
  
  function transaksi_set(){
    $pst = $this->input->post();
    if($pst['id_frm_journal']){
      $frm_journal = $this->global_models->get_query("SELECT SUM(A.nominal) AS jml"
        . " FROM frm_journal_detail AS A"
        . " WHERE A.id_frm_journal = '{$pst['id_frm_journal']}'"
        . "");
      if($frm_journal[0]->jml > 0 OR $frm_journal[0]->jml < 0){
        $status = 3;
        $note   = lang("Not balanced");
      }
      else{
        $kirim = array(
          "status"  => 1,
          "title"   => $pst['title'],
          "note"    => $pst['note'],
          "tanggal" => $pst['tanggal'],
        );
        $this->m_frm->journal_update($kirim, $pst['id_frm_journal']);
        $status = 4;
        $data = $this->transaksi_return_single_record($pst['id_frm_journal']);
      }
    }
    else{
      $status = 3;
      $note   = lang("ID not exist");
    }
    $return = array(
      "status"  => $status,
      "data"    => $data,
      "id"      => $pst['id_frm_journal'],
      "note"    => $note,
    );
    print json_encode($return);
    die;
  }
  
  private function transaksi_return_single_record($id){
    $data = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM frm_journal AS A"
      . " WHERE A.id_frm_journal = '{$id}'"
      . "");
      
    foreach ($data AS $dt){
      $detail = $this->global_models->get_query("SELECT A.*"
        . " ,B.title AS account, B.ref"
        . " FROM frm_journal_detail AS A"
        . " LEFT JOIN frm_account AS B ON B.id_frm_account = A.id_frm_account"
        . " WHERE A.id_frm_journal = '{$dt->id_frm_journal}'");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => strtotime($dt->tanggal),
            "class"   => "journal"
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title,
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
          array(
            "view"    => "",
            "value"   => "",
            "class"   => "journal"
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_journal
      );
      foreach ($detail AS $det){
        $hasil['data'][] = array(
          "data"    => array(
            array(
              "view"    => "",
              "value"   => "",
            ),
            array(
              "view"    => $det->account,
              "value"   => $det->account,
            ),
            array(
              "view"    => "<a href='".site_url("frm/frm-siklus/buku-besar-detail/{$pst['id_frm_journal_period']}/".str_replace(" ", "-", $det->id_frm_account))."'>".$det->ref."</a>",
              "value"   => $det->ref,
            ),
            array(
              "view"    => ($det->pos == 1 ? number_format($det->nominal) : 0),
              "value"   => ($det->pos == 1 ? $det->nominal : 0),
              "class"   => "kanan"
            ),
            array(
              "view"    => ($det->pos == 2 ? number_format($det->nominal * -1) : 0),
              "value"   => ($det->pos == 2 ? ($det->nominal * -1) : 0),
              "class"   => "kanan"
            ),
          ),
          "select"  => false,
          "id"      => $dt->id_frm_journal_detail
        );
      }
    }
    
    return $hasil;
  }
  
  function buku_besar_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM frm_account AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " AND A.is_group = 5"
      . " ORDER BY A.ref ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $detail = $this->global_models->get_query("SELECT SUM(IF(A.pos = 2, A.nominal, 0)) AS credit, SUM(IF(A.pos = 1, A.nominal, 0)) AS debit"
        . " FROM frm_journal_detail AS A"
        . " LEFT JOIN frm_journal AS B ON B.id_frm_journal = A.id_frm_journal"
        . " WHERE A.id_frm_account = '{$dt->id_frm_account}'"
        . " AND A.id_frm_journal_period = '{$pst['id_frm_journal_period']}'"
        . " AND B.status = 1"
        . "");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title,
          ),
          array(
            "view"    => "<a href='".site_url("frm/frm-siklus/buku-besar-detail/".str_replace(" ", "-", $dt->id_frm_account))."'>{$dt->ref}</a>",
            "value"   => $dt->ref,
          ),
          array(
            "view"    => number_format($detail[0]->debit),
            "value"   => $detail[0]->debit,
            "class"   => "kanan",
          ),
          array(
            "view"    => number_format($detail[0]->credit * -1),
            "value"   => $detail[0]->credit,
            "class"   => "kanan",
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_account
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function neraca_saldo_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query(""
      . " SELECT A.*"
      . " ,SUM(B.nominal) AS nominal"
      . " FROM frm_account AS A"
      . " LEFT JOIN frm_journal_detail AS B ON B.id_frm_account = A.id_frm_account"
      . " LEFT JOIN frm_journal AS C ON C.id_frm_journal = B.id_frm_journal"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " AND A.is_group = 5"
      . " AND B.id_frm_journal_period = '{$pst['id_frm_journal_period']}'"
      . " AND C.status = 1"
      . " GROUP BY A.id_frm_account"
      . " ORDER BY A.ref ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title,
          ),
          array(
            "view"    => "<a href='".site_url("frm/frm-siklus/buku-besar-detail/".str_replace(" ", "-", $dt->id_frm_account))."'>{$dt->ref}</a>",
            "value"   => $dt->ref,
          ),
          array(
            "view"    => ($dt->nominal > 0 ? number_format($dt->nominal) : 0),
            "value"   => $dt->nominal,
            "class"   => "kanan",
          ),
          array(
            "view"    => ($dt->nominal < 0 ? number_format($dt->nominal * -1) : 0),
            "value"   => $dt->nominal,
            "class"   => "kanan",
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_account
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function buku_besar_detail_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query(""
      . " SELECT A.pos, A.nominal"
      . " , B.tanggal, B.title"
      . " FROM frm_journal_detail AS A"
      . " LEFT JOIN frm_journal AS B ON B.id_frm_journal = A.id_frm_journal"
      . " WHERE A.id_frm_account = '{$pst['id_frm_account']}'"
      . " AND A.id_frm_journal_period = '{$pst['id_frm_journal_period']}'"
      . " AND B.status = 1"
      . " ORDER BY B.tanggal ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => strtotime($dt->tanggal),
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title,
          ),
          array(
            "view"    => ($dt->pos == 1 ? number_format($dt->nominal) : 0),
            "value"   => (int) $dt->nominal,
            "class"   => "kanan",
          ),
          array(
            "view"    => ($dt->pos == 2 ? number_format($dt->nominal * -1) : 0),
            "value"   => (int) $dt->nominal,
            "class"   => "kanan",
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_account
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function account_dropdown_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM frm_account AS A"
      . " WHERE A.is_group = '5'"
      . " AND A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.id_frm_account ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "text"  => $dt->ref."-".$dt->title,
        "id"    => $dt->id_frm_account
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 4;
    
    print json_encode($hasil);
    die;
  }
  
}