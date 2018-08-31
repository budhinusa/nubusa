<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_update extends MX_Controller {
    
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

    $this->global_models->query("DROP TABLE IF EXISTS `site_contact_us`;
			CREATE TABLE `site_contact_us` (
				`id_site_contact_us` int(25) NOT NULL AUTO_INCREMENT,
				`subject` varchar(35) DEFAULT NULL,
				`name` varchar(35) DEFAULT NULL,
				`email` varchar(35) DEFAULT NULL,
				`note` text,
				`create_date` datetime DEFAULT NULL,
				PRIMARY KEY (`id_site_contact_us`)
			) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;");
    
//    wajib
    $this->global_models->update("m_module", array("name" => "site_contact_us"), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */