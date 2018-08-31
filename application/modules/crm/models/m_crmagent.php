<?php
class M_crmagent extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function session_agent_cek(){
    if($this->session->userdata("crm_agent")){
      $hasil = array(
        "status"  => 2
      );
    }
    else{
      $id_crm_agent = $this->global_models->get_field("crm_agent", "id_crm_agent", array("id_users" => $this->session->userdata("id")));
      if($id_crm_agent){
        $this->session->set_userdata(array(
          "crm_agent"    => $id_crm_agent
        ));
        $hasil = array(
          "status"  => 2
        );
      }
      else{
         $hasil = array(
          "status"  => 2
        );
      }
    }
    return $hasil;
  }
}
  