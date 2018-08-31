<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bridge extends MX_Controller {
    
  function __construct() {
  }
  
  function change_session($id_change, $id_users){
    $data = $this->global_models->get("bridge", array("id_bridge" => $id_change));
    
    $users = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.dashbord FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS dashbord"
      . " FROM m_users AS A"
      . " WHERE A.id_users = (SELECT C.id_users FROM bridge_users AS C WHERE C.id_users_partner = '{$id_users}' AND C.id_bridge = '{$id_change}')");
    if($users){
      $newdata = array(
        'name'        => $users[0]->name,
        'email'       => $users[0]->email,
        'id'          => $users[0]->id_users,
        'id_privilege'=> ($users[0]->id_privilege ? $users[0]->id_privilege : 0),
        'dashbord'    => $users[0]->dashbord,
        'logged_in'   => TRUE
      );
      $this->session->set_userdata($newdata);
      redirect($data[0]->redirect);
    }
    else {
      redirect("login");
    }
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */