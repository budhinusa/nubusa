<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crm_update extends MX_Controller {
    
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
	
   function v2(){
    $v = "v2";
    $title = "crmpos";
    
    $this->global_models->query("DROP TABLE IF EXISTS `crm_agent`;");
    $this->global_models->query("CREATE TABLE `crm_agent` (
  `id_crm_agent` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_crm_agent_store` varchar(20) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(100) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$this->global_models->query("DROP TABLE IF EXISTS `crm_agent_store`;");
$this->global_models->query("CREATE TABLE `crm_agent_store` (
  `id_crm_agent_store` varchar(20) NOT NULL,
  `title` varchar(35) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `sort` int(2) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `address` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_agent_store`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
				
		
		$this->global_models->query("CREATE TABLE `crm_customer_company_deposit` (
  `id_crm_customer_company_deposit` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_customer_company_deposit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->global_models->query("CREATE TABLE `crm_customer_company_deposit_log` (
  `id_crm_customer_company_deposit_log` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `credit` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_customer_company_deposit_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->global_models->query("CREATE TABLE `crm_customer_deposit` (
  `id_crm_customer_deposit` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_customer_deposit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		$this->global_models->query("CREATE TABLE `crm_customer_deposit_log` (
  `id_crm_customer_deposit_log` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `in` double DEFAULT NULL,
  `out` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_customer_deposit_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v3(){
    $v = "v3";
    $title = "crm";
     
    $this->global_models->query("ALTER TABLE `crm_customer` ADD `division` VARCHAR(100) NULL AFTER `telp`;");
    $this->global_models->query("ALTER TABLE `crm_customer_company` ADD `type` TINYINT(3) NULL AFTER `utama`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
      
  }
  
  function v4(){
    $v = "v4";
    $title = "crm";
     
    $this->global_models->query("ALTER TABLE `crm_customer` ADD `fax` VARCHAR(100) NULL AFTER `telp`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v5(){
    $v = "v5";
    $title = "crm";
     
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_customer_company_discount` (
  `id_crm_customer_company_discount` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_customer_company_discount`
  ADD PRIMARY KEY (`id_crm_customer_company_discount`);");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v6(){
    $v = "v6";
    $title = "crm";
     
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_discount_company` (
  `id_crm_pos_discount_company` int(11) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_discount_company`
  ADD PRIMARY KEY (`id_crm_pos_discount_company`);");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
   function v7(){
    $v = "v7";
    $title = "crm";
     
    $this->global_models->query("ALTER TABLE `crm_customer_company` ADD `telp2` VARCHAR(100) NULL AFTER `telp`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v8(){
    $v = "v8";
    $title = "crm";
     
    $this->global_models->query("ALTER TABLE `crm_pos_discount` ADD `code` VARCHAR(100) NULL AFTER `cashback`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v9(){
    $v = "v9";
    $title = "crm";
     
    $this->global_models->query("CREATE TABLE `crm_pos_discount_payment_channel` (
  `id_crm_pos_discount_payment_channel` varchar(20) NOT NULL,
  `id_crm_payment_channel` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_discount_payment_channel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
     
    $this->global_models->query("ALTER TABLE `crm_pos_discount` ADD `is_payment_channel` TINYINT(1) NULL AFTER `is_company`, ADD `is_voucher` TINYINT(1) NULL AFTER `is_payment_channel`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  var $title = "crm";
  
  function v10(){
    $v = "v10";
     
    $this->global_models->query("ALTER TABLE `crm_customer` ADD `code` VARCHAR(100) NULL AFTER `id_users`;");
    $this->global_models->query("ALTER TABLE `crm_customer` ADD `telp_home` VARCHAR(100) NULL AFTER `telp`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v11(){
    $v = "v11";
     
    $this->global_models->query("ALTER TABLE `crm_pos_discount` ADD `minimum` DOUBLE NULL AFTER `is_voucher`, ADD `maximum` DOUBLE NULL AFTER `minimum`;");
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_discount_voucher` (
  `id_crm_pos_discount_voucher` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `batas` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_discount_voucher`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_customer_company` ADD `c_crmtrans_account` INT(5) NULL AFTER `type`;");
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v12(){
    $v = "v12";
     
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_pos_discount_voucher_use` (
  `id_crm_pos_discount_voucher_use` varchar(20) NOT NULL,
  `id_crm_pos_discount_voucher` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `timelimit` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_pos_discount_voucher_use`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    $this->global_models->query("ALTER TABLE `crm_pos_discount_voucher` ADD `digunakan` DOUBLE NULL AFTER `batas`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v13(){
    $v = "v13";
     
    $this->global_models->query("ALTER TABLE `crm_pos_discount_voucher_use` ADD `source_table` VARCHAR(200) NULL AFTER `id_crm_pos_discount`, ADD `source_id` VARCHAR(200) NULL AFTER `source_table`;");
    $this->global_models->query("ALTER TABLE `crm_customer_company` DROP `c_crmtrans_account`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v14(){
    $v = "v14";
     
    $this->global_models->query("ALTER TABLE `crm_pos_quotation_merchandise_discount` ADD `nilai_dari` DOUBLE NULL AFTER `nilai`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v15(){
    $v = "v15";
     
    $this->global_models->query("ALTER TABLE `crm_pos_discount_voucher` ADD `startdate` DATETIME NULL AFTER `batas`, ADD `enddate` DATETIME NULL AFTER `startdate`;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */