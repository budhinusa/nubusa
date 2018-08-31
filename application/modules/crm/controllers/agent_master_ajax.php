<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function biodata_set(){
    $pst = $this->input->post();
    if($pst['id_crm_agent']){
      $kirim = array(
        "name"                       => $pst['name'],
        "title"                      => $pst['title'],
        "jabatan"                    => $pst['jabatan'],
        "no"                         => $pst['no'],
        "telp"                       => $pst['telp'],
        "email"                      => $pst['email'],
        "note"                       => $pst['note'],
        "id_users"                   => $pst['id_users'],
        "id_crm_agent_store"         => $pst['id_crm_agent_store'],
        "update_by_users"            => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_agent", array("id_crm_agent" => $pst['id_crm_agent']), $kirim);
      $id_crm_agent = $pst['id_crm_agent'];
    }
    else{
      $this->global_models->generate_id($id_crm_agent, "crm_agent");
      $kirim = array(
        "id_crm_agent"               => $id_crm_agent,
        "name"                       => $pst['name'],
        "title"                      => $pst['title'],
        "jabatan"                    => $pst['jabatan'],
        "no"                         => $pst['no'],
        "telp"                       => $pst['telp'],
        "email"                      => $pst['email'],
        "note"                       => $pst['note'],
        "id_users"                   => $pst['id_users'],
				"id_crm_agent_store"         => $pst['id_crm_agent_store'],
        "create_by_users"            => $this->session->userdata("id"),
        "create_date"                => date("Y-m-d H:i:s")
      );
      $id_crm_agent = $this->global_models->insert("crm_agent", $kirim);
      
    }
    
    $balik['data']  = $this->_agent_return_single_record($id_crm_agent);
    print json_encode($balik);
    die;
  }
  
  function customer_status(){
    $pst = $this->input->post();
    if($pst['id']){
      $kirim = array(
        "status"                      => $pst['status'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_customer_company", array("id_crm_customer_company" => $pst['id']), $kirim);
      $id_crm_customer_company = $pst['id'];
    }
        
    $balik['data']  = $this->_format_return_single_record($id_crm_customer_company);
    print json_encode($balik);
    die;
  }
  
  private function _agent_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
			. " ,(SELECT C.title FROM crm_agent_store AS C WHERE C.id_crm_agent_store = A.id_crm_agent_store) AS store"
      . " FROM crm_agent AS A"
      . " WHERE A.id_crm_agent = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->no,
          "value"   => $data[0]->no
        ),
        array(
          "view"    => $data[0]->name,
          "value"   => $data[0]->name
        ),
        array(
          "view"    => $data[0]->users,
          "value"   => $data[0]->users
        ),
        array(
          "view"    => $data[0]->telp,
          "value"   => $data[0]->telp
        ),
        array(
          "view"    => $data[0]->email,
          "value"   => $data[0]->email
        ),
				array(
          "view"    => $data[0]->store,
          "value"   => $data[0]->store
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
    
  function biodata_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " ,(SELECT C.title FROM crm_agent_store AS C WHERE C.id_crm_agent_store = A.id_crm_agent_store) AS store"
      . " FROM crm_agent AS A"
      . " ORDER BY A.no ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->no,
            "value"   => $dt->no
          ),
          array(
            "view"    => $dt->name,
            "value"   => $dt->name
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => $dt->telp,
            "value"   => $dt->telp
          ),
          array(
            "view"    => $dt->email,
            "value"   => $dt->email
          ),
					array(
            "view"    => $dt->store,
            "value"   => $dt->store
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_agent
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']   = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function biodata_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_agent", array("id_crm_agent" => $pst['id']));
    $hasil = array(
      "no"                      => $data[0]->no,
      "name"                    => $data[0]->name,
      "telp"                    => $data[0]->telp,
      "email"                   => $data[0]->email,
      "title"                   => $data[0]->title,
      "jabatan"                   => $data[0]->jabatan,
      "note"                    => $data[0]->note,
      "id_crm_agent"            => $data[0]->id_crm_agent,
      "id_crm_agent_store"            => $data[0]->id_crm_agent_store,
      "id_users"                => $data[0]->id_users,
    );
    print json_encode($hasil);
    die;
  }
	
	function store_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_agent_store AS A"
      . " ORDER BY A.sort ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->sort,
            "value"   => $dt->sort
          ),
					array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->telp,
            "value"   => $dt->telp
          ),
          array(
            "view"    => $dt->fax,
            "value"   => $dt->fax
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_agent_store}'><i class='fa fa-times'></i></button>",
            "value"   => ''
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_agent_store
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']   = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function store_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_agent_store", array("id_crm_agent_store" => $pst['id']));
    $hasil = array(
      "sort"                      => $data[0]->sort,
      "title"                    => $data[0]->title,
      "code"                    => $data[0]->code,
      "telp"                    => $data[0]->telp,
      "fax"                  		=> $data[0]->fax,
      "address"                 => $data[0]->address,
      "id_crm_agent_store"      => $data[0]->id_crm_agent_store,
    );
    print json_encode($hasil);
    die;
  }
	
	function store_set(){
    $pst = $this->input->post();
    if($pst['id_crm_agent_store']){
      $kirim = array(
        "title"                      => $pst['title'],
        "code"                		   => $pst['code'],
        "sort"                       => $pst['sort'],
        "telp"                       => $pst['telp'],
        "fax"                     	 => $pst['fax'],
        "address"                    => $pst['address'],
        "update_by_users"            => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_agent_store", array("id_crm_agent_store" => $pst['id_crm_agent_store']), $kirim);
      $id_crm_agent_store = $pst['id_crm_agent_store'];
    }
    else{
      $this->global_models->generate_id($id_crm_agent_store, "crm_agent_store");
      $kirim = array(
        "id_crm_agent_store"               => $id_crm_agent_store,
        "title"                      => $pst['title'],
        "code"                		   => $pst['code'],
        "sort"                       => $pst['sort'],
        "telp"                       => $pst['telp'],
        "fax"                     	 => $pst['fax'],
        "address"                    => $pst['address'],
        "create_by_users"            => $this->session->userdata("id"),
        "create_date"                => date("Y-m-d H:i:s")
      );
      $id_crm_agent_store = $this->global_models->insert("crm_agent_store", $kirim);
      
    }
    		
		$balik['id']    = $id_crm_agent_store;
    $balik['data']  = array(
        "data"    => array(
					array(
						"view"    => $pst['sort'],
						"value"   => $pst['sort']
					),
					array(
						"view"    => $pst['title'],
						"value"   => $pst['title']
					),
					array(
						"view"    => $pst['telp'],
						"value"   => $pst['telp']
					),
					array(
						"view"    => $pst['fax'],
						"value"   => $pst['fax']
					),
					array(
						"view"    => "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_agent_store}'><i class='fa fa-times'></i></button>",
						"value"   => ''
					),
        ),
        "select"  => true,
        "id"      => $id_crm_agent_store,
      );
			
    print json_encode($balik);
    die;
  }
	
	function store_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("crm_agent_store", array("id_crm_agent_store" => $pst['id']));
    print "Done";die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */