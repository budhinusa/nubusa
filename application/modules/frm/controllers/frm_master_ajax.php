<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek("json");
    $this->load->library('frm/lokal_variable');
    $this->load->model('frm/m_frm_master');
  }
  
  function account_get(){
    $pst = $this->input->post();
    $where = "";
    if($pst['id_parent'])
      $where .= " AND A.id_parent = '{$pst['id_parent']}'";
    else
      $where .= " AND (A.id_parent IS NULL OR A.id_parent = '')";
      
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM frm_account AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " {$where}"
      . " ORDER BY A.id_frm_account ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $position = $this->lokal_variable->frm_account_position(1);
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->ref,
            "value"   => $dt->ref
          ),
          array(
            "view"    => ($dt->is_group == 5 ? $dt->title : "<a href='".site_url("frm/frm-master/coa/{$dt->id_frm_account}")."'>{$dt->title}</a>"),
            "value"   => $dt->title
          ),
          array(
            "view"    => $position[$dt->position],
            "value"   => $dt->position
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
  
  function account_turunan_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM frm_account AS A"
      . " WHERE A.id_parent = '{$pst['id_parent']}'"
      . " ORDER BY A.id_frm_account ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $position = $this->global_variable->frm_account_position(1);
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->id_frm_account,
            "value"   => $dt->id_frm_account
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $position[$dt->position],
            "value"   => $dt->position
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
  
  function categories_delete(){
    $pst = $this->input->post();
    $this->global_models->update("site_transport_products_categories", array("id_site_transport_products_categories" => $pst['id']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $balik['data'] = $this->_categories_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function categories_active(){
    $pst = $this->input->post();
    $this->global_models->update("site_transport_products_categories", array("id_site_transport_products_categories" => $pst['id']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
    $balik['data']  = $this->_categories_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function account_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("frm_account", array("id_frm_account" => $pst['id_frm_account']));
    
    if($data[0]->level == 5){
      $data_account_json = $this->nbscache->get("frmtrans_account");
      $data_account = json_decode($data_account_json);
      $id_frm_account = str_replace(" ", "", $data[0]->id_frm_account);
    }
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"           => $data[0]->title,
        "position"        => $data[0]->position,
        "pos"             => $data[0]->pos,
        "code"            => $data[0]->code,
        "id_frm_account"  => $data[0]->id_frm_account,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function account_set(){
    $pst = $this->input->post();
    $id_frm_account = $this->global_models->get_field("frm_account", "id_frm_account", array("id_frm_account" => $pst['id_frm_account'], "code" => $pst['code']));
    if($id_frm_account){
      $kirim = array(
        "title"             => $pst['title'],
        "position"          => $pst['position'],
        "is_group"          => $pst['is_group'],
        "pos"               => $pst['pos'],
        "update_by_users"   => $this->session->userdata("id"),
        "update_date"       => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("frm_account", array("id_frm_account" => $id_frm_account), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    else{
      $jml_digit = $this->lokal_variable->frm_account_jumlah_digit();
      $code = $this->m_frm_master->frm_account_code($pst['code'], $pst['id_parent'], $jml_digit[$pst['is_group']]);
      if($code['status'] == 2){
        $kirim = array(
          "id_frm_account"    => $this->session->userdata("code_users").$code['data']['nomor'],
          "ref"               => $code['data']['nomor'],
          "id_parent"         => $pst['id_parent'],
          "code_users"        => $this->session->userdata("code_users"),
          "code"              => $pst['code'],
          "title"             => $pst['title'],
          "position"          => $pst['position'],
          "status"            => 1,
          "is_group"          => $pst['is_group'],
          "pos"               => $pst['pos'],
          "create_by_users"   => $this->session->userdata("id"),
          "create_date"       => date("Y-m-d H:i:s")
        );
        $this->global_models->trans_begin();
        $this->global_models->insert("frm_account", $kirim);
        $id_frm_account = $this->session->userdata("code_users").$code['data']['nomor'];
        $this->global_models->trans_commit();
        $status = 2;
      }
      else{
        $status = 3;
        $note = $code['note'];
      }
    }
    $balik['data'] = $this->account_format_single_record($id_frm_account);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function code_account($level, $id_frm_account, $code){
    $parent = $id_frm_account[($level-1)];
    $id = $parent." ".$code;
    return array(
      "parent"        => $parent,
      "id_frm_account"=> $id,
      "position"      => $this->global_models->get_field("frm_account", "position", array("id_frm_account" => $parent))
    );
  }
  
  function account_turunan_set(){
    $pst = $this->input->post();
    $account = array(
      1 => $pst['id_frm_account'],
      2 => $pst['id_frm_account2'],
      3 => $pst['id_frm_account3'],
      4 => $pst['id_frm_account4'],
      5 => $pst['id_frm_account5'],
    );
    if($pst['level'] > 2){
      $pst['code'] = str_pad($pst['code'], 2, "0", STR_PAD_LEFT);
    }
    $current = $this->code_account($pst['level'], $account, $pst['code']);
//    $this->debug($current, true);
    $frm_account = $this->global_models->get("frm_account", array("id_frm_account" => $current['id_frm_account']));
    $id_frm_account = $frm_account[0]->id_frm_account;
    if($id_frm_account){
      $kirim = array(
        "title"             => $pst['title'],
        "position"          => $current['position'],
        "update_by_users"   => $this->session->userdata("id"),
      );
      $this->global_models->trans_begin();
      $this->global_models->update("frm_account", array("id_frm_account" => $id_frm_account), $kirim);
      $this->global_models->trans_commit();
    }
    else{
      
      $kirim = array(
        "id_frm_account"    => $current['id_frm_account'],
        "id_parent"         => $current['parent'],
        "title"             => $pst['title'],
        "code"              => $pst['code'],
        "position"          => $current['position'],
        "level"             => $pst['level'],
        "status"            => 1,
        "create_by_users"   => $this->session->userdata("id"),
        "create_date"       => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("frm_account", $kirim);
      $id_frm_account = $current['id_frm_account'];
      $this->global_models->trans_commit();
    }
    
    $balik['data'] = $this->_account_format_single_record($id_frm_account);
    $balik['level'] = ($frm_account[0]->level ? $frm_account[0]->level : $pst['level']);
    $balik['status'] = 2;
    
    if($balik['level'] == 5){
      $data_account_json = $this->nbscache->get("frmtrans_account");
      $data_account = json_decode($data_account_json);
      $spaceless = str_replace(" ", "", $id_frm_account);
      $data_account->account_id->{$spaceless}->acc_id = $pst['acc_id'];

      $data_account_json = json_encode($data_account);
      $this->nbscache->put_all("frmtrans_account", $data_account_json);
    }
    
    print json_encode($balik);
    die;
  }
  
  private function account_format_single_record($id){
    $data = $this->global_models->get("frm_account", array("id_frm_account" => $id));
    $position = $this->lokal_variable->frm_account_position(1);
    $dt = $data[0];
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->ref,
            "value"   => $dt->ref
          ),
          array(
            "view"    => ($dt->is_group == 5 ? $dt->title : "<a href='".site_url("frm/frm-master/coa/{$dt->id_frm_account}")."'>{$dt->title}</a>"),
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $position[$dt->position],
            "value"   => $dt->position
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function period_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM frm_journal_period AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.tahun DESC, A.bulan DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $bulan = $this->global_variable->bulan(1);
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => "<a href='".site_url("frm/frm-siklus/transaksi/{$dt->id_frm_journal_period}")."'>{$dt->title}</a>",
            "value"   => $dt->title
          ),
          array(
            "view"    => $bulan[$dt->bulan]." ".$dt->tahun,
            "value"   => $bulan[$dt->bulan]." ".$dt->tahun
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_frm_journal_period
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
  
  function period_set(){
    $pst = $this->input->post();
    $frm_journal_period = $this->global_models->get("frm_journal_period", array("bulan" => $pst['bulan'], "tahun" => $pst['tahun']));
    if($frm_journal_period){
      $return = array(
        "status"    => 3,
        "note"      => lang("Already exist")
      );
    }
    else{
      $this->global_models->generate_id($id_frm_journal_period, "frm_journal_period");
      $tanggal = $pst['tahun']."-{$pst['bulan']}-01";
      $kirim = array(
        "id_frm_journal_period"     => $id_frm_journal_period,
        "code_users"                => $this->session->userdata("code_users"),
        "title"                     => $pst['title'],
        "code"                      => date("Ym", strtotime($tanggal)),
        "startdate"                 => date("Y-m-d 00:00:00", strtotime($tanggal)),
        "enddate"                   => date("Y-m-t 23:59:59", strtotime($tanggal)),
        "bulan"                     => date("m", strtotime($tanggal)),
        "tahun"                     => date("Y", strtotime($tanggal)),
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("frm_journal_period", $kirim);
      $return = array(
        "status"    => 2,
        "data"      => $this->period_format_single_record($id_frm_journal_period)
      );
    }
    print json_encode($return);
    die;
  }
  
  private function period_format_single_record($id){
    $data = $this->global_models->get("frm_journal_period", array("id_frm_journal_period" => $id));
    $bulan = $this->global_variable->bulan(1);
    $dt = $data[0];
    $balik  = array(
      "data"    => array(
        array(
          "view"    => $dt->code,
          "value"   => $dt->code
        ),
        array(
          "view"    => "<a href='".site_url("frm/frm-siklus/transaksi/{$dt->id_frm_journal_period}")."'>{$dt->title}</a>",
          "value"   => $dt->title
        ),
        array(
          "view"    => $bulan[$dt->bulan]." ".$dt->tahun,
          "value"   => $bulan[$dt->bulan]." ".$dt->tahun
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    return $balik;
  }
  
}