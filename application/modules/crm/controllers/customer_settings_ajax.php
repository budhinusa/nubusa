<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_settings_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek("json");
  }
  
  function session_customer_set(){
    $pst = $this->input->post();
    
    $this->session->set_userdata(array(
      "crm_customer"    => $pst['id_crm_customer']
    ));
    
    $hasil['status']  = 2;
    print json_encode($hasil);
    die;
  }
  
  function session_customer_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
      . " ,(SELECT C.name FROM m_users AS C WHERE C.id_users = A.id_users) AS users"
      . " FROM crm_customer AS A"
      . " WHERE A.name IS NOT NULL"
      . " AND A.email IS NOT NULL"
      . " ORDER BY A.name ASC LIMIT {$pst['start']}, 20");
      
    foreach ($data AS $da){
      $select = ($da->id_crm_customer == $this->session->userdata("crm_customer") ? true : false);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->company,
            "value"   => $da->company
          ),
          array(
            "view"    => $da->users,
            "value"   => $da->users
          ),
        ),
        "select"  => $select,
        "id"      => $da->id_crm_customer
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
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */