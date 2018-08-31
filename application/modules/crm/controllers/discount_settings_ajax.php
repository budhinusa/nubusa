<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount_settings_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function settings_discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_approval_settings AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm discount-delete' isi='{$dt->id_crm_pos_approval_settings}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm discount-active' isi='{$dt->id_crm_pos_approval_settings}'><i class='fa fa-check'></i></button>");
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => "{$status[$dt->status]}",
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_approval_settings
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
  
  function privilege_settings_discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.nilai, A.id_crm_pos_approval_privilege"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM crm_pos_approval_privilege AS A"
      . " WHERE A.id_crm_pos_approval_settings = '{$pst['id_crm_pos_approval_settings']}'"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm privilege-delete' isi='{$dt->id_crm_pos_approval_privilege}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->privilege,
            "value"   => $dt->privilege
          ),
          array(
            "view"    => number_format($dt->nilai),
            "value"   => $dt->nilai,
            "class"   => "kanan",
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_approval_privilege
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
  
  function settings_discount_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_pos_approval_settings", array("id_crm_pos_approval_settings" => $pst['id']));
    $balik = array(
      "title"                                 => $data[0]->title,
      "id_crm_pos_approval_settings"  => $data[0]->id_crm_pos_approval_settings
    );
    print json_encode($balik);
    die;
  }
  
  function settings_discount_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_approval_settings", array("id_crm_pos_approval_settings" => $pst['id']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id")
    ));
    $balik['data'] = $this->_settings_discount_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function privilege_settings_discount_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("crm_pos_approval_privilege", array("id_crm_pos_approval_privilege" => $pst['id']));
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function settings_discount_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_approval_settings", array("id_crm_pos_approval_settings" => $pst['id']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id")
    ));
    $balik['data'] = $this->_settings_discount_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function settings_discount_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_approval_settings']){
      $kirim = array(
        "title"                 => $pst['title'],
        "update_by_users"       => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_approval_settings", array("id_crm_pos_approval_settings" => $pst['id_crm_pos_approval_settings']), $kirim);
      $id_crm_pos_approval_settings = $pst['id_crm_pos_approval_settings'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_approval_settings, "crm_pos_approval_settings");
      $kirim = array(
        "id_crm_pos_approval_settings"  => $id_crm_pos_approval_settings,
        "title"                                 => $pst['title'],
        "status"                                => 1,
        "create_by_users"                       => $this->session->userdata("id"),
        "create_date"                           => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_approval_settings", $kirim);
    }
    
    $balik['data'] = $this->_settings_discount_format_single_record($id_crm_pos_approval_settings);
    print json_encode($balik);
    die;
  }
  
  function privilege_settings_discount_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_approval_privilege']){
      $kirim = array(
        "nilai"                          => $pst['nilai'],
        "id_privilege"                   => $pst['id_privilege'],
        "update_by_users"       => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_approval_privilege", array("id_crm_pos_approval_privilege" => $pst['id_crm_pos_approval_privilege']), $kirim);
      $id_crm_pos_approval_privilege = $pst['id_crm_pos_approval_privilege'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_approval_privilege, "crm_pos_approval_privilege");
      $kirim = array(
        "id_crm_pos_approval_privilege"  => $id_crm_pos_approval_privilege,
        "id_crm_pos_approval_settings"  => $pst['id_crm_pos_approval_settings'],
        "nilai"                          => $pst['nilai'],
        "id_privilege"                   => $pst['id_privilege'],
        "create_by_users"                => $this->session->userdata("id"),
        "create_date"                    => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_approval_privilege", $kirim);
    }
    
    $balik['data'] = $this->_privilege_settings_discount_format_single_record($id_crm_pos_approval_privilege);
    print json_encode($balik);
    die;
  }
  
  function _settings_discount_format_single_record($id){
    $data = $this->global_models->get("crm_pos_approval_settings", array("id_crm_pos_approval_settings" => $id));
    $status = $this->global_variable->status(1);
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm discount-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm discount-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => "{$status[$data[0]->status]}",
            "value"   => $data[0]->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function _privilege_settings_discount_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.id_crm_pos_approval_privilege, A.nilai"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM crm_pos_approval_privilege AS A"
      . " WHERE id_crm_pos_approval_privilege = '{$id}'");
    $status = $this->global_variable->status(1);
    $button = "<button class='btn btn-danger btn-sm privilege-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->privilege,
            "value"   => $data[0]->privilege
          ),
          array(
            "view"    => number_format($data[0]->nilai),
            "value"   => $data[0]->nilai,
            "class"   => "kanan",
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
}