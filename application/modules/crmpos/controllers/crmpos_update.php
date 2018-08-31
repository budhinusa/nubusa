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
  function v1(){
    $v = "v1";
    $title = "crmpos";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products` (
  `id_crm_pos_products` varchar(20) NOT NULL,
  `id_crm_pos_products_categories` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `selling_point` text,
  `description` text,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products`
  ADD PRIMARY KEY (`id_crm_pos_products`);");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_categories` (
  `id_crm_pos_products_categories` varchar(20) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_categories`
  ADD PRIMARY KEY (`id_crm_pos_products_categories`);");
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_specification_data` (
  `id_crm_pos_products_specification_data` varchar(20) NOT NULL,
  `id_crm_pos_products_specification_details` varchar(20) DEFAULT NULL,
  `id_crm_pos_products` varchar(20) DEFAULT NULL,
  `isi` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification_data`
  ADD PRIMARY KEY (`id_crm_pos_products_specification_data`);");
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_specification` (
  `id_crm_pos_products_specification` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification`
  ADD PRIMARY KEY (`id_crm_pos_products_specification`);");
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_specification_details` (
  `id_crm_pos_products_specification_details` varchar(20) NOT NULL,
  `id_crm_pos_products_specification` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification_details`
  ADD PRIMARY KEY (`id_crm_pos_products_specification_details`);");

    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_tags` (
  `id_crm_pos_products_tags` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_tags`
  ADD PRIMARY KEY (`id_crm_pos_products_tags`);");
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_products_file` (
  `id_crm_pos_products_file` varchar(20) NOT NULL,
  `id_crm_pos_products` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_file` ADD PRIMARY KEY(`id_crm_pos_products_file`);");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  var $title = "crmpos";
  function v2(){
    $v = "v2";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_location` (
  `id_crm_pos_location` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `urut` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_location`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_location_dc` (
  `id_crm_pos_location_dc` varchar(20) NOT NULL,
  `id_crm_pos_location` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `urut` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_location_dc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("ALTER TABLE `crm_pos_products_merchandise` ADD `id_crm_pos_location` VARCHAR(20) NULL AFTER `id_crm_pos_products`, ADD `id_crm_pos_location_dc` VARCHAR(20) NULL AFTER `id_crm_pos_location`;");
    
    $this->global_models->query("ALTER TABLE `crm_pos_products` ADD `picture` VARCHAR(255) NULL AFTER `status`;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification_data` ADD `code` VARCHAR(20) NULL AFTER `sort`, ADD `note` TEXT NULL AFTER `code`;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification_details` ADD `code` VARCHAR(20) NULL AFTER `sort`;");
    $this->global_models->query("ALTER TABLE `crm_pos_products_specification_details` ADD `code` VARCHAR(20) NULL AFTER `sort`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v3(){
    $v = "v3";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_request_merchandise` (
  `id_crm_pos_request_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_request` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_request_merchandise`)
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