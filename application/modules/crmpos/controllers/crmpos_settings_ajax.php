<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crmpos_settings_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek("json");
  }
  
  function inventory_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_inventory_groups AS B WHERE B.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,(SELECT C.title FROM crm_satuan_groups AS C WHERE C.id_crm_satuan_groups = A.id_crm_satuan_groups) AS satuan"
      . " FROM crm_inventory AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
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
            "value"   => $dt->groups,
          ),
          array(
            "view"    => $dt->satuan,
            "value"   => $dt->satuan,
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
  
  function inventory_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_inventory", array("id_crm_inventory" => $pst['id_crm_inventory']));
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"                   => $data[0]->title,
        "id_crm_inventory_groups" => $data[0]->id_crm_inventory_groups,
        "id_crm_satuan_groups"    => $data[0]->id_crm_satuan_groups,
        "code"                    => $data[0]->code,
        "note"                    => $data[0]->note,
        "id_crm_inventory"        => $data[0]->id_crm_inventory,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function inventory_price_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crmpos_inventory_price AS A"
      . " WHERE A.id_crm_inventory = '{$pst['id_crm_inventory']}'"
      . " ORDER BY A.startdate DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->startdate,
            "value"   => strtotime($dt->startdate)
          ),
          array(
            "view"    => $dt->enddate,
            "value"   => strtotime($dt->enddate)
          ),
          array(
            "view"    => number_format($dt->nominal),
            "value"   => $dt->nominal,
            "class"   => "kanan"
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crmpos_inventory_price,
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crmpos_inventory_price
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
  
  function inventory_price_set(){
    $pst = $this->input->post();
    if($pst['id_crm_inventory'] AND $pst['nominal']){
      $this->global_models->generate_id($id_crmpos_inventory_price, "crmpos_inventory_price");
      $kirim = array(
        "id_crmpos_inventory_price" => $id_crmpos_inventory_price,
        "id_crm_inventory"          => $pst['id_crm_inventory'],
        "startdate"                 => date("Y-m-d H:i:s"),
        "nominal"                   => str_replace(',','', $pst['nominal']),
        "note"                      => $pst['note'],
        "status"                    => 1,
        "update_by_users"           => $this->session->userdata("id"),
        "update_date"               => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crmpos_inventory_price", array("status" => 1, "id_crm_inventory" => $pst['id_crm_inventory']), array(
        "status"          => 2,
        "enddate"         => date("Y-m-d H:i:s"),
        "update_by_users" => $this->session->userdata("id"),
        "update_date"     => date("Y-m-d H:i:s"),
      ));
      $this->global_models->insert("crmpos_inventory_price", $kirim);
      $this->global_models->trans_commit();
      $status = 4;
    }
    else{
      $status = 3;
      $note = lang("Fail");
    }
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
}