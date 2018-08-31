<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetsetting_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  function v1(){
    $v = "v1";
    $this->global_models->query("");
    
//    wajib
    $this->global_models->update("m_module", array("name" => "widgetsetting"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */