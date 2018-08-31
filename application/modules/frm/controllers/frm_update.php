<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  var $title = "frm";
  
  function v1(){
    $v = "v1";
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `frm_account` (
  `id_frm_account` varchar(20) NOT NULL,
  `id_parent` varchar(20) DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `pos` tinyint(1) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `modal` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_frm_account`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v2(){
    $v = "v2";
    $this->global_models->query("ALTER TABLE `frm_account` CHANGE `id_frm_account` `id_frm_account` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;");
    $this->global_models->query("ALTER TABLE `frm_account` ADD `code_users` VARCHAR(200) NULL AFTER `id_parent`;");
    $this->global_models->query("ALTER TABLE `frm_account` ADD `ref` VARCHAR(200) NULL AFTER `id_parent`;");
    
    $this->global_models->query("ALTER TABLE `frm_journal_period` ADD `code_users` VARCHAR(200) NULL AFTER `id_frm_journal_period`;");
    $this->global_models->query("ALTER TABLE `frm_journal_period` ADD `status` TINYINT(1) NULL AFTER `note`;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v3(){
    $v = "v3";
    $this->global_models->query("ALTER TABLE `frm_journal_detail` ADD `id_frm_journal_period` VARCHAR(20) NULL AFTER `id_frm_account`;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */