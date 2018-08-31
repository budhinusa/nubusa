<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function privilege_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_privilege AS A"
      . " WHERE A.parent > 0"
      . " ORDER BY A.name ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $selected = ($dt->id_privilege == $this->session->userdata("id_privilege") ? true : false);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->name,
            "value"   => $dt->name
          ),
          array(
            "view"    => $dt->dashbord,
            "value"   => $dt->dashbord
          ),
        ),
        "select"  => $selected,
        "id"      => $dt->id_privilege
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
  
  function privilege_set(){
    $pst = $this->input->post();
    $this->session->set_userdata(array("id_privilege" => $pst['id']));
    print "Done";die;
  }
   
}