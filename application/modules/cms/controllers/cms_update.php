<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `cms_article` (
			`id_cms_article` varchar(25) NOT NULL,
			`link` varchar(25) DEFAULT NULL,
			`title` varchar(25) DEFAULT NULL,
			`note` text,
			`status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
			`file` text,
			`create_by_users` int(11) DEFAULT NULL,
			`create_date` datetime DEFAULT NULL,
			`update_by_users` int(11) DEFAULT NULL,
			`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id_cms_article`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		$this->global_models->query("CREATE TABLE IF NOT EXISTS `cms_comment` (
			`id_cms_comment` varchar(25) NOT NULL,
			`id_cms_article` varchar(25) DEFAULT NULL,
			`title` varchar(25) DEFAULT NULL,
			`note` text,
			`status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
			`create_by_users` int(11) DEFAULT NULL,
			`create_date` datetime DEFAULT NULL,
			`update_by_users` int(11) DEFAULT NULL,
			`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id_cms_comment`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		$this->global_models->query("CREATE TABLE IF NOT EXISTS `cms_gallery` (
			`id_cms_gallery` varchar(25) NOT NULL,
			`title` varchar(25) DEFAULT NULL,
			`link` varchar(25) DEFAULT NULL,
			`file` text,
			`note` varchar(25) DEFAULT NULL,
			`status` tinyint(1) DEFAULT NULL,
			`create_by_users` int(11) DEFAULT NULL,
			`create_date` datetime DEFAULT NULL,
			`update_by_users` int(11) DEFAULT NULL,
			`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id_cms_gallery`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		$this->global_models->query("CREATE TABLE IF NOT EXISTS `cms_page` (
			`id_cms_page` varchar(25) NOT NULL,
			`link` varchar(25) DEFAULT NULL,
			`title` varchar(25) DEFAULT NULL,
			`note` text,
			`status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
			`file` text,
			`create_by_users` int(11) DEFAULT NULL,
			`create_date` datetime DEFAULT NULL,
			`update_by_users` int(11) DEFAULT NULL,
			`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id_cms_page`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => "cms"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
  
  /**
   * @author NBS
   * @abstract Create v2
   */
  function v2(){
    $v = "v2";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `cms_banner_promo` (
  `id_cms_banner_promo` varchar(20) NOT NULL,
  `code` varchar(25) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
  `file` text,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `sort` tinyint(3) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cms_banner_promo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
//    wajib
    $this->global_models->update("m_module", array("name" => "cms"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
	
	function v3(){
    $v = "v3";
    
    $this->global_models->query("CREATE TABLE `cms_service` (
		`id_cms_service` varchar(25) NOT NULL,
		`title` varchar(35) DEFAULT NULL,
		`file` text,
		`link` varchar(35) DEFAULT NULL,
		`sort` int(10) DEFAULT NULL,
		`status` tinyint(1) DEFAULT NULL,
		`note` text,
		`create_by_users` int(11) DEFAULT NULL,
		`create_date` datetime DEFAULT NULL,
		`update_by_users` int(11) DEFAULT NULL,
		`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id_cms_service`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
//    wajib
    $this->global_models->update("m_module", array("name" => "cms"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */