<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internal extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function index(){
    redirect("http://tms.antavaya.com/av/login/bridge/change-session/6QMMFBV3LCKJMW/{$this->session->userdata("id")}");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */