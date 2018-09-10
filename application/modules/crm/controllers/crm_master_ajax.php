<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crm_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek("json");
    $this->load->library('crm/lokal_variable');
  }
  
  function inventory_groups_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_inventory_groups AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.kode ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm groups-delete' isi='{$dt->id_crm_inventory_groups}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm groups-active' isi='{$dt->id_crm_inventory_groups}'><i class='fa fa-check'></i></button>");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_inventory_groups
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_inventory_groups
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_inventory_groups
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
  
  function inventory_groups_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_inventory_groups", array("id_crm_inventory_groups" => $pst['id_crm_inventory_groups']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->inventory_groups_format_single_record($pst['id_crm_inventory_groups']);
    print json_encode($balik);
    die;
  }
  
  function inventory_groups_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_inventory_groups", array("id_crm_inventory_groups" => $pst['id_crm_inventory_groups']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->inventory_groups_format_single_record($pst['id_crm_inventory_groups']);
    print json_encode($balik);
    die;
  }
  
  function inventory_groups_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_inventory_groups", array("id_crm_inventory_groups" => $pst['id_crm_inventory_groups']));
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"                   => $data[0]->title,
        "kode"                    => $data[0]->kode,
        "id_crm_inventory_groups" => $data[0]->id_crm_inventory_groups,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function inventory_groups_set(){
    $pst = $this->input->post();
    if($pst['id_crm_inventory_groups']){
      $kirim = array(
        "title"             => $pst['title'],
        "kode"              => $pst['kode'],
        "update_by_users"   => $this->session->userdata("id"),
        "update_date"       => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crm_inventory_groups", array("id_crm_inventory_groups" => $pst['id_crm_inventory_groups']), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
      $id_crm_inventory_groups = $pst['id_crm_inventory_groups'];
    }
    else{
      $this->global_models->generate_id($id_crm_inventory_groups, "crm_inventory_groups");
      $kirim = array(
        "id_crm_inventory_groups" => $id_crm_inventory_groups,
        "title"                   => $pst['title'],
        "code_users"              => $this->session->userdata("code_users"),
        "kode"                    => $pst['kode'],
        "status"                  => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("crm_inventory_groups", $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    $balik['data'] = $this->inventory_groups_format_single_record($id_crm_inventory_groups);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function inventory_groups_format_single_record($id){
    $data = $this->global_models->get("crm_inventory_groups", array("id_crm_inventory_groups" => $id));
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm groups-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm groups-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_inventory_groups
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_inventory_groups
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function satuan_groups_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_satuan_groups AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm groups-delete' isi='{$dt->id_crm_satuan_groups}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm groups-active' isi='{$dt->id_crm_satuan_groups}'><i class='fa fa-check'></i></button>");
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
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan_groups
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_satuan_groups
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_satuan_groups
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
  
  function satuan_groups_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_satuan_groups", array("id_crm_satuan_groups" => $pst['id_crm_satuan_groups']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->satuan_groups_format_single_record($pst['id_crm_satuan_groups']);
    print json_encode($balik);
    die;
  }
  
  function satuan_groups_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_satuan_groups", array("id_crm_satuan_groups" => $pst['id_crm_satuan_groups']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->satuan_groups_format_single_record($pst['id_crm_satuan_groups']);
    print json_encode($balik);
    die;
  }
  
  function satuan_groups_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_satuan_groups", array("id_crm_satuan_groups" => $pst['id_crm_satuan_groups']));
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"                   => $data[0]->title,
        "code"                    => $data[0]->code,
        "id_crm_satuan_groups"    => $data[0]->id_crm_satuan_groups,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function satuan_groups_set(){
    $pst = $this->input->post();
    if($pst['id_crm_satuan_groups']){
      $kirim = array(
        "title"             => $pst['title'],
        "code"              => $pst['code'],
        "update_by_users"   => $this->session->userdata("id"),
        "update_date"       => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crm_satuan_groups", array("id_crm_satuan_groups" => $pst['id_crm_satuan_groups']), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
      $id_crm_satuan_groups = $pst['id_crm_satuan_groups'];
    }
    else{
      $this->global_models->generate_id($id_crm_satuan_groups, "crm_satuan_groups");
      $kirim = array(
        "id_crm_satuan_groups"    => $id_crm_satuan_groups,
        "title"                   => $pst['title'],
        "code_users"              => $this->session->userdata("code_users"),
        "code"                    => $pst['code'],
        "status"                  => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("crm_satuan_groups", $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    $balik['data'] = $this->satuan_groups_format_single_record($id_crm_satuan_groups);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function satuan_groups_format_single_record($id){
    $data = $this->global_models->get("crm_satuan_groups", array("id_crm_satuan_groups" => $id));
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm groups-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm groups-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    $balik  = array(
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
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan_groups
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_satuan_groups
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function satuan_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_satuan AS A"
      . " WHERE A.id_crm_satuan_groups = '{$pst['id_crm_satuan_groups']}'"
      . " ORDER BY A.level ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm satuan-delete' isi='{$dt->id_crm_satuan}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm satuan-active' isi='{$dt->id_crm_satuan}'><i class='fa fa-check'></i></button>");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->level,
            "value"   => $dt->level
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => number_format($dt->nilai),
            "value"   => $dt->title,
            "class"   => "kanan",
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_satuan
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_satuan
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
  
  function satuan_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_satuan", array("id_crm_satuan" => $pst['id_crm_satuan']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->satuan_format_single_record($pst['id_crm_satuan']);
    print json_encode($balik);
    die;
  }
  
  function satuan_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_satuan", array("id_crm_satuan" => $pst['id_crm_satuan']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->satuan_format_single_record($pst['id_crm_satuan']);
    print json_encode($balik);
    die;
  }
  
  function satuan_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_satuan", array("id_crm_satuan" => $pst['id_crm_satuan']));
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"                   => $data[0]->title,
        "nilai"                   => $data[0]->nilai,
        "level"                   => $data[0]->level,
        "id_crm_satuan"           => $data[0]->id_crm_satuan_groups,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function satuan_set(){
    $pst = $this->input->post();
    if($pst['id_crm_satuan']){
      $kirim = array(
        "title"             => $pst['title'],
        "nilai"             => $pst['nilai'],
        "level"             => $pst['level'],
        "update_by_users"   => $this->session->userdata("id"),
        "update_date"       => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crm_satuan", array("id_crm_satuan" => $pst['id_crm_satuan']), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
      $id_crm_satuan = $pst['id_crm_satuan'];
    }
    else{
      $this->global_models->generate_id($id_crm_satuan, "crm_satuan");
      $kirim = array(
        "id_crm_satuan"           => $id_crm_satuan,
        "id_crm_satuan_groups"    => $pst['id_crm_satuan_groups'],
        "title"                   => $pst['title'],
        "nilai"                   => $pst['nilai'],
        "level"                   => $pst['level'],
        "status"                  => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("crm_satuan", $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    $balik['data'] = $this->satuan_format_single_record($id_crm_satuan);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function satuan_format_single_record($id){
    $data = $this->global_models->get("crm_satuan", array("id_crm_satuan" => $id));
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm satuan-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm satuan-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->level,
            "value"   => $dt->level
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->nilai,
            "value"   => $dt->nilai,
            "class"   => "kanan",
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_satuan
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function inventory_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_inventory_groups AS B WHERE B.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,(SELECT C.title FROM crm_satuan_groups AS C WHERE C.id_crm_satuan_groups = A.id_crm_satuan_groups) AS satuan"
      . " FROM crm_inventory AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm inv-delete' isi='{$dt->id_crm_inventory}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm inv-active' isi='{$dt->id_crm_inventory}'><i class='fa fa-check'></i></button>");
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
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_inventory
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
  
  function inventory_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_inventory", array("id_crm_inventory" => $pst['id_crm_inventory']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->inventory_format_single_record($pst['id_crm_inventory']);
    print json_encode($balik);
    die;
  }
  
  function inventory_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_inventory", array("id_crm_inventory" => $pst['id_crm_inventory']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->inventory_format_single_record($pst['id_crm_inventory']);
    print json_encode($balik);
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
  
  function inventory_set(){
    $pst = $this->input->post();
    if($pst['id_crm_inventory']){
      $kirim = array(
        "title"                   => $pst['title'],
        "code"                    => $pst['code'],
        "note"                    => $pst['note'],
        "id_crm_inventory_groups" => $pst['id_crm_inventory_groups'],
        "id_crm_satuan_groups"    => $pst['id_crm_satuan_groups'],
        "update_by_users"         => $this->session->userdata("id"),
        "update_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crm_inventory", array("id_crm_inventory" => $pst['id_crm_inventory']), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
      $id_crm_inventory = $pst['id_crm_inventory'];
    }
    else{
      $this->global_models->generate_id($id_crm_inventory, "crm_inventory");
      $kirim = array(
        "id_crm_inventory"        => $id_crm_inventory,
        "id_crm_satuan_groups"    => $pst['id_crm_satuan_groups'],
        "id_crm_inventory_groups" => $pst['id_crm_inventory_groups'],
        "code_users"              => $this->session->userdata("code_users"),
        "title"                   => $pst['title'],
        "code"                    => $pst['code'],
        "note"                    => $pst['note'],
        "status"                  => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("crm_inventory", $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    $balik['data'] = $this->inventory_format_single_record($id_crm_inventory);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function inventory_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_inventory_groups AS B WHERE B.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,(SELECT C.title FROM crm_satuan_groups AS C WHERE C.id_crm_satuan_groups = A.id_crm_satuan_groups) AS satuan"
      . " FROM crm_inventory AS A"
      . " WHERE A.id_crm_inventory = '{$id}'"
      . "");
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm inv-delete' isi='{$dt->id_crm_inventory}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm inv-active' isi='{$dt->id_crm_inventory}'><i class='fa fa-check'></i></button>");
    $balik  = array(
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
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_inventory
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  
  function storage_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_storage AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm stdr-delete' isi='{$dt->id_crm_storage}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm stdr-active' isi='{$dt->id_crm_storage}'><i class='fa fa-check'></i></button>");
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
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_storage
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
  
  function storage_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_storage", array("id_crm_storage" => $pst['id_crm_storage']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->storage_format_single_record($pst['id_crm_storage']);
    print json_encode($balik);
    die;
  }
  
  function storage_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_storage", array("id_crm_storage" => $pst['id_crm_storage']), array(
      "status"          => 1,
      "update_by_users" => $this->session->userdata("id"),
      "update_date"     => date("Y-m-d H:i:s")
      ));
    $balik['status'] = 2;
    $balik['data'] = $this->storage_format_single_record($pst['id_crm_storage']);
    print json_encode($balik);
    die;
  }
  
  function storage_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_storage", array("id_crm_storage" => $pst['id_crm_storage']));
    
    $hasil = array(
      "status" => 2,
      "data"   => array(
        "title"                   => $data[0]->title,
        "code"                    => $data[0]->code,
        "note"                    => $data[0]->note,
        "id_crm_storage"          => $data[0]->id_crm_storage,
      )
    );
    print json_encode($hasil);
    die;
  }
  
  function storage_set(){
    $pst = $this->input->post();
    if($pst['id_crm_storage']){
      $kirim = array(
        "title"                   => $pst['title'],
        "code"                    => $pst['code'],
        "note"                    => $pst['note'],
        "update_by_users"         => $this->session->userdata("id"),
        "update_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->update("crm_storage", array("id_crm_storage" => $pst['id_crm_storage']), $kirim);
      $this->global_models->trans_commit();
      $status = 2;
      $id_crm_storage = $pst['id_crm_storage'];
    }
    else{
      $this->global_models->generate_id($id_crm_storage, "crm_storage");
      $kirim = array(
        "id_crm_storage"          => $id_crm_storage,
        "code_users"              => $this->session->userdata("code_users"),
        "title"                   => $pst['title'],
        "code"                    => $pst['code'],
        "note"                    => $pst['note'],
        "status"                  => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("crm_storage", $kirim);
      $this->global_models->trans_commit();
      $status = 2;
    }
    $balik['data'] = $this->storage_format_single_record($id_crm_storage);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  private function storage_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_storage AS A"
      . " WHERE A.id_crm_storage = '{$id}'"
      . "");
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm stdr-delete' isi='{$dt->id_crm_storage}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm stdr-active' isi='{$dt->id_crm_storage}'><i class='fa fa-check'></i></button>");
    $balik  = array(
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
            "view"    => $status[$dt->status],
            "value"   => $dt->id_crm_satuan
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_storage
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function master_inventory_get(){
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
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = "<button class='btn btn-info btn-sm inventory-set' isi='{$dt->id_crm_inventory}'><i class='fa fa-check'></i></button>";
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
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_inventory
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
  
  function storage_inventory_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_inventory_groups AS B WHERE B.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,D.id_crm_storage_inventory, D.hpp, D.id_crm_satuan"
      . " FROM crm_storage_inventory AS D"
      . " LEFT JOIN crm_inventory AS A ON A.id_crm_inventory = D.id_crm_inventory"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " AND A.status = 1"
      . " AND D.id_crm_storage = '{$pst['id_crm_storage']}'"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $data_satuan = $this->global_models->get_query("SELECT A.id_crm_satuan, A.title"
        . " FROM crm_satuan AS A"
        . " WHERE A.status = 1"
        . " AND A.id_crm_satuan_groups = '{$dt->id_crm_satuan_groups}'"
        . " ORDER BY A.level ASC");
        
      foreach ($data_satuan AS $ds){
        $satuan[$ds->id_crm_satuan] = $ds->title;
      }
      
      $button = ""
        . "<button class='btn btn-info btn-sm inventory-hpp' isi='{$dt->id_crm_storage_inventory}'><i class='fa fa-save'></i></button>"
        . "<button class='btn btn-danger btn-sm inventory-unset' isi='{$dt->id_crm_storage_inventory}'><i class='fa fa-times'></i></button>";
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code."<br />".$dt->title,
            "value"   => $dt->code."<br />".$dt->title
          ),
          array(
            "view"    => $dt->groups,
            "value"   => $dt->groups,
          ),
          array(
            "view"    => "<input type='text' value='{$dt->hpp}' class='form-control input-sm' id='hpp-{$dt->id_crm_storage_inventory}' />",
            "value"   => $dt->hpp,
          ),
          array(
            "view"    => $this->form_eksternal->form_dropdown('', $satuan, array($dt->id_crm_satuan), "class='form-control input-sm' id='satuan-{$dt->id_crm_storage_inventory}'"),
            "value"   => $dt->id_crm_satuan_groups,
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_storage_inventory
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_storage_inventory
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
  
  function storage_inventory_set(){
    $pst = $this->input->post();
    if($pst['id_crm_storage'] AND $pst['id_crm_inventory']){
      $id_crm_storage_inventory = $this->global_models->get_field("crm_storage_inventory", "id_crm_storage_inventory", array("id_crm_storage" => $pst['id_crm_storage'], "id_crm_inventory" => $pst['id_crm_inventory']));
      if($id_crm_storage_inventory){
        $status = 3;
        $note = lang("Inventory already in storage");
      }
      else{
        $this->global_models->generate_id($id_crm_storage_inventory, "crm_storage_inventory");
        $kirim = array(
          "id_crm_storage_inventory"  => $id_crm_storage_inventory,
          "id_crm_storage"            => $pst['id_crm_storage'],
          "id_crm_inventory"          => $pst['id_crm_inventory'],
          "status"                    => 1,
          "create_by_users"           => $this->session->userdata("id"),
          "create_date"               => date("Y-m-d H:i:s")
        );
        $this->global_models->trans_begin();
        $this->global_models->insert("crm_storage_inventory", $kirim);
        $this->global_models->trans_commit();
        $status = 2;
      }
    }
    else{
      $status = 3;
      $note = lang("Fail");
    }
    $balik['data'] = $this->storage_inventory_format_single_record($id_crm_storage_inventory);
    $balik['status'] = $status;
    $balik['note'] = $note;
    print json_encode($balik);
    die;
  }
  
  function storage_inventory_unset(){
    $pst = $this->input->post();
    if($pst['id_crm_storage_inventory']){
      $this->global_models->trans_begin();
      $this->global_models->delete("crm_storage_inventory", array("id_crm_storage_inventory" => $pst['id_crm_storage_inventory']));
      $this->global_models->trans_commit();
      $status = 2;
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
  
  function storage_inventory_hpp(){
    $pst = $this->input->post();
    if($pst['id_crm_storage_inventory']){
      $this->global_models->trans_begin();
      $this->global_models->update("crm_storage_inventory", array("id_crm_storage_inventory" => $pst['id_crm_storage_inventory']), array(
        "hpp"             => $pst['hpp'],
        "id_crm_satuan"   => $pst['id_crm_satuan'],
        "update_by_users" => $this->session->userdata("id"),
        "update_date"     => date("Y-m-d H:i:s"),
      ));
      $this->global_models->trans_commit();
      $status = 2;
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
  
  private function storage_inventory_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_inventory_groups AS B WHERE B.id_crm_inventory_groups = A.id_crm_inventory_groups) AS groups"
      . " ,(SELECT C.title FROM crm_satuan_groups AS C WHERE C.id_crm_satuan_groups = A.id_crm_satuan_groups) AS satuan"
      . " ,D.id_crm_storage_inventory"
      . " FROM crm_storage_inventory AS D"
      . " LEFT JOIN crm_inventory AS A ON A.id_crm_inventory = D.id_crm_inventory"
      . " WHERE D.id_crm_storage_inventory = '{$id}'"
      . "");
    $dt = $data[0];
    $button = ""
        . "<button class='btn btn-info btn-sm inventory-hpp' isi='{$dt->id_crm_storage_inventory}'><i class='fa fa-save'></i></button>"
        . "<button class='btn btn-danger btn-sm inventory-unset' isi='{$dt->id_crm_storage_inventory}'><i class='fa fa-times'></i></button>";
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->code."<br />".$dt->title,
            "value"   => $dt->code."<br />".$dt->title
          ),
          array(
            "view"    => $dt->groups,
            "value"   => $dt->groups,
          ),
          array(
            "view"    => "<input type='text' value='{$dt->hpp}' class='form-control input-sm' id='hpp-{$dt->id_crm_storage_inventory}' />",
            "value"   => $dt->hpp,
          ),
          array(
            "view"    => $this->form_eksternal->form_dropdown('', $satuan, array($dt->id_crm_satuan), "class='form-control input-sm' id='satuan-{$dt->id_crm_storage_inventory}'"),
            "value"   => $dt->id_crm_satuan_groups,
          ),
          array(
            "view"    => $button,
            "value"   => $dt->id_crm_storage_inventory
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
}