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
  var $title = "crm";
  function v1(){
    $v = "v1";
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_inventory_groups` (
  `id_crm_inventory_groups` varchar(20) NOT NULL,
  `code_users` varchar(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_inventory_groups`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_satuan_groups` (
  `id_crm_satuan_groups` varchar(20) NOT NULL,
  `code_users` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_satuan_groups`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_satuan` (
  `id_crm_satuan` varchar(20) NOT NULL,
  `id_crm_satuan_groups` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `level` tinyint(3) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_satuan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_inventory` (
  `id_crm_inventory` varchar(20) NOT NULL,
  `id_crm_satuan_groups` varchar(20) DEFAULT NULL,
  `id_crm_inventory_groups` varchar(20) DEFAULT NULL,
  `code_users` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_inventory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_storage` (
  `id_crm_storage` varchar(20) NOT NULL,
  `code_users` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_storage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_storage_inventory` (
  `id_crm_storage_inventory` varchar(20) NOT NULL,
  `id_crm_storage` varchar(20) DEFAULT NULL,
  `id_crm_inventory` varchar(20) DEFAULT NULL,
  `id_crm_satuan` varchar(20) DEFAULT NULL,
  `hpp` double DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_storage_inventory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `crm_rg` (
  `id_crm_rg` varchar(20) NOT NULL,
  `code_users` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `nomor` varchar(200) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_crm_rg`)
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