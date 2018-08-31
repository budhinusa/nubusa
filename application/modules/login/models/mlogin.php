<?php
class Mlogin extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get($memuname){
      $this->db->where("email", $memuname);
      $this->db->where("status", 1);
      $users = $this->db->get("m_users")->row();
      if($users)
        return $users;
      else
        return false;
    }
    function get_email($memuname){
      $this->db->where("email", $memuname);
      $this->db->where("status", 1);
      $this->db->where("type", 1);
      $users = $this->db->get("m_users")->row();
      if($users)
        return $users;
      else
        return false;
    }
    function cek_login($memuname, $mempass){
      $users = $this->get($memuname);
      if(!$users){
        $users = $this->get_email($memuname);
      }
//      $this->db->where("name", $memuname);
//      $this->db->where("sandi", md5($mempass));
//      $hasil = $this->db->get("users")->row();
//      print_r($mempass);
//      if(is_object($hasil)){
      if($users !== false){
        if($mempass == $this->encrypt->decode($users->pass)){
          
          $privilege_inti = $this->global_models->get("m_privilege", array("id_privilege" => $users->id_privilege));
          if(!$users->id_privilege){
            $users->id_privilege = 0;
          }
//          if(!$users->id_hrm_level_organisasi){
//            $users->id_hrm_level_organisasi = 0;
//          }
          $newdata = array(
            'name'  => $users->name,
            'email'     => $users->email,
            'id'     => $users->id_users,
            'id_privilege'     => $users->id_privilege,
            'dashbord'     => $privilege_inti[0]->dashbord,
            'logged_in' => TRUE
          );
          
          $this->session->set_userdata($newdata);
          return true;
        }
        else
          return false;
      }
      else
        return false;
    }
    function forget_password($email){
      $users = $this->get_email($email);
//      $this->db->where("name", $memuname);
//      $this->db->where("sandi", md5($mempass));
//      $hasil = $this->db->get("users")->row();
//      print_r($mempass);
//      if(is_object($hasil)){
      if($users !== false){
        $kirim = array(
            "pass"              => $this->encrypt->encode(random_string('alnum',8)),
            "id_status_user"    => $rand = rand(500, 999),
            "email"             => $users->email,
        );
        $this->db->update("m_users", $kirim, array("id_users" => $users->id_users));
        $kirim['id_users'] = $users->id_users;
        return $kirim;
      }
      else
        return false;
    }
}
?>
