<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scm_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  var $title = "scm";
  function v1(){
    $v = "v1";
    
    $this->global_models->query("ALTER TABLE `scm_inventory` ADD `status` TINYINT(1) NULL AFTER `note`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */