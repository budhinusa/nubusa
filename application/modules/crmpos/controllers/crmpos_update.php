<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crmpos_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  var $title = "crmpos";
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crmpos_inventory_price` (
  `id_crmpos_inventory_price` varchar(20) NOT NULL,
  `id_crm_inventory` varchar(20) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crmpos_inventory_price`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */