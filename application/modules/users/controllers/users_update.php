<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_update extends MX_Controller {
  
  var $title = "users";
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `m_users_group` ( 
		`id_m_users_group` varchar(20) NOT NULL, 
		`title` varchar(100) DEFAULT NULL, 
		`status` tinyint(1) DEFAULT NULL, 
		`create_by_users` int(11) DEFAULT NULL, 
		`create_date` datetime DEFAULT NULL, 
		`update_by_users` int(11) DEFAULT NULL, 
		`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP , 
		PRIMARY KEY(`id_m_users_group`) )
		ENGINE=InnoDB DEFAULT CHARSET=latin1;"
		);
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `m_users_group_approval` (
  `id_m_users_group_approval` varchar(20) NOT NULL,
  `id_m_users_group` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_m_users_group_approval`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `m_users_group_teams` (
  `id_m_users_group_teams` varchar(20) NOT NULL,
  `id_m_users_group` varchar(20) DEFAULT NULL,
  `id_users` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_m_users_group_teams`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("ALTER TABLE `m_users` CHANGE `name` `name` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
	
  function v2(){
    $v = "v2";
    
    $this->global_models->query("ALTER TABLE `m_users_group` ADD `code` VARCHAR(200) NULL AFTER `title`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */