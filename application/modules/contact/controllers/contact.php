<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MX_Controller {
    
  function __construct() {
    // $this->menu = $this->cek();
    $this->load->model('scmoutlet/m_scmoutlet');
  }
  
  public function index(){
		
		$css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
			
		$foot = "<script>"
        . "</script>"
        . "";
		
    $this->template
      ->set_layout('default_transport')
      ->build('main', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        
      ));
    $this->template
      ->set_layout('default_transport')
      ->build("main");
  }
	
	public function send_message(){
		$pst = $this->input->post();
		
		# --- CHECK IF EXIST ---
    $this->db->where('email',$pst['email']);
		$this->db->like('note', $pst['note']);
		$check = $this->db->get('site_contact_us')->result();
		
		if(empty($check)){
			$post = array(
				"name"         => $pst['name'],
				"email"         => $pst['email'],
				"subject"         => $pst['subject'],
				"note"         => $pst['note'],
				"create_date"       => date("Y-m-d H:i:s"),
			);
			$id = $this->global_models->insert("site_contact_us", $post);
			
			print "Pesan berhasil dikirimkan.";
		}else{
			print "Pesan sudah pernah dikirimkan sebelumnya.";
		}
		die();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */