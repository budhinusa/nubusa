<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_ajax extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek("json");
  }
  
  function notifications_get(){
    $pst = $this->input->post();
    
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM settings_notifications AS A"
      . " ORDER BY A.tanggal DESC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $dt){
			$button = ""
				 . "<button class='btn btn-danger btn-sm not-delete' isi='{$dt->id_settings_notifications}'><i class='fa fa-times'></i></button>" 	   
				 . "";
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => strtotime($dt->tanggal)
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => $dt->link,
            "value"   => $dt->link
          ),
          array(
            "view"    => $dt->title."<br />".$dt->code,
            "value"   => $dt->title."<br />".$dt->code
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_settings_notifications
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
  
  function notifications_set(){
    $pst = $this->input->post();
    
    if($pst['id_settings_notifications']){
      $kirim = array(
        "id_users"                  => $pst['id_users'],
        "title"                     => $pst['title'],
        "tanggal"                   => $pst['tanggal'],
        "code"                      => $pst['code'],
        "link"                      => $pst['link'],
        "note"                      => $pst['note'],
        "update_by_users"           => $this->session->userdata("id"),
      );
      $this->global_models->update("settings_notifications", array("id_settings_notifications" => $pst['id_settings_notifications']), $kirim);
      $status = 2;
      $id_settings_notifications = $pst['id_settings_notifications'];
    }
    else{
      $this->global_models->generate_id($id_settings_notifications, "settings_notifications");
      $kirim = array(
        "id_settings_notifications" => $id_settings_notifications,
        "id_users"                  => $pst['id_users'],
        "title"                     => $pst['title'],
        "tanggal"                   => $pst['tanggal'],
        "code"                      => $pst['code'],
        "link"                      => $pst['link'],
        "note"                      => $pst['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("settings_notifications", $kirim);
      $status = 2;
    }
    
    if($status == 2){
      $balik = array(
        "status"    => 2,
        "data"      => $this->_notifications_format_single_record($id_settings_notifications)
      );
    }
    else{
      $balik = array(
        "status"    => 3
      );
    }
    
    print json_encode($balik);
    die;
  }
  
  private function _notifications_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.name FROM m_users AS C WHERE C.id_users = A.id_users) AS users"
      . " FROM settings_notifications AS A"
      . " WHERE A.id_settings_notifications = '{$id}'");
    $dt = $data[0];
		$button = ""
      . "<button class='btn btn-danger btn-sm not-delete' isi='{$id}'><i class='fa fa-times'></i></button>" 	   
      . "";
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => strtotime($dt->tanggal)
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => $dt->link,
            "value"   => $dt->link
          ),
          array(
            "view"    => $dt->title."<br />".$dt->code,
            "value"   => $dt->title."<br />".$dt->code
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
  
  function notifications_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM settings_notifications AS A"
      . " WHERE A.id_settings_notifications = '{$pst['id_settings_notifications']}'");
    if($data){
      $hasil = array(
        "id_settings_notifications" => $data[0]->id_settings_notifications,
        "title"                     => $data[0]->title,
        "tanggal"                   => $data[0]->tanggal,
        "code"                      => $data[0]->code,
        "id_users"                  => $data[0]->id_users,
        "link"                      => $data[0]->link,
        "note"                      => $data[0]->note, 
      );
      $hasil['status'] = 2;
    }
    else
      $hasil['status'] = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function notifications_delete(){
    $pst = $this->input->post();
    $data = $this->global_models->delete("settings_notifications", array("id_settings_notifications" => $pst['id_settings_notifications']));
    $hasil['status'] = 2;
    $hasil['id'] = $pst['id_settings_notifications'];
    print json_encode($hasil);
    die;
  }
  
}