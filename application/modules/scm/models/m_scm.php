<?php
class M_scm extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function scm_outlet_storage_set($post){
    $this->global_models->generate_id($id_scm_outlet_storage, "scm_outlet_storage");
    $kirim = array(
      "id_scm_outlet_storage"   => $id_scm_outlet_storage,
      "id_scm_outlet"           => $post['id_scm_outlet'],
      "title"                   => $post['title'],
      "type"                    => 1,
      "note"                    => $post['note'],
      "create_by_users"         => $this->session->userdata("id"),
      "create_date"             => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("scm_outlet_storage", $kirim);
    $hasil = array(
      "id"        => $id_scm_outlet_storage,
      "status"    => 2
    );
    return $hasil;
  }
  
  function scm_outlet_storage_update($post, $id_scm_outlet_storage = NULL){
    if($id_scm_outlet_storage){
      $kirim = array(
        "id_scm_outlet"           => $post['id_scm_outlet'],
        "title"                   => $post['title'],
        "note"                    => $post['note'],
        "update_by_users"         => $this->session->userdata("id"),
      );
      $this->global_models->update("scm_outlet_storage", array("id_scm_outlet_storage" => $id_scm_outlet_storage), $kirim);
      $hasil = array(
        "id"        => $id_scm_outlet_storage,
        "status"    => 2
      );
    }
    else{
      $hasil = $this->scm_outlet_storage_set($post);
    }
    
    return $hasil;
  }
  
  function scm_satuan_konversi($type, $qty, $id_scm_satuan){
    
    if($type == 1){
      $scm_satuan_target = $this->global_models->get_query("SELECT A.id_scm_satuan"
      . " FROM scm_satuan AS A"
      . " WHERE A.id_scm_satuan_group = (SELECT B.id_scm_satuan_group FROM scm_satuan AS B WHERE B.id_scm_satuan = '{$id_scm_satuan}')"
      . " AND A.level = 0");
      
      $nilai = $this->global_models->get_field("scm_satuan", "nilai", array("id_scm_satuan" => $id_scm_satuan));
      
      $nilai = $qty * $nilai;
    }
    
    $return = array(
      "nilai"                   => $nilai,
      "id_scm_satuan"           => $scm_satuan_target[0]->id_scm_satuan,
      "satuan"                  => $this->global_models->get_field("scm_satuan", "title", array("id_scm_satuan" => $scm_satuan_target[0]->id_scm_satuan))
    );
    
    return $return;
  }
  
  function cek_session_outlet(){
    if(!$this->session->userdata("scm_outlet")){
      $id_scm_outlet = $this->global_models->get("scm_outlet_users", array("id_users" => $this->session->userdata("id")));
      if($id_scm_outlet){
        if(count($id_scm_outlet) > 1)
          redirect("scm/scm-settings/session-outlet");
        else{
          $this->session->set_userdata(array(
            "scm_outlet"    => $id_scm_outlet[0]->$id_scm_outlet
          ));
          return TRUE;
        }
      }
      else if($this->session->userdata("id") == 1){
        redirect("scm/scm-settings/session-outlet");
      }
      else{
        $this->session->set_flashdata('notice', 'Tidak Ada Hak Akses Outlet');
        redirect($this->session->userdata('dashbord'));
      }
    }
    else{
      return TRUE;
    }
  }
  
  function cek_session_suppliers(){
    if(!$this->session->userdata("scm_procurement_suppliers")){
      $id_scm_procurement_suppliers = $this->global_models->get_field("scm_suppliers_biodata", "id_scm_procurement_suppliers", array("id_users" => $this->session->userdata("id")));
      if($id_scm_procurement_suppliers){
        $this->session->set_userdata(array(
          "scm_procurement_suppliers"    => $id_scm_procurement_suppliers
        ));
        return TRUE;
      }
      else if($this->session->userdata("id") == 1){
        return TRUE;
      }
      else{
        $this->session->set_flashdata('notice', 'Tidak Ada Hak Akses Suppliers');
        redirect($this->session->userdata('dashbord'));
      }
    }
    else{
      return TRUE;
    }
  }
    
}
?>
