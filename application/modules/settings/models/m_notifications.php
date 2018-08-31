<?php
class M_notifications extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function notifications_users_get(){
    
    $count = $this->global_models->get_field("settings_notifications", "count(id_settings_notifications)", array("id_users" => $this->session->userdata("id")));
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM settings_notifications AS A"
      . " WHERE A.id_users = '{$this->session->userdata("id")}'"
      . " ORDER BY A.tanggal DESC LIMIT 0, 10");
      
    if($count > 0){
      foreach ($data AS $key => $dt){
        $list[$key] = array(
          "view"      => "settings/settings-notifications/index/{$dt->id_settings_notifications}",
          "note"      => $dt->note,
          "title"     => $dt->title,
          "tanggal"   => $dt->tanggal,
        );
        if($dt->link_times AND $dt->link_check){
          $list[$key] = array(
            "times"     => "settings/settings-notifications/times/{$dt->id_settings_notifications}",
            "check"     => "settings/settings-notifications/check/{$dt->id_settings_notifications}",
          );
        }
      }
      $return = array(
        "status"    => 2,
        "data"      => array(
          "count"     => $count,
          "list"      => $list,
        )
      );
    }
    else{
      $return = array(
        "status"  => 3
      );
    }
    
    return $return;
  }
  
  function notifications_users_set($notifications = NULL, $email = NULL){
    if($notifications){
      if($notifications['id_users'] AND $notifications['title'] AND $notifications['tanggal']){
        $this->global_models->generate_id($id_settings_notifications, "settings_notifications");
        $kirim = array(
          "id_settings_notifications"   => $id_settings_notifications,
          "id_users"                    => $notifications['id_users'],
          "source_table"                => $notifications['source_table'],
          "source_id"                   => $notifications['source_id'],
          "code"                        => $notifications['code'],
          "title"                       => $notifications['title'],
          "tanggal"                     => $notifications['tanggal'],
          "link"                        => $notifications['link'],
          "link_check"                  => $notifications['link_check'],
          "link_times"                  => $notifications['link_times'],
          "note"                        => $notifications['note'],
          "create_by_users"             => $this->session->userdata("id"),
          "create_date"                 => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("settings_notifications", $kirim);
        $not = array(
          "status"    => 2,
          "data"      => array(
            "id"        => $id_settings_notifications
          )
        );
      }
      else{
        $not['status']  = 3;
      }
    }
    else{
      $not['status']  = 3;
    }
    return $not;
  }
  
  function notifications_users_read($params){
    $this->global_models->delete("settings_notifications", array(
      "id_users"      => $params['id_users'],
      "source_table"  => $params['source_table'],
      "source_id"     => $params['source_id'],
      "code"          => $params['code'],
      ));
    $return = array(
      "status"    => 2
    );
    return $return;
  }
}
?>
