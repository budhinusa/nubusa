<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_home extends MX_Controller {
    
  function __construct() {      
    
//    $this->debug($this->menu, true);
  }
  
  function email($to,$cc,$subject,$isi){
      
    $this->load->library('email');
        $this->email->initialize($this->global_models->email_conf());

        $this->email->from(('no-reply@antavaya.com'), 'AntaVaya Transportation');
        $this->email->to($to);
    $cc = ($cc ? $cc : 'nugroho.budi@antavaya.com, cs@antavaya.com');
    $this->email->cc($cc);

    $this->email->subject($subject);
    $this->email->message($isi);

    if($this->email->send() === TRUE){
     return  "Done";
    }
    else{
     return  $this->email->print_debugger();
    }
    //die;
  }
}  