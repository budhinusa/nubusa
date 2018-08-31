<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scm_settings_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function outlet_set(){
    $pst = $this->input->post();
    $this->session->set_userdata(array(
      "scm_outlet"    => $pst['id']
    ));
    print "Done";
    die;
  }
  
  function suppliers_session_set(){
    $pst = $this->input->post();
    $this->session->set_userdata(array(
      "scm_procurement_suppliers"    => $pst['id']
    ));
    print "Done";
    die;
  }
  
  function outlet_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_outlet"
      . " FROM scm_outlet AS A"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->title,
      );
      $banding[] = $da->id_scm_outlet;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function suppliers_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.title, A.id_scm_procurement_suppliers"
      . " FROM scm_procurement_suppliers AS A"
      . " ORDER BY A.title ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->title,
      );
      $banding[] = $da->id_scm_procurement_suppliers;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function biodata_suppliers_get_detail(){
    $pst = $this->input->post();
    $biodata = $this->global_models->get("scm_suppliers_biodata", array("id_scm_suppliers_biodata" => $pst['id']));
    $users = $this->global_models->get("m_users", array("id_users" => $biodata[0]->id_users));
    $return = array(
      "avatar"                    => ($biodata[0]->avatar ? "<img src='".base_url()."files/scm/settings/biodata/{$biodata[0]->avatar}' style='width: 50px' />" : "<img src='".base_url()."files/avatar.png' style='width: 50px' />"),
      "first_name"                => $biodata[0]->first_name,
      "last_name"                 => $biodata[0]->last_name,
      "telp"                      => $biodata[0]->telp,
      "email"                     => $biodata[0]->email,
      "note"                      => $biodata[0]->note,
      "id_scm_suppliers_biodata"  => $biodata[0]->id_scm_suppliers_biodata,
      "users"                     => array(
        "name"      => $users[0]->name,
        "email"     => $users[0]->email,
        "status"    => $users[0]->status,
        "id_users"  => $users[0]->id_users,
      )
    );
    print json_encode($return);
    die;
  }
  
  function biodata_suppliers_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM scm_procurement_suppliers AS B WHERE B.id_scm_procurement_suppliers = A.id_scm_procurement_suppliers) AS suppliers"
      . " ,C.name, C.status"
      . " ,(SELECT D.name FROM m_privilege AS D WHERE D.id_privilege = C.id_privilege) AS privilege"
      . " FROM scm_suppliers_biodata AS A"
      . " LEFT JOIN m_users AS C ON C.id_users = A.id_users"
      . " ORDER BY A.first_name ASC LIMIT {$pst['start']}, 20");
      
    $status = $this->global_variable->status(1);
    foreach ($data AS $da){
      $gambar = ($da->avatar ? "<img src='".base_url()."files/scm/settings/biodata/{$da->avatar}' style='width: 50px' />" : "<img src='".base_url()."files/avatar.png' style='width: 50px' />");
      $hasil[] = array(
        $gambar,
        $da->first_name." ".$da->last_name."<br />"
        . "{$da->name}",
        $da->telp."<br />".$da->email,
        $da->suppliers,
        "{$da->privilege}<br />"
        . "{$status[$da->status]}"
      );
      $banding[] = $da->id_scm_suppliers_biodata;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function biodata_upload(){
//    $this->debug($_FILES, true);
    $config['upload_path'] = './files/scm/settings/biodata/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $config['max_width']  = '2000';
    $config['max_height']  = '2000';
    $this->load->library('upload', $config);

    if($_FILES['avatar']['name']){
      if (  $this->upload->do_upload('avatar')){
        $avatar = array('upload_data' => $this->upload->data());
      }
      else{
        $status = 1;
        $link = '';
        $return = $this->upload->display_errors();
      }
    }
    if($avatar['upload_data']['file_name']){
      $status = 2;
      $link = "<img src='".base_url()."files/scm/settings/biodata/{$avatar['upload_data']['file_name']}' class='online' width='100' >";
      $return = $avatar['upload_data']['file_name'];
    }
    print json_encode(array(
      "status"      => $status,
      "data"        => $return,
      "link"        => $link,
    ));
    die;
  }
  
  function biodata_suppliers_set(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    
    
    
    if($pst['id_scm_suppliers_biodata']){
      $post = array(
        "id_scm_procurement_suppliers"  => $pst['id_scm_procurement_suppliers'],
        "first_name"                    => $pst['first_name'],
        "last_name"                     => $pst['last_name'],
        "telp"                          => $pst['telp'],
        "email"                         => $pst['email'],
        "note"                          => $pst['note'],
        "update_by_users"               => $this->session->userdata("id"),
      );
      if($pst['avatar'])
        $post['avatar'] = $pst['avatar'];
      $this->global_models->update("scm_suppliers_biodata", array("id_scm_suppliers_biodata" => $pst['id_scm_suppliers_biodata']), $post);
    }
    
    $data = $this->global_models->get("scm_suppliers_biodata", array("id_scm_suppliers_biodata" => $pst['id_scm_suppliers_biodata']));
    $avatar = ($data[0]->avatar ? "<img src='".base_url()."files/scm/settings/biodata/{$data[0]->avatar}' class='online' width='50' /img>" : "<img src='".base_url()."files/avatar.png' class='online' width='50' /img>");
    $status = $this->global_variable->status(1);
    $users = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_users = '{$data[0]->id_users}'");
    $hasil = array(
      $avatar,
      $post['first_name']." ".$post['last_name']."<br />{$users[0]->name}",
      $post['telp']."</br >".$post['email'],
      $this->global_models->get_field("scm_procurement_suppliers", "title", array("id_scm_procurement_suppliers" => $pst['id_scm_procurement_suppliers'])),
      $users[0]->privilege."<br />".$status[$users[0]->status],
    );
    $banding = $pst['id_scm_suppliers_biodata'];
    $return['status'] = 2;
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    
    print json_encode($return);
    die;
    
  }
  
  function users_outlet_auto(){
    $pst = $this->input->post();
//    term
    $pst['term'] = trim($pst['term']);
    $data = $this->global_models->get_query("SELECT B.id_users, B.name, B.email"
      . " FROM m_users AS B"
      . " WHERE (LOWER(B.name) LIKE '%".strtolower($pst['term'])."%'"
      . " OR LOWER(B.email) LIKE '%".strtolower($pst['term'])."%')"
      . " AND B.id_users NOT IN (SELECT A.id_users FROM scm_outlet_users AS A WHERE A.id_scm_outlet = '{$pst['id_scm_outlet']}')"
      . " ORDER BY B.name ASC LIMIT 0, 10");
    
    foreach($data AS $dt){
      $return[] = array(
        "id"    => $dt->id_users,
    "label" => $dt->name." [".$dt->email."]",
        "value" => $dt->name
      );
    }
    print json_encode($return);
    die;
  }
  
  function users_outlet_set(){
    $pst = $this->input->post();
    if($pst['id_scm_outlet']){
      $this->global_models->generate_id($id_scm_outlet_users, "scm_outlet_users");
      $post = array(
        "id_scm_outlet_users"           => $id_scm_outlet_users,
        "id_scm_outlet"                 => $pst['id_scm_outlet'],
        "id_users"                      => $pst['id_users'],
        "create_by_users"               => $this->session->userdata("id"),
        "create_date"                   => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("scm_outlet_users", $post);
    }
    
    $data = $this->global_models->get_query("SELECT A.name, A.email"
      . " ,(SELECT B.name FROM m_privilege AS B WHERE B.id_privilege = A.id_privilege) AS privilege"
      . " FROM m_users AS A"
      . " WHERE A.id_users = '{$pst['id_users']}'");
    $hasil = array(
      $data[0]->name,
      $data[0]->email,
      $data[0]->privilege,
      "<button class='btn btn-danger btn-sm delete' isi='{$id_scm_outlet_users}'><i class='fa fa-times'></i></button>"
    );
    $banding = $id_scm_outlet_users;
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    
    print json_encode($return);
    die;
    
  }
  
  function users_outlet_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("scm_outlet_users", array("id_scm_outlet_users" => $pst['id']));
    print "Done";
    die;
  }
  
  function users_outlet_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT B.name, B.email, A.id_scm_outlet_users"
      . " ,(SELECT C.name FROM m_privilege AS C WHERE C.id_privilege = B.id_privilege) AS privilege"
      . " FROM scm_outlet_users AS A"
      . " LEFT JOIN m_users AS B ON B.id_users = A.id_users"
      . " WHERE A.id_scm_outlet = '{$pst['id_scm_outlet']}'"
      . " ORDER BY B.name ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $hasil[] = array(
        $da->name,
        $da->email,
        $da->privilege,
        "<button class='btn btn-danger btn-sm delete' isi='{$da->id_scm_outlet_users}'><i class='fa fa-times'></i></button>"
      );
      $banding[] = $da->id_scm_outlet_users;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function variable_set(){
    $pst = $this->input->post();
    $data_banding_json = $this->nbscache->get("scm");
    $data_banding = json_decode($data_banding_json);
    
    $data_account_json = $this->nbscache->get("scmtrans_account");
    $data_account = json_decode($data_account_json);
    
    if($pst['scm_alter_po_confirm']){
      $data_banding->scm_default->scm_alter_po_confirm = $pst['scm_alter_po_confirm'];
    }
    
    if($pst['id_scm_satuan_fuel']){
      $data_banding->scm_default->id_scm_satuan_fuel = $pst['id_scm_satuan_fuel'];
    }
    
    if($pst['site_transport_ap_po_account']){
      $data_account->account_default->site_transport_ap_po_account = $pst['site_transport_ap_po_account'];
    }
    
    if($pst['site_transport_ap_suppliers']){
      $data_account->account_default->site_transport_ap_suppliers = $pst['site_transport_ap_suppliers'];
    }
    
//    $this->debug($pst);
    
    $data_banding_json = json_encode($data_banding);
    $this->nbscache->put_all("scm", $data_banding_json);
    
    $data_account_json = json_encode($data_account);
    $this->nbscache->put_all("scmtrans_account", $data_account_json);
    
    print "done";
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */