<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_customer_approval_ajax extends MX_Controller {
    
  function approval_get(){
    $pst = $this->input->post();
    $where = "WHERE A.status=2 ";
    $data = $this->global_models->get_query("SELECT A.kode AS code, A.parent, A.title, A.id_crm_customer_company, A.status, A.location"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.parent) AS kepala"
      . " FROM crm_customer_company AS A "
      . $where
	  . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
       
	  $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_customer_company}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm active' isi='{$dt->id_crm_customer_company}'><i class='fa fa-check'></i></button>");
	  //$status = $this->global_variable->status(1);
	  $status = array (
	 1 => "<label class='label label-success'>".lang("Approved")."</label>",
     2 => "<label class='label label-danger'>".lang("UnApproved")."</label>");
	  
	  
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->kepala,
            "value"   => $dt->kepala
          ),   
		  array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
		  array(
            "view"    => $dt->alamat,
            "value"   => $dt->alamat
          ),   
		array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),		  
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer_company
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
	
 
  function _approval_single_record($id_crm_customer_company){
    $where= "WHERE A.id_crm_customer_company='{$id_crm_customer_company}'";
	$data = $this->global_models->get_query("SELECT A.kode AS code, A.parent, A.title, A.id_crm_customer_company, A.status, A.location"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.parent) AS kepala"
      . " FROM crm_customer_company AS A "
      . $where
	  . " ORDER BY A.code ASC"    
      . "");
	
	
	//$status = $this->global_variable->status(1);
	$status = array (
	 1 => "<label class='label label-success'>".lang("Approved")."</label>",
     2 => "<label class='label label-danger'>".lang("UnApproved")."</label>");
    
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$id_crm_customer_company}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm active' title='Approved?' isi='{$id_crm_customer_company}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
         
         
          array(
            "view"    => $data[0]->code,
            "value"   => $data[0]->code
          ),
          array(
            "view"    => $data[0]->kepala,
            "value"   => $data[0]->kepala
          ),   
		  array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
		  array(
            "view"    => $data[0]->alamat,
            "value"   => $data[0]->alamat
          ),   
		array(
            "view"    => $status[$data[0]->status],
            "value"   => $data[0]->status
          ),		  
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_customer_company,
      );
    return $balik;
  }
	  
	
  function approval_delete(){	           
   $pst = $this->input->post();
  
   if($pst['id']){
      $detail = $this->global_models->get("crm_customer_company", array("id_crm_customer_company" => $pst['id']));
      if($detail[0]->status == 1){
        
        $kirim = array(
          "status"       => 2,
          "update_by_users"            => $this->session->userdata("id"),
        );
        $this->global_models->update("crm_customer_company", array("id_crm_customer_company" => $pst['id']), $kirim);
        $balik['status'] = 2;
      }
      else{
        $balik['note'] = lang("Destination Tidak dapat di update");
        $balik['status'] = 3;
      }
    }
    else{
      $balik['note'] = lang("ID Tidak Diketahui");
      $balik['status'] = 3;
    }
	$balik['data']  = $this->_approval_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function approval_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_customer_company", array("id_crm_customer_company" => $pst['id']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
    //update discount
	$parent = $this->global_models->get_query("
	SELECT parent as ortu FROM crm_customer_company
	WHERE id_crm_customer_company={$pst['id']}
	")[0]->ortu;
	
	//$dt = $this->global_models->get_query("
			// select B.parent, 
			// A.id_crm_pos_discount, count(*) as jml 
			// from crm_pos_discount_company A 
			// left join crm_customer_company B on B.id_crm_customer_company=A.id_crm_customer_company 
			// where B.parent={$parent}
			// group by B.parent, 
			// A.id_crm_pos_discount
	//		");
	
	$dt = $this->global_models->get_query("
	 select id_crm_customer_company,id_crm_pos_discount from crm_customer_company_discount
	 where id_crm_customer_company={$parent}
	");
	foreach ($dt AS $d){
		$cek = $this->global_models->get_query("
		select id_crm_pos_discount from crm_pos_discount_company A 
		where id_crm_pos_discount='{$d->id_crm_pos_discount}' and id_crm_customer_company={$d->id_crm_customer_company} 
		 ");
		 // var_dump($cek);
		 // var_dump($d->id_crm_pos_discount);
		 // var_dump($d->id_crm_customer_company);
		 // die;
		if ($cek[0]->id_crm_pos_discount!=""){
			//sudah ada
			// var_dump($cek);
		}else
		{			
			//belum ada, ditambahkan
			//var_dump("tambah");
			$this->global_models->generate_id($id_crm_pos_discount_company, "crm_pos_discount_company");
			$kirim = array(
					  "id_crm_pos_discount_company"  => $id_crm_pos_discount_company,
					  "id_crm_customer_company"      => $pst['id'],
					  "id_crm_pos_discount"          => $d->id_crm_pos_discount,
					  "create_by_users"              => $this->session->userdata("id"),
					  "create_date"                  => date("Y-m-d H:i:s")
					);
					// var_dump($kirim);
					// die;
			$this->global_models->insert("crm_pos_discount_company", $kirim);
		}
	}
	
	//crm_pos_discount_company
	// select A.id_crm_customer_company,B.parent, B.title as company,C.title as disc,A.id_crm_pos_discount from crm_pos_discount_company A -- gabungan disc dan company
// left join crm_customer_company B on B.id_crm_customer_company=A.id_crm_customer_company -- companynya
// left join crm_pos_discount C on C.id_crm_pos_discount=A.id_crm_pos_discount -- nama discount


	$balik['data']  = $this->_approval_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
	
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */