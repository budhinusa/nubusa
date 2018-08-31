<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_notifications extends MX_Controller {
    
  function __construct() {
  }
  
	public function index($id_settings_notifications){
    if($id_settings_notifications){
      $data = $this->global_models->get("settings_notifications", array("id_settings_notifications" => $id_settings_notifications));
      if($data){
        $this->global_models->delete("settings_notifications", array("id_settings_notifications" => $id_settings_notifications));
        redirect($data[0]->link);
      }
      else{
        redirect($this->session->userdata("dashboard"));
      }
    }
    else{
      redirect($this->session->userdata("dashboard"));
    }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */