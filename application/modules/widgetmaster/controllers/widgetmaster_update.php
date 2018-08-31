<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetmaster_update extends MX_Controller {
    
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

    $this->global_models->query("DROP TABLE IF EXISTS `m_widget`;
			CREATE TABLE `m_widget` (
				`id_m_widget` varchar(20) NOT NULL,
				`title` varchar(30) DEFAULT NULL,
				`note` text,
				`link` text,
				`status` int(1) DEFAULT NULL,
				`create_by_users` int(11) DEFAULT NULL,
				`create_date` datetime DEFAULT NULL,
				`update_by_users` int(11) DEFAULT NULL,
				`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id_m_widget`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

    $this->global_models->query("DROP TABLE IF EXISTS `m_widget_file`;
			CREATE TABLE `m_widget_file` (
				`id_m_widget_file` varchar(20) NOT NULL,
				`id_m_widget` varchar(20) DEFAULT NULL,
				`tanggal` datetime DEFAULT NULL,
				`title` varchar(50) DEFAULT NULL,
				`note` text,
				`create_by_users` int(11) DEFAULT NULL,
				`create_date` datetime DEFAULT NULL,
				`update_by_users` int(11) DEFAULT NULL,
				`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id_m_widget_file`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => "widgetmaster"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */