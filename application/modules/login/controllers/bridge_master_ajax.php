<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bridge_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function bridge_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM bridge AS A"
      . " ORDER BY A.id_bridge ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-danger btn-sm ticket-delete' isi='{$da->id_bridge}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->id_bridge,
            "value"   => $da->id_bridge
          ),
          array(
            "view"    => $da->redirect,
            "value"   => $da->redirect
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_bridge
      );
      
    }
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function bridge_users_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS name"
      . " FROM bridge_users AS A"
      . " WHERE A.id_bridge = '{$pst['id_bridge']}'"
      . " ORDER BY A.id_bridge_users ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-danger btn-sm users-delete' isi='{$da->id_bridge_users}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->id_users_partner,
            "value"   => $da->id_users_partner
          ),
          array(
            "view"    => "login/bridge/change-session/{$da->id_bridge}/{$da->id_users_partner}",
            "value"   => ""
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_bridge
      );
      
    }
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function users_delete(){
    $pst = $this->input->post();
    
    $this->global_models->delete("bridge_users", array("id_bridge_users" => $pst['id_bridge_users']));
    
    $hasil['status'] = 2;
    print json_encode($hasil);
    die;
  }
  
  function users_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_users NOT IN (SELECT C.id_users FROM bridge_users AS C WHERE C.id_bridge = '{$pst['id_bridge']}')"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege
          ),
        ),
        "select"  => false,
        "id"      => $da->id_users
      );
      
    }
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function index_lokal_get(){
    $pst = $this->input->post();
    
    $set = $this->global_models->get("bridge_users", array("id_bridge" => $pst['id_bridge']));
    $not_in = "";
    foreach ($set AS $st){
      $not_in .= "{$st->id_users_partner},";
    }
    $not_in = trim($not_in, ",");
    if($set){
      $where = "AND A.id_users NOT IN ({$not_in})";
    }
    
    $this->global_models->get_connect("tms");
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = (SELECT C.id_privilege FROM d_user_privilege AS C WHERE C.id_users = A.id_users)) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_status_user = 1"
      . " {$where}"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege
          ),
        ),
        "select"  => false,
        "id"      => $da->id_users
      );
      
    }
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    $this->global_models->get_connect("default");
    print json_encode($hasil);
    die;
  }
  
  function bridge_set(){
    $pst = $this->input->post();
    if($pst['id_bridge']){
      $kirim = array(
        "redirect"            => $pst['redirect'],
        "update_by_users"     => $this->session->userdata("id"),
      );
      $id_bridge = $pst['id_bridge'];
      $this->global_models->trans_begin();
      $this->global_models->update("bridge", array("id_bridge" => $id_bridge), $kirim);
      $this->global_models->trans_commit();
    }
    else{
      $this->global_models->generate_id($id_bridge, "bridge");
      $kirim = array(
        "id_bridge"           => $id_bridge,
        "redirect"            => $pst['redirect'],
        "create_by_users"     => $this->session->userdata("id"),
        "create_date"         => date("Y-m-d H:i:s")
      );
      $this->global_models->trans_begin();
      $this->global_models->insert("bridge", $kirim);
      $this->global_models->trans_commit();
    }
    $balik['data'] = $this->_bridge_format_single_record($id_bridge);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function users_set(){
    $pst = $this->input->post();
    
    $this->global_models->generate_id($id_bridge_users, "bridge_users");
    $kirim = array(
      "id_bridge_users"     => $id_bridge_users,
      "id_bridge"           => $pst['id_bridge'],
      "id_users"            => $pst['id_users'],
      "id_users_partner"    => $pst['id_users_partner'],
      "create_by_users"     => $this->session->userdata("id"),
      "create_date"         => date("Y-m-d H:i:s")
    );
    $this->global_models->trans_begin();
    $this->global_models->insert("bridge_users", $kirim);
    $this->global_models->trans_commit();
    
    $balik['data'] = $this->_users_format_single_record($id_bridge_users);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  private function _bridge_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM bridge AS A"
      . " WHERE A.id_bridge = '{$id}'");
    $da = $data[0];
    $button = "<button class='btn btn-danger btn-sm ticket-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
   
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $id,
            "value"   => $id
          ),
          array(
            "view"    => $da->redirect,
            "value"   => $da->redirect
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  private function _users_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS name"
      . " FROM bridge_users AS A"
      . " WHERE A.id_bridge_users = '{$id}'");
    $da = $data[0];
    $button = "<button class='btn btn-danger btn-sm users-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
   
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->id_users_partner,
            "value"   => $da->id_users_partner
          ),
          array(
            "view"    => "login/bridge/change-session/{$da->id_bridge}/{$da->id_users_partner}",
            "value"   => "",
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
  
  function bridge_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM bridge AS A"
      . " WHERE A.id_bridge = '{$pst['id_bridge']}'");
    
    if($data){
      $hasil = array(
        "id_bridge"  => $data[0]->id_bridge,
        "redirect"   => $data[0]->redirect,
      );
      $return = array(
        "status"  => 2,
        "data"    => $hasil
      );
    }
    else
      $return['status'] = 3;
    
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */