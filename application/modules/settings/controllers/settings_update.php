<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  var $title = "settings";
  
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `settings_notifications` (
  `id_settings_notifications` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `source_table` varchar(200) DEFAULT NULL,
  `source_id` varchar(200) DEFAULT NULL,
  `code` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `link_times` varchar(200) DEFAULT NULL,
  `link_check` varchar(200) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_settings_notifications`)
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