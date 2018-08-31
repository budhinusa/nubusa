<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrm_update extends MX_Controller {
    
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
    $title = "hrm";
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `hrm_struktural_biodata` ("
      . "`id_hrm_struktural_biodata` varchar(20) NOT NULL,"
      . "`id_hrm_biodata` varchar(20) DEFAULT NULL,"
      . "`id_hrm_struktural` varchar(20) DEFAULT NULL,"
      . "`note` text,`create_by_users` int(11) DEFAULT NULL,"
      . "`create_date` datetime DEFAULT NULL,"
      . "`update_by_users` int(11) DEFAULT NULL,"
      . "`update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("ALTER TABLE `hrm_struktural_biodata` ADD PRIMARY KEY (`id_hrm_struktural_biodata`);");
    
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v2(){
    $v = "v2";
    $title = "hrm";
    $this->global_models->query("CREATE TABLE `site_transport_komisi` (
    `id_site_transport_komisi` varchar(20) NOT NULL,
    `bulan` tinyint(4) DEFAULT NULL,
    `tahun` int(5) DEFAULT NULL,
    `create_by_users` int(11) DEFAULT NULL,
    `create_date` datetime DEFAULT NULL,
    `update_by_users` int(11) DEFAULT NULL,
    `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     PRIMARY KEY (`id_site_transport_komisi`)
    )ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE `site_transport_komisi_partner` (
  `id_site_transport_komisi_partner` varchar(20) NOT NULL,
  `id_site_transport_komisi` varchar(20) NOT NULL,
  `id_site_transport_partner` varchar(20) NOT NULL,
  `jalan` tinyint(4) DEFAULT NULL,
  `masuk` tinyint(4) DEFAULT NULL,
  `off` tinyint(4) DEFAULT NULL,
  status_partner tinyint(4) DEFAULT NULL COMMENT '2 => hitungan proporsional,1=> normal',
  `biaya_retensi` double DEFAULT NULL,
  `uang_pengganti` double DEFAULT NULL,
  `bpjs_kesehatan` double DEFAULT NULL,
  `npwp` tinyint(2) DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL COMMENT '1=> post,tidak dapat di edit lagi',  
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_site_transport_komisi_partner`)  
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
   
//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */