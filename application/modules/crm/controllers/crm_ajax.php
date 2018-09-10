<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crm_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek("json");
    $this->load->library('crm/lokal_variable');
  }
  
  function master_storage_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_storage AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_storage
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
   
  function master_inventory_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.title FROM crm_inventory_groups AS C WHERE C.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,B.hpp, B.id_crm_satuan"
      . " ,(SELECT D.title FROM crm_satuan AS D WHERE D.id_crm_satuan = B.id_crm_satuan) AS satuan"
      . " FROM crm_inventory AS A"
      . " LEFT JOIN crm_storage_inventory AS B ON B.id_crm_inventory = A.id_crm_inventory"
      . " WHERE B.id_crm_storage = '{$pst['id_crm_storage']}'"
      . " AND A.status = 1"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->groups,
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => number_format($dt->hpp)." /".$dt->satuan,
            "value"   => $dt->hpp
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_inventory
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
  
  function stock_rg_set(){
    $pst = $this->input->post();
    
    
    
    $hasil = array(
      "status"  => 2,
      "debug"   => $pst,
    );
    print json_encode($hasil);
    die;
  }
   
}