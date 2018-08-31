<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scm_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function outlet_set(){
    $pst = $this->input->post();
    
    if($pst['id_scm_outlet']){
      $kirim = array(
        "title"                     => $pst['title'],
        "alamat"                    => $pst['alamat'],
        "update_by_users"           => $this->session->userdata("id"),
      );

      $this->global_models->update("scm_outlet", array("id_scm_outlet" => $pst['id_scm_outlet']), $kirim);
      $hasil = $pst['id_scm_outlet'];
    }
    else{
      $this->global_models->generate_id($hasil, "scm_outlet");
      $kirim = array(
        "id_scm_outlet"             => $hasil,
        "title"                     => $pst['title'],
        "alamat"                    => $pst['alamat'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      
      $this->global_models->insert("scm_outlet", $kirim);
    }
//    $hasil = 1;
    if($hasil){
      $return['data'] = array(
        $pst['title'],
        "<button class='btn btn-danger btn-sm delete' isi='{$hasil}'><i class='fa fa-times'></i></button>",
      );
      $return['banding']    = $hasil;
      $return['status']     = 2;
    }
    else{
      $return['status']     = 1;
    }
    
    print json_encode($return);
    die;
  }
  
  function outlet_storage_set(){
    $pst = $this->input->post();
    
    if($pst['id_scm_outlet_storage']){
      $kirim = array(
        "title"                     => $pst['title'],
        "type"                      => $pst['type'],
        "note"                    => $pst['note'],
        "update_by_users"           => $this->session->userdata("id"),
      );

      $this->global_models->update("scm_outlet_storage", array("id_scm_outlet_storage" => $pst['id_scm_outlet_storage']), $kirim);
      $hasil = $pst['id_scm_outlet_storage'];
    }
    else{
      $this->global_models->generate_id($hasil, "scm_outlet_storage");
      $kirim = array(
        "id_scm_outlet_storage"     => $hasil,
        "id_scm_outlet"             => $pst['id_scm_outlet'],
        "title"                     => $pst['title'],
        "type"                      => $pst['type'],
        "note"                      => $pst['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      
      $this->global_models->insert("scm_outlet_storage", $kirim);
    }
//    $hasil = 1;
    if($hasil){
      $type = $this->global_variable->scm_storage_type(1);
      $return['data'] = array(
        $pst['title'],
        $type[$pst['type']],
        "<button class='btn btn-danger btn-sm delete-storage' isi='{$hasil}'><i class='fa fa-times'></i></button>",
      );
      $return['banding']    = $hasil;
      $return['status']     = 2;
    }
    else{
      $return['status']     = 1;
    }
    
    print json_encode($return);
    die;
  }
  
  function outlet_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_outlet"
      . " FROM scm_outlet AS A"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->title,
        "<button class='btn btn-danger btn-sm delete' isi='{$da->id_scm_outlet}'><i class='fa fa-times'></i></button>",
      );
      $banding[] = $da->id_scm_outlet;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function outlet_storage_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.type, A.id_scm_outlet_storage"
      . " FROM scm_outlet_storage AS A"
      . " WHERE A.id_scm_outlet = '{$pst['id_scm_outlet']}'"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    $type = $this->global_variable->scm_storage_type(1);
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->title,
        $type[$da->type],
        "<button class='btn btn-danger btn-sm delete-storage' isi='{$da->id_scm_outlet_storage}'><i class='fa fa-times'></i></button>",
      );
      $banding[] = $da->id_scm_outlet_storage;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function outlet_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_outlet, A.alamat"
      . " FROM scm_outlet AS A"
      . " WHERE A.id_scm_outlet = '{$pst['id']}'"
      . "");
      
    $return = array(
      "title"                   => $data[0]->title,
      "alamat"                  => $data[0]->alamat,
      "id_scm_outlet"           => $data[0]->id_scm_outlet,
    );
      
    print json_encode($return);
    die;
  }
  
  function outlet_storage_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_outlet_storage, A.note, A.type"
      . " FROM scm_outlet_storage AS A"
      . " WHERE A.id_scm_outlet_storage = '{$pst['id']}'"
      . "");
      
    $return = array(
      "title"                   => $data[0]->title,
      "type"                    => $data[0]->type,
      "note"                    => $data[0]->note,
      "id_scm_outlet_storage"   => $data[0]->id_scm_outlet_storage,
    );
      
    print json_encode($return);
    die;
  }
  
  function outlet_delete(){
    $this->global_models->delete("scm_outlet", array("id_scm_outlet" => $this->input->post("id")));
    die;
  }
  
  function outlet_storage_delete(){
    $this->global_models->delete("scm_outlet_storage", array("id_scm_outlet_storage" => $this->input->post("id")));
    die;
  }
  
  
  function satuan_group_set(){
    $pst = $this->input->post();
    
    if($pst['id_scm_satuan_group']){
      $kirim = array(
        "title"                     => $pst['title'],
        "note"                      => $pst['note'],
        "update_by_users"           => $this->session->userdata("id"),
      );

      $this->global_models->update("scm_satuan_group", array("id_scm_satuan_group" => $pst['id_scm_satuan_group']), $kirim);
      $hasil = $pst['id_scm_satuan_group'];
    }
    else{
      $this->global_models->generate_id($hasil, "scm_satuan_group");
      $kirim = array(
        "id_scm_satuan_group"       => $hasil,
        "title"                     => $pst['title'],
        "note"                      => $pst['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      
      $this->global_models->insert("scm_satuan_group", $kirim);
    }
//    $hasil = 1;
    if($hasil){
      $return['data'] = array(
        $pst['title'],
        "<button class='btn btn-danger btn-sm delete' isi='{$hasil}'><i class='fa fa-times'></i></button>",
      );
      $return['banding']    = $hasil;
      $return['status']     = 2;
    }
    else{
      $return['status']     = 1;
    }
    
    print json_encode($return);
    die;
  }
  
  function satuan_set(){
    $pst = $this->input->post();
    
    if($pst['id_scm_satuan']){
      $kirim = array(
        "title"                     => $pst['title'],
        "level"                     => $pst['level'],
        "nilai"                     => str_replace(",","",$pst['nilai']),
        "note"                      => $pst['note'],
        "update_by_users"           => $this->session->userdata("id"),
      );

      $this->global_models->update("scm_satuan", array("id_scm_satuan" => $pst['id_scm_satuan']), $kirim);
      $hasil = $pst['id_scm_satuan'];
    }
    else{
      $this->global_models->generate_id($hasil, "scm_satuan");
      $kirim = array(
        "id_scm_satuan"             => $hasil,
        "id_scm_satuan_group"       => $pst['id_scm_satuan_group'],
        "title"                     => $pst['title'],
        "level"                     => $pst['level'],
        "nilai"                     => str_replace(",","",$pst['nilai']),
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      
      $this->global_models->insert("scm_satuan", $kirim);
    }
//    $hasil = 1;
    if($hasil){
      $return['data'] = array(
        $pst['level'],
        $pst['title'],
        "<div style='width: 100%; text-align: right;'>".number_format($pst['nilai'])."</div>",
        "<button class='btn btn-danger btn-sm delete-satuan' isi='{$hasil}'><i class='fa fa-times'></i></button>",
      );
      $return['banding']    = $hasil;
      $return['status']     = 2;
    }
    else{
      $return['status']     = 1;
    }
    
    print json_encode($return);
    die;
  }
  
  function satuan_group_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_satuan_group"
      . " FROM scm_satuan_group AS A"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->title,
        "<button class='btn btn-danger btn-sm delete' isi='{$da->id_scm_satuan_group}'><i class='fa fa-times'></i></button>",
      );
      $banding[] = $da->id_scm_satuan_group;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function satuan_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.level, A.nilai, A.id_scm_satuan"
      . " FROM scm_satuan AS A"
      . " WHERE A.id_scm_satuan_group = '{$pst['id_scm_satuan_group']}'"
      . " ORDER BY A.level ASC LIMIT {$pst['start']}, 20");
    
    foreach ($data AS $da){
      $hasil[] = array(
        $da->level,
        $da->title,
        "<div style='width: 100%; text-align: right;'>".number_format($da->nilai)."</div>",
        "<button class='btn btn-danger btn-sm delete-satuan' isi='{$da->id_scm_satuan}'><i class='fa fa-times'></i></button>",
      );
      $banding[] = $da->id_scm_satuan;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function satuan_group_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_satuan_group, A.note"
      . " FROM scm_satuan_group AS A"
      . " WHERE A.id_scm_satuan_group = '{$pst['id']}'"
      . "");
      
    $return = array(
      "title"                   => $data[0]->title,
      "note"                    => $data[0]->note,
      "id_scm_satuan_group"     => $data[0]->id_scm_satuan_group,
    );
      
    print json_encode($return);
    die;
  }
  
  function satuan_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_satuan, A.note, A.level, A.nilai"
      . " FROM scm_satuan AS A"
      . " WHERE A.id_scm_satuan = '{$pst['id']}'"
      . "");
      
    $return = array(
      "title"                   => $data[0]->title,
      "level"                   => $data[0]->level,
      "nilai"                   => number_format($data[0]->nilai),
      "note"                    => $data[0]->note,
      "id_scm_satuan"           => $data[0]->id_scm_satuan,
    );
      
    print json_encode($return);
    die;
  }
  
  function satuan_group_delete(){
    $this->global_models->delete("scm_satuan_group", array("id_scm_satuan_group" => $this->input->post("id")));
    die;
  }
  
  function satuan_delete(){
    $this->global_models->delete("scm_satuan", array("id_scm_satuan" => $this->input->post("id")));
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */