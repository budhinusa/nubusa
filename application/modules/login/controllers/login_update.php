<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  var $title = 'login';
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `bridge` ( `id_bridge` varchar(20) NOT NULL, `redirect` varchar(200) DEFAULT NULL, `create_by_users` int(11) DEFAULT NULL, `create_date` datetime DEFAULT NULL, `update_by_users` int(11) DEFAULT NULL, `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id_bridge`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `bridge_users` ( `id_bridge_users` varchar(20) NOT NULL, `id_bridge` varchar(20) DEFAULT NULL, `id_users` int(11) DEFAULT NULL, `id_users_partner` varchar(100) DEFAULT NULL, `create_by_users` int(11) DEFAULT NULL, `create_date` datetime DEFAULT NULL, `update_by_users` int(11) DEFAULT NULL, `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id_bridge_users`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */