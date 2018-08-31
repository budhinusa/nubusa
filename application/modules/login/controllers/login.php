<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
  function __construct() {
    $this->load->model('login/mlogin');
    $this->load->library('encrypt');
  }
  
	public function index(){
//    $this->debug($this->encrypt->decode('63KjBFRXNRsIZS1WDMSgwrJWHZQQmNo3DUxClpaXe3mo33Zzkb9SkN3/RtqU8tkyPv1NVcLHtpBM8srDJeW9jA=='), true);
    $config = array(
      array(
            'field'   => 'memuname', 
            'label'   => 'Username', 
            'rules'   => 'required'
         ),
      array(
            'field'   => 'mempass', 
            'label'   => 'Password', 
            'rules'   => 'required'
         ),
    );
    
    $this->form_validation->set_rules($config);
    $this->template->title('Login', "Sistem");
    if ($this->form_validation->run() == FALSE){
      $this->session->sess_destroy();
//      print "gagal";
			$this->template->build('main', 
        array(
              'url'     => base_url()."themes/".DEFAULTTHEMES."/",
              'field'   => array('memuname' => $this->input->post('memuname'))
            ));
      $this->template
        ->set_layout('login')
        ->build('main');
		}
		else{
      $cek_login = $this->mlogin->cek_login($this->input->post('memuname'), $this->input->post('mempass'));
      if($cek_login === true){
        redirect($this->session->userdata('dashbord'));
      }
      else{
        $this->session->sess_destroy();
        $this->template->build('main', 
        array(
              'url'     => base_url()."themes/".DEFAULTTHEMES."/",
              'field'   => array('memuname' => $this->input->post('memuname'))
            ));
        $this->template
          ->set_layout('login')
          ->build('main');
      }
		}
	}
  function forgot_password(){
    if($this->input->post()){
      $id_users = $this->global_models->get_field("m_users", "id_users", array("email" => $this->input->post("email")));
      if($id_users){
        $new_password = random_string('alnum',8);
        $enpass = $this->encrypt->encode($new_password);
        $email_user = $this->global_models->get("m_users", array("id_users" => $id_users));
        $this->global_models->update('m_users', array("id_users" => $id_users),array('pass' => $enpass));

        //kirim email
				$html = ""
					. "<p>"
						. "Dear <b> {$email_user[0]->name} </b><br/>"
						. "Your new password : </br> link => ".base_url()." </br> user => {$email_user[0]->email} </br> pass => {$new_password}"
					. "</p>"
					. "<p>"
						. "Terima Kasih<br />"
						. "Antavaya"
					. "</p>"
					. "";
				$kirim_pst = array(
					'isi'			=> "{$html}",
					'to'			=> $email_user[0]->email,
					'subject'	=> "Password Reset",
					'flag'		=> "3",
				);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://117.102.80.180/store/home/email');
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $kirim_pst);
				$hasil_1 = curl_exec($ch);
				curl_close($ch);

        if($hasil_1 == ""){
          $pesan = "New Password has been send to your mail";
        }
        else{
          $pesan = "Password has been changed, but the email delivery fails. Please contact your admin";
        }
      }
      else{
        $pesan = "Your e-mail has not been registered";
      }
    }
    
    $this->template->build('forgot-password', 
    array(
          'url'         => base_url()."themes/".DEFAULTTHEMES."/",
          'pesan'       => $pesan
        ));
    $this->template
      ->set_layout('login')
      ->build('forgot-password');
  }
}