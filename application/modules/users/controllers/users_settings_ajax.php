<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_settings_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function group_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users_group AS A"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $da){
      $button = ($da->status == 1 ? "<button class='btn btn-danger btn-sm group-delete' isi='{$da->id_m_users_group}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm group-active' isi='{$da->id_m_users_group}'><i class='fa fa-check'></i></button>");
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->code,
            "value"   => $da->code
          ),
          array(
            "view"    => $da->title,
            "value"   => $da->title
          ),
          array(
            "view"    => $status[$da->status],
            "value"   => $da->status,
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_m_users_group
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
  
  function group_teams_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.id_m_users_group_teams"
      . " ,B.*"
      . " ,(SELECT C.name FROM m_privilege AS C WHERE C.id_privilege = B.id_privilege) AS privilege"
      . " FROM m_users_group_teams AS A"
      . " LEFT JOIN m_users AS B ON B.id_users = A.id_users"
      . " WHERE A.id_m_users_group = '{$pst['id_m_users_group']}'"
      . " ORDER BY A.create_date DESC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-danger btn-sm teams-delete' isi='{$da->id_m_users_group_teams}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_m_users_group_teams
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
  function session_users_set(){
    $pst = $this->input->post();
    
    $this->session->set_userdata(array(
      "id_cms"    => $pst['id_users']
    ));
    
    $hasil['status']  = 2;
    print json_encode($hasil);
    die;
  }
  
  function session_group_set(){
    $pst = $this->input->post();
    
    $this->session->set_userdata(array(
      "code_users"    => $this->global_models->get_field("m_users_group", "code", array("id_m_users_group" => $pst['id_m_users_group']))
    ));
    
    $hasil['status']  = 2;
    print json_encode($hasil);
    die;
  }
  
  function session_users_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.status IN (1)"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $select = ($da->id_users == $this->session->userdata("id_cms") ? true : false);
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
        "select"  => $select,
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
  
  function session_group_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users_group AS A"
      . " WHERE A.status IN (1)"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $select = ($da->code == $this->session->userdata("code_users") ? true : false);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->code,
            "value"   => $da->code
          ),
          array(
            "view"    => $da->title,
            "value"   => $da->title
          ),
        ),
        "select"  => $select,
        "id"      => $da->id_m_users_group
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
  
  function group_approval_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.id_m_users_group_approval"
      . " ,B.*"
      . " ,(SELECT C.name FROM m_privilege AS C WHERE C.id_privilege = B.id_privilege) AS privilege"
      . " FROM m_users_group_approval AS A"
      . " LEFT JOIN m_users AS B ON B.id_users = A.id_users"
      . " WHERE A.id_m_users_group = '{$pst['id_m_users_group']}'"
      . " ORDER BY A.create_date DESC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-danger btn-sm approval-delete' isi='{$da->id_m_users_group_approval}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_m_users_group_approval
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
  
  function group_users_approval_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_users <> 1"
      . " AND A.id_users NOT IN (SELECT C.id_users FROM m_users_group_approval AS C WHERE C.id_m_users_group = '{$pst['id_m_users_group']}')"
      . " AND A.id_users NOT IN (SELECT D.id_users FROM m_users_group_teams AS D WHERE D.id_m_users_group = '{$pst['id_m_users_group']}')"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-info btn-sm {$pst['employee']}-save' isi='{$da->id_users}'><i class='fa fa-save'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
          ),
          array(
            "view"    => $button,
            "value"   => 0
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
	
	function group_users_team_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_users NOT IN (SELECT C.id_users FROM m_users_group_teams AS C)"
      . " AND A.id_users NOT IN (SELECT C.id_users FROM m_users_group_approval AS C WHERE C.id_m_users_group = '{$pst['id_m_users_group']}')"
      . " AND A.id_users <> 1"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $da){
      $button = "<button class='btn btn-info btn-sm {$pst['employee']}-save' isi='{$da->id_users}'><i class='fa fa-save'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
          ),
          array(
            "view"    => $button,
            "value"   => 0
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
  
  function group_set(){
    $pst = $this->input->post();
    $this->load->model("users/musers");
    if($pst['id_m_users_group']){
      $kirim = array(
        "title"               => $pst['title'],
        "code"                => $pst['code'],
        "update_by_users"     => $this->session->userdata("id"),
      );
      $id_m_users_group = $pst['id_m_users_group'];
      $this->global_models->trans_begin();
      $this->global_models->update("m_users_group", array("id_m_users_group" => $id_m_users_group), $kirim);
      $this->global_models->trans_commit();
    }
    else{
      $this->global_models->trans_begin();
      $this->global_models->generate_id($id_m_users_group, "m_users_group");
      $kirim = array(
        "id_m_users_group"   => $id_m_users_group,
        "title"              => $pst['title'],
        "code"                => $pst['code'],
        "status"             => 1,
        "create_by_users"    => $this->session->userdata("id"),
        "create_date"        => date("Y-m-d H:i:s")
      );
      
      $this->global_models->insert("m_users_group", $kirim);
      $this->global_models->trans_commit();
    }
    $balik['data'] = $this->_group_format_single_record($id_m_users_group);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  private function _group_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users_group AS A"
      . " WHERE A.id_m_users_group = '{$id}'");
    $da = $data[0];
    $status = $this->global_variable->status(1);
    $button = ($da->status == 1 ? "<button class='btn btn-danger btn-sm group-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm group-active' isi='{$id}'><i class='fa fa-check'></i></button>");
   
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $da->code,
            "value"   => $da->code
          ),
          array(
            "view"    => $da->title,
            "value"   => $da->title
          ),
          array(
            "view"    => $status[$da->status],
            "value"   => $da->status,
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
  
  function group_approval_set(){
    $pst = $this->input->post();
    if($pst['id_users'] AND $pst['id_m_users_group']){
      $this->global_models->trans_begin();
      $this->global_models->generate_id($id_m_users_group_approval, "m_users_group_approval");
      $kirim = array(
        "id_m_users_group_approval"  => $id_m_users_group_approval,
        "id_m_users_group"           => $pst['id_m_users_group'],
        "id_users"                   => $pst['id_users'],
        "create_by_users"            => $this->session->userdata("id"),
        "create_date"                => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("m_users_group_approval", $kirim);
      $this->global_models->trans_commit();
      $balik['status'] = 2;
			$balik['data'] = $this->_approval_format_single_record($id_m_users_group_approval);
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Process Error");
    }
    
    print json_encode($balik);
    die;
  }
	
	private function _approval_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.id_m_users_group_approval"
      . " ,B.*"
      . " ,(SELECT C.name FROM m_privilege AS C WHERE C.id_privilege = B.id_privilege) AS privilege"
      . " FROM m_users_group_approval AS A"
      . " LEFT JOIN m_users AS B ON B.id_users = A.id_users"
      . " WHERE A.id_m_users_group_approval = '{$id}'");

    $da = $data[0];
    $button = "<button class='btn btn-danger btn-sm approval-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
      
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
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
  
  function group_teams_set(){
    $pst = $this->input->post();
    if($pst['id_users'] AND $pst['id_m_users_group']){
      $this->global_models->trans_begin();
      $this->global_models->generate_id($id_m_users_group_teams, "m_users_group_teams");
      $kirim = array(
        "id_m_users_group_teams"     => $id_m_users_group_teams,
        "id_m_users_group"           => $pst['id_m_users_group'],
        "id_users"                   => $pst['id_users'],
        "create_by_users"            => $this->session->userdata("id"),
        "create_date"                => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("m_users_group_teams", $kirim);
      $this->global_models->trans_commit();
      $balik['status'] = 2;
			$balik['data'] = $this->_team_format_single_record($id_m_users_group_teams);
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Process Error");
    }
    
    print json_encode($balik);
    die;
  }
	
	private function _team_format_single_record($id){
    $data = $this->global_models->get_query("SELECT B.*"
      . " ,(SELECT C.name FROM m_privilege AS C WHERE C.id_privilege = B.id_privilege) AS privilege"
      . " FROM m_users_group_teams AS A"
      . " LEFT JOIN m_users AS B ON B.id_users = A.id_users"
      . " WHERE A.id_m_users_group_teams = '{$id}'");

    $da = $data[0];
    $button = "<button class='btn btn-danger btn-sm teams-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
      
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $da->email,
            "value"   => $da->email
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name,
          ),
          array(
            "view"    => $da->privilege,
            "value"   => $da->privilege,
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
  
  function group_teams_delete(){
    $pst = $this->input->post();
    if($pst['id_m_users_group_teams']){
      $this->global_models->trans_begin();
      $this->global_models->delete("m_users_group_teams", array("id_m_users_group_teams" => $pst['id_m_users_group_teams']));
      $this->global_models->trans_commit();
      $balik['status'] = 2;
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Process Error");
    }
    
    print json_encode($balik);
    die;
  }
  
  function group_approval_delete(){
    $pst = $this->input->post();
    if($pst['id_m_users_group_approval']){
      $this->global_models->trans_begin();
      $this->global_models->delete("m_users_group_approval", array("id_m_users_group_approval" => $pst['id_m_users_group_approval']));
      $this->global_models->trans_commit();
      $balik['status'] = 2;
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Process Error");
    }
    
    print json_encode($balik);
    die;
  }
  
  function group_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users_group AS A"
      . " WHERE A.id_m_users_group = '{$pst['id']}'");
    
    if($data){
      $hasil = array(
        "id_m_users_group" => $data[0]->id_m_users_group,
        "title"            => $data[0]->title,
        "code"             => $data[0]->code,
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