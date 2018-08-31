<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function company_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_customer_company", array("id_crm_customer_company" => $pst['id']));
    $hasil = array(
      "title"                   => $data[0]->title,
      "kode"                    => $data[0]->kode,
      "location"                => $data[0]->location,
      "telp"           		    => $data[0]->telp,
      "telp2"           		=> $data[0]->telp2,  
	  "email"           		=> $data[0]->email,  
      "type"                    => ($data[0]->pricing_type == 1 ? TRUE : FALSE),
      "type_company"            => $data[0]->type,  
      "margin"                  => $data[0]->margin,
      "utama"                   => ($data[0]->utama == 1 ? TRUE : FALSE),
      "fee"                     => $data[0]->management_fee,
      "company_grouping"        => $data[0]->c_crmtrans_account,
      "id_crm_customer_company" => $data[0]->id_crm_customer_company,
    );
    print json_encode($hasil);
    die;
  }
  
  function company_set(){
    $pst = $this->input->post();
    
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    $allow = true;
    if(!$pst['parent']){
      $allow = false;
      if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "crm-customer-company-parent", "edit") !== FALSE){
        $allow = true;
        
      }
    }
    
    if($allow == true){
     if(trim($pst['title']) != "" AND trim($pst['kode']) != ""){
       
      if($pst['id_crm_customer_company']){
          
        $kirim = array(
          "title"                       => strtoupper($pst['title']),
          "kode"                        => strtoupper($pst['kode']),
          "location"                    => $pst['location'],
          "telp"                        => $pst['telp'],
          "telp2"                        => $pst['telp2'],
		  "email"                       => $pst['email'],
          'type'                        => $pst['type'],   
          "utama"                       => $truefalse[$pst['utama']],
          "update_by_users"             => $this->session->userdata("id"),
        );
        
        if($pst['company_grouping']){
            $ek_c_crmtrans_account = $this->global_models->get("crm_customer_company",array("id_crm_customer_company" => "{$pst['id_crm_customer_company']}"));
          
            if($ek_c_crmtrans_account){
                
                if($ek_c_crmtrans_account[0]->c_crmtrans_account != $pst['company_grouping']){
//                  #cek data c_crmtrans_account tidak kosong atau null
                    $s = $this->global_models->get("crm_customer_company",array("parent" => "{$pst['id_crm_customer_company']}"));
                       $baru = array();
                       foreach ($s as $val) {
                           $baru[] = $val->id_crm_customer_company;
                       }
                       
                       $data_json = $this->nbscache->get("crmtrans_account");
                       $data_banding = json_decode($data_json);
                       
                    if($ek_c_crmtrans_account[0]->c_crmtrans_account){
                        
                        $data_lama = $data_banding->company_grouping[$ek_c_crmtrans_account[0]->c_crmtrans_account]->company;
                        
                        if(is_array($data_lama)){
                            $data_lama = $data_lama;
                        }else{
                            $data_lama = array();
                        }
                        
                        $update_data_lama =  array_diff(array_merge($baru,$data_lama),array_intersect($baru, $data_lama));
                        #menghapus data crmtrans_account yang sama dengan child dari crm_customer_company
                        $data_banding->company_grouping[$ek_c_crmtrans_account[0]->c_crmtrans_account]->company = $update_data_lama;
                        $data_json_old = json_encode($data_banding);
                        $this->nbscache->put_all("crmtrans_account", $data_json_old);
                    }
                    
                    if($pst['company_grouping']){
                        #update data crmtrans_account dengan child dari crm_customer_company
                        $data_baru = $data_banding->company_grouping[$pst['company_grouping']]->company;
                        if(is_array($data_baru)){
                            $data_baru = $data_baru;
                        }else{
                            $data_baru = array();
                        }
                        
                        $update_data_baru =  array_diff(array_merge($baru,$data_baru),array_intersect($baru, $data_baru));
                        if($update_data_baru){
                            $update_data_baru = $update_data_baru;
                        }else{
                            $update_data_baru = $baru;
                        }
                        
                        $data_banding->company_grouping[$pst['company_grouping']]->company = $update_data_baru;
                        $data_json_new = json_encode($data_banding);
                        $this->nbscache->put_all("crmtrans_account", $data_json_new);
                    }
                   
//                    print "<pre>";
//                    print $ek_c_crmtrans_account[0]->c_crmtrans_account."<br>";
//                    print $pst['company_grouping'];
//                    print_r($baru);
////                    print_r($data_banding->company_grouping);
//                    print "<br>1";
//                    print_r($update_data_lama);
//                    print "<br>2";
//                    print_r($update_data_baru);
//                    die;
                    
                    }else{
                        $s = $this->global_models->get("crm_customer_company",array("parent" => "{$pst['id_crm_customer_company']}"));
                        $baru = array();
                        foreach ($s as $val) {
                            $baru[] = $val->id_crm_customer_company;
                        }
                        
                        $data_json = $this->nbscache->get("crmtrans_account");
                        $data_banding = json_decode($data_json);
                        $data_lama = $data_banding->company_grouping[$pst['company_grouping']]->company;
                        
                        if(is_array($data_lama)){
                            $data_lama = $data_lama;
                        }else{
                            $data_lama = array();
                        }
                        
                        $update_data_lama =  array_diff(array_merge($baru,$data_lama),array_intersect($baru, $data_lama));
                        #menghapus data crmtrans_account yang sama dengan child dari crm_customer_company
                        $data_banding->company_grouping[$pst['company_grouping']]->company = array_merge($data_lama,$update_data_lama);
                        $data_json_old = json_encode($data_banding);
                        $this->nbscache->put_all("crmtrans_account", $data_json_old);
                    }
            }
            $kirim['c_crmtrans_account'] = $pst['company_grouping'];  
          }

        $this->global_models->update("crm_customer_company", array("id_crm_customer_company" => $pst['id_crm_customer_company']), $kirim);
        $this->db->trans_commit();
        $id_crm_customer_company = $pst['id_crm_customer_company'];
      }
      else{
         $this->db->trans_begin();
        $kodeparent = $this->global_models->get_field("crm_customer_company", "code", array("id_crm_customer_company" => $pst['parent']));
        $kirim = array(
          "title"                           => strtoupper($pst['title']),
          "kode"                            => strtoupper($pst['kode']),
          "code"                            => "{$kodeparent}-{$pst['parent']}-",
          "location"                        => $pst['location'],
          "telp"                            => $pst['telp'],
          "telp2"                           => $pst['telp2'],        
          "email"                           => $pst['email'],
          'type'                            => $pst['type'],        
          "utama"                           => $truefalse[$pst['utama']],
          "status"                          => 2,
          "create_by_users"                 => $this->session->userdata("id"),
          "create_date"                     => date("Y-m-d H:i:s")
        );
          
        if($pst['parent']){
          $kirim['parent'] = $pst['parent'];		
         }else{
          $kirim['c_crmtrans_account'] = $pst['company_grouping'];  
         }
         
        $id_crm_customer_company = $this->global_models->insert("crm_customer_company", $kirim);

        if($pst['parent']){
           $c_crmtrans_account = $this->global_models->get_field("crm_customer_company","c_crmtrans_account",array("id_crm_customer_company" => "{$pst['parent']}"));
           
           if($c_crmtrans_account){
                $data_json = $this->nbscache->get("crmtrans_account");
                $data_banding = json_decode($data_json);
                
                $data_banding->company_grouping[$c_crmtrans_account]->company[] = $id_crm_customer_company;
                $data_json = json_encode($data_banding);
                $this->nbscache->put_all("crmtrans_account", $data_json);
            } 
        }
		//insert disc sesuai parent
    $list = $this->global_models->get_query("SELECT A.id_crm_customer_company"
      . " ,id_crm_pos_discount FROM crm_customer_company_discount AS A"
      . " WHERE A.id_crm_customer_company= '{$pst['parent']}'");
	   $kirim_discount[] = $id_crm_customer_company;
	    $this->load->model("crm/m_crmdiscount");
		foreach ($list AS $ls){		  
		  $pos_discount = $ls->id_crm_pos_discount;
		 // $this->m_crmdiscount->discount_company_clear($pos_discount, $kirim_discount);
		  $discount = $this->m_crmdiscount->discount_company_set($pos_discount,  $kirim_discount );			
		}
		
	   //end insert disc
		
      }
      $this->db->trans_commit();
      $balik['status'] = 2;
      $balik['data']  = $this->_format_return_single_record($id_crm_customer_company);
     }else{
        $dtnote = "";
        if(trim($pst['kode']) == ""){
            $dtnote .= "Code Must Filled <br>";
        }
            
        if(trim($pst['title']) == ""){
            $dtnote .= "Title Must Filled";
        }
        $balik = array("status" => 3,
                      "note"    => $dtnote);
            
     }
      
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Access Forbiden");
    }
    print json_encode($balik);
    die;
  }
  
  function company_discount_delete(){
      $pst = $this->input->post();
      
     
      $get = $this->global_models->get("crm_customer_company_discount",array("id_crm_customer_company_discount" => "{$pst['id']}"));
      
      if($get[0]->id_crm_pos_discount){
          
      $list = $this->global_models->get_query("SELECT A.id_crm_customer_company"
      . " FROM crm_customer_company AS A"
      . " WHERE A.parent ='{$get[0]->id_crm_customer_company}' ");
      
      $kirim_discount = array();
      foreach ($list AS $ls){
      $kirim_discount[] = $ls->id_crm_customer_company;
        }
    
    $get_old = $this->global_models->get("crm_pos_discount_company",array("id_crm_pos_discount" => "{$get[0]->id_crm_pos_discount}"));
        
        $kirim_discount_old = array();
        foreach ($get_old AS $ls){
        $kirim_discount_old[] = $ls->id_crm_customer_company;
        }

    $kirim_discount = array_intersect($kirim_discount,$kirim_discount_old);
    
       $this->global_models->trans_begin();
       $this->load->model("crm/m_crmdiscount");
       $this->m_crmdiscount->discount_company_clear($get[0]->id_crm_pos_discount, $kirim_discount);
       $this->global_models->delete("crm_customer_company_discount", array("id_crm_customer_company_discount" => "{$get[0]->id_crm_customer_company_discount}"));
        $this->global_models->trans_commit();
        $balik= array("status" => 2,
                      "note" => "Success");
      }else{
        $balik = array("status" => 3,
                       "note" => "Failed Proses");  
      }
      
      print json_encode($balik);
      die;
    }
  function company_discount_set(){
    $pst = $this->input->post();
    
    if($pst['id_crm_customer_company']){
        if($pst['id_crm_pos_discount']){
       $cek = $this->global_models->get("crm_customer_company_discount",
               array("id_crm_customer_company" => "{$pst['id_crm_customer_company']}",
                     "id_crm_pos_discount" => "{$pst['id_crm_pos_discount']}"
                     ));
   
    if($cek[0]->id_crm_customer_company_discount == ""){              
    $this->global_models->trans_begin();
    $this->global_models->generate_id($id_crm_customer_company_discount, "crm_customer_company_discount");
    $kirim = array(
      "id_crm_customer_company_discount"  => $id_crm_customer_company_discount,
      "id_crm_customer_company"           => $pst['id_crm_customer_company'],
      "id_crm_pos_discount"               => $pst['id_crm_pos_discount'],
      "create_by_users"                   => $this->session->userdata("id"),
      "create_date"                       => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_customer_company_discount", $kirim);
    
    $list = $this->global_models->get_query("SELECT A.id_crm_customer_company"
      . " FROM crm_customer_company AS A"
      . " WHERE A.code LIKE '---{$pst['id_crm_customer_company']}-%'");
    $kirim_discount = array();
    foreach ($list AS $ls){
      $kirim_discount[] = $ls->id_crm_customer_company;
    }
    
    $get_old = $this->global_models->get("crm_pos_discount_company",array("id_crm_pos_discount" => "{$pst['id_crm_pos_discount']}"));
    
    $kirim_discount_old = array();
    foreach ($get_old AS $ls){
      $kirim_discount_old[] = $ls->id_crm_customer_company;
    }
    
    
    $update_data_baru =  array_diff(array_merge($kirim_discount_old,$kirim_discount),array_intersect($kirim_discount_old, $kirim_discount));
    
    $this->load->model("crm/m_crmdiscount");
    $this->m_crmdiscount->discount_company_clear($pst['id_crm_pos_discount'], $kirim_discount_old);
    $discount = $this->m_crmdiscount->discount_company_set($pst['id_crm_pos_discount'], $update_data_baru);
    
    
    $this->global_models->trans_commit();
    $balik['data']  = $this->_company_discount_format_return_single_record($id_crm_customer_company_discount);
    $balik['status']  = 2;
    }else{
       $balik['status']  = 3;
       $balik['note']  = "Failed Proses";
    }
        }else{
         $balik['status']  = 3;
         $balik['note']  = "Please choice Diskon";
        }
    }else{
        $balik['status']  = 3;
        $balik['note']  = "Please Select Channel Type";
    }
    print json_encode($balik);
    die;
  }
  
  function company_status(){
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
  
  private function _format_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.kode AS code, A.parent, A.title, A.id_crm_customer_company, A.status, A.location"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.parent) AS kepala"
      . " FROM crm_customer_company AS A"
      . " WHERE A.id_crm_customer_company = '{$id}'");
    $status = $this->global_variable->status(1);
    
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm company-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    
    $return = array(
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
          "view"    => "<a href='".site_url("crm/customer-master/company/{$id}")."'>{$data[0]->title}</a>",
          "value"   => $data[0]->title
        ),
        array(
          "view"    => $data[0]->location,
          "value"   => $data[0]->location
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
      "id"      => $id,
    );
    
    return $return;
  }
    
  function company_get(){
    $pst = $this->input->post();
    if($pst['parent']){
      $where = " WHERE A.parent = '{$pst['parent']}'";
    }
    else{
      $where = " WHERE A.parent IS NULL";
    }
    $data = $this->global_models->get_query("SELECT A.kode AS code, A.parent, A.title, A.id_crm_customer_company, A.status, A.location"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.parent) AS kepala"
      . " FROM crm_customer_company AS A"
      . " {$where}"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_customer_company}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm company-active' isi='{$dt->id_crm_customer_company}'><i class='fa fa-check'></i></button>");
      $status = $this->global_variable->status(1);
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
            "view"    => "<a href='".site_url("crm/customer-master/company/{$dt->id_crm_customer_company}")."'>{$dt->title}</a>",
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->location,
            "value"   => $dt->location
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
	
	function company_all_get(){
    $pst = $this->input->post();
    // if($pst['parent']){
      // $where = " WHERE A.parent = '{$pst['parent']}'";
    // }
    // else{
      // $where = " WHERE A.parent IS NULL";
    // }
    $data = $this->global_models->get_query("SELECT A.kode AS code, A.parent, A.title, A.id_crm_customer_company, A.status, A.location"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.parent) AS kepala"
      . " FROM crm_customer_company AS A"
      . " WHERE A.parent IS NOT NULL"
      . " ORDER BY A.parent ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_customer_company}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm company-active' isi='{$dt->id_crm_customer_company}'><i class='fa fa-check'></i></button>");
      $status = $this->global_variable->status(1);
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
            "view"    => "<a href='".site_url("crm/customer-master/company/{$dt->id_crm_customer_company}")."'>{$dt->title}</a>",
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->location,
            "value"   => $dt->location
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
  
  function company_discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS discount"
      . " FROM crm_customer_company_discount AS A"
      . " WHERE A.id_crm_customer_company = '{$pst['id_crm_customer_company']}'"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm discount-delete' isi='{$dt->id_crm_customer_company_discount}'><i class='fa fa-times'></i></button>";
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->discount,
            "value"   => $dt->discount
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer_company_discount
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
  
  
  function customer_set(){
    $pst = $this->input->post();
    
    if($pst['id_crm_customer_company'] != "" AND $pst['name'] != ""){
    if($pst['id_crm_customer']){
      $kirim = array(
        "title"                      => $pst['title'],
        "id_users"                   => $pst['id_users'],
        "name"                       => strtoupper($pst['name']),
        "telp"                       => $pst['telp'],
        "handphone"                  => $pst['handphone'],  
        "email"                      => $pst['email'],
        "division"                   => $pst['division'],  
        "telp"                       => $pst['telp'],
        "fax"                        => $pst['fax'],
        "note"                       => $pst['note'],  
        "id_crm_customer_company"    => $pst['id_crm_customer_company'],
        "update_by_users"            => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_customer", array("id_crm_customer" => $pst['id_crm_customer']), $kirim);
      $id_crm_customer = $pst['id_crm_customer'];
    }
    else{
      $this->global_models->generate_id($id_crm_customer, "crm_customer");
      $kirim = array(
        "id_crm_customer"            => $id_crm_customer,
        "title"                      => $pst['title'],
        "id_users"                   => $pst['id_users'],
        "name"                       => strtoupper($pst['name']),
        "telp"                       => $pst['telp'],
        "handphone"                  => $pst['handphone'],   
        "email"                      => $pst['email'],
        "division"                   => $pst['division'],  
        "fax"                        => $pst['fax'],
        "note"                       => $pst['note'],   
        "id_crm_customer_company"    => $pst['id_crm_customer_company'],
        "create_by_users"            => $this->session->userdata("id"),
        "create_date"                => date("Y-m-d H:i:s")
      );
      $id_crm_customer = $this->global_models->insert("crm_customer", $kirim);
      
    }
     $balik['status']= 2;
     $balik['data']  = $this->_customer_return_single_record($id_crm_customer);
    }else{
        $note = "";
        
        if($pst['flag'] == 2){
          if($pst['id_crm_customer_company'] == ""){
            $note .= "Please Choice List Group Customer <br>";
          }
        }else{
          if($pst['id_crm_customer_company'] == ""){
            $note .= "Customer Must Filled <br>";
          }
        }
        
        if($pst['name'] == ""){
            $note .= "Name Must Filled";
        }
        
      $balik = array("status" => 3,
                 "note" => $note);  
    }
    
   
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
  
  private function _customer_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT CONCAT(B.title,'|',B.kode) FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
      . " ,(SELECT C.name FROM m_users AS C WHERE C.id_users = A.id_users) AS users"
      . " FROM crm_customer AS A"
      . " WHERE A.id_crm_customer = '{$id}'");
    $dt = $data[0];
    $company = explode("|", $dt->company);
    $title = $this->global_variable->title_name();
    $return = array(
      "data"    => array(
        array(
          "view"    => $company[1],
          "value"   => $company[1]
        ),
        array(
          "view"    => $company[0],
          "value"   => $company[0]
        ),
        array(
          "view"    => $title[$dt->title]." {$dt->name}",
          "value"   => $title[$dt->title]." {$dt->name}"
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
          "view"    => $dt->users,
          "value"   => $dt->users
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
    
  private function _company_discount_format_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS discount"
      . " FROM crm_customer_company_discount AS A"
      . " WHERE A.id_crm_customer_company_discount = '{$id}'");
    $dt = $data[0];
    $button = "<button class='btn btn-danger btn-sm discount-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    $return = array(
      "data"    => array(
        array(
            "view"    => $dt->discount,
            "value"   => $dt->discount
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
    
  function customer_get(){
    $pst = $this->input->post();
    $where = "";
    if($pst["id_crm_customer_company"]){
        $where = "WHERE A.id_crm_customer_company ='{$pst["id_crm_customer_company"]}' ";
    }
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT CONCAT(B.title,'|',B.kode) FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
      . " ,(SELECT C.name FROM m_users AS C WHERE C.id_users = A.id_users) AS users"
      . " FROM crm_customer AS A {$where} "
      . " ORDER BY A.id_crm_customer_company ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $title = $this->global_variable->title_name();
    foreach ($data AS $dt){
      $company = explode("|", $dt->company);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $company[1],
            "value"   => $company[1]
          ),
          array(
            "view"    => $company[0],
            "value"   => $company[0]
          ),
          array(
            "view"    => $title[$dt->title]." {$dt->name}",
            "value"   => $title[$dt->title]." {$dt->name}"
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
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer
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
  
  function customer_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_customer", array("id_crm_customer" => $pst['id']));
    $hasil = array(
      "name"                    => $data[0]->name,
      "telp"                    => $data[0]->telp,
      "title"                   => $data[0]->title,  
      "email"                   => $data[0]->email,
      "division"                => $data[0]->division,  
      "handphone"               => $data[0]->handphone,
      "fax"                     => $data[0]->fax,
      "note"                    => $data[0]->note,
      "id_crm_customer_company" => $data[0]->id_crm_customer_company,
      "id_crm_customer"         => $data[0]->id_crm_customer,
    );
    print json_encode($hasil);
    die;
  }
  
  function company_credit_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_customer_company", array("id_crm_customer_company" => $pst['id']));
    $hasil = array(
      "id_crm_customer_company" => $data[0]->id_crm_customer_company,
    );
    print json_encode($hasil);
    die;
  }
  
  function company_credit_get(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $data = $this->global_models->get_query("SELECT A.kode, A.id_crm_customer_company, A.title"
      . " ,(SELECT B.credit FROM crm_customer_company_credit AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS credit"
      . " FROM crm_customer_company AS A"
      . " ORDER BY A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => number_format($dt->credit),
            "value"   => $dt->credit,
            "class"   => "kanan"
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
  
  function company_credit_set(){
    $pst = $this->input->post();
    $this->load->model("crm/m_crmcustomer");
//    $this->debug($pst, true);
    if($pst['status'] == 1){
      $id_crm_customer_company_credit_log = $this->m_crmcustomer->company_credit_add($pst);
    }
    else{
      $id_crm_customer_company_credit_log = $this->m_crmcustomer->company_credit_reduce($pst);
    }
    $hasil['status']  = 2;
    $hasil['data_log']    = $this->_company_credit_log_return_single_record($id_crm_customer_company_credit_log);
    $hasil['data']        = $this->_company_credit_return_single_record($pst['id_crm_customer_company']);
    print json_encode($hasil);
    die;
  }
  
  function company_credit_log_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.in, A.out, A.tanggal, A.id_crm_customer_company_credit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_company_credit_log AS A"
      . " WHERE A.id_crm_customer_company = '{$pst['id_crm_customer_company']}'"
      . " ORDER BY A.tanggal DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => $dt->tangga
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => number_format($dt->in),
            "value"   => $dt->in,
            "class"   => "kanan"
          ),
          array(
            "view"    => number_format($dt->out),
            "value"   => $dt->out,
            "class"   => "kanan"
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer_company_credit_log
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
  
  private function _company_credit_log_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.in, A.out, A.tanggal, A.id_crm_customer_company_credit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_company_credit_log AS A"
      . " WHERE A.id_crm_customer_company_credit_log = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->tanggal,
          "value"   => $data[0]->tanggal
        ),
        array(
          "view"    => $data[0]->users,
          "value"   => $data[0]->users
        ),
        array(
          "view"    => number_format($data[0]->in),
          "value"   => $data[0]->in,
          "class"   => "kanan"
        ),
        array(
          "view"    => number_format($data[0]->out),
          "value"   => $data[0]->out,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
  
  private function _company_credit_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.kode, A.id_crm_customer_company, A.title"
      . " ,(SELECT B.credit FROM crm_customer_company_credit AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS credit"
      . " FROM crm_customer_company AS A"
      . " WHERE A.id_crm_customer_company = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->kode,
          "value"   => $data[0]->kode
        ),
        array(
          "view"    => $data[0]->title,
          "value"   => $data[0]->title
        ),
        array(
          "view"    => number_format($data[0]->credit),
          "value"   => $data[0]->credit,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
	
	function company_deposit_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_customer_company", array("id_crm_customer_company" => $pst['id']));
    $hasil = array(
      "id_crm_customer_company" => $data[0]->id_crm_customer_company,
    );
    print json_encode($hasil);
    die;
  }
  
  function company_deposit_get(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $data = $this->global_models->get_query("SELECT A.kode, A.id_crm_customer_company, A.title"
      . " ,(SELECT B.deposit FROM crm_customer_company_deposit AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS deposit"
      . " FROM crm_customer_company AS A"
//      . " WHERE A.utama = 1"
      . " ORDER BY deposit DESC, A.code ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => number_format($dt->deposit),
            "value"   => $dt->deposit,
            "class"   => "kanan"
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
  
  function company_deposit_set(){
    $pst = $this->input->post();
    $this->load->model("crm/m_crmcustomer");
//    $this->debug($pst, true);
    if($pst['status'] == 1){
      $id_crm_customer_company_deposit_log = $this->m_crmcustomer->company_deposit_add($pst);
    }
    else{
      $id_crm_customer_company_deposit_log = $this->m_crmcustomer->company_deposit_reduce($pst);
    }
    $hasil['status']  = 2;
    $hasil['data_log']    = $this->_company_deposit_log_return_single_record($id_crm_customer_company_deposit_log);
    $hasil['data']        = $this->_company_deposit_return_single_record($pst['id_crm_customer_company']);
    print json_encode($hasil);
    die;
  }
  
  function company_deposit_log_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.tabledatabase,A.id,A.note,A.credit, A.debit, A.tanggal, A.id_crm_customer_company_deposit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_company_deposit_log AS A"
      . " WHERE A.id_crm_customer_company = '{$pst['id_crm_customer_company']}' AND A.status IN(1,11)"
      . " ORDER BY A.tanggal DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $no = "";
    if($dt->tabledatabase == "crm_payment_kasir"){
        $h = $this->global_models->get_query("SELECT (SELECT B.no_bill FROM crm_payment_bill AS B WHERE B.id_crm_payment_bill = A.id_crm_payment_bill LIMIT 0,1) AS no_bill"
        . " ,(SELECT C.nomor FROM crm_payment AS C WHERE C.id_crm_payment = A.id_crm_payment) AS no_payment"
        . " FROM crm_payment_kasir AS A "
        . " WHERE A.id_crm_payment_kasir='{$dt->id}'");
        $no = "<label style='font-size:90%' class='label label-primary'>".$h[0]->no_payment."<br>".$h[0]->no_bill."</label>";
    }
    if($no){
        $note = $no;
    }else{
        $note = $dt->note;
    }
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => $dt->tangga
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => number_format($dt->debit),
            "value"   => $dt->debit,
            "class"   => "kanan"
          ),
          array(
            "view"    => number_format($dt->credit),
            "value"   => $dt->credit,
            "class"   => "kanan"
          ),
          array(
            "view"    => $note,
            "value"   => $note,
          ),  
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer_company_deposit_log
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
  
  private function _company_deposit_log_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.credit, A.debit, A.tanggal, A.id_crm_customer_company_deposit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_company_deposit_log AS A"
      . " WHERE A.id_crm_customer_company_deposit_log = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->tanggal,
          "value"   => $data[0]->tanggal
        ),
        array(
          "view"    => $data[0]->users,
          "value"   => $data[0]->users
        ),
        array(
          "view"    => number_format($data[0]->debit),
          "value"   => $data[0]->debit,
          "class"   => "kanan"
        ),
        array(
          "view"    => number_format($data[0]->credit),
          "value"   => $data[0]->credit,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
  
  private function _company_deposit_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.kode, A.id_crm_customer_company, A.title"
      . " ,(SELECT B.deposit FROM crm_customer_company_deposit AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS deposit"
      . " FROM crm_customer_company AS A"
      . " WHERE A.id_crm_customer_company = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->kode,
          "value"   => $data[0]->kode
        ),
        array(
          "view"    => $data[0]->title,
          "value"   => $data[0]->title
        ),
        array(
          "view"    => number_format($data[0]->deposit),
          "value"   => $data[0]->deposit,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
	
	function customer_deposit_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_customer", array("id_crm_customer" => $pst['id']));
    $hasil = array(
      "id_crm_customer" => $data[0]->id_crm_customer,
    );
    print json_encode($hasil);
    die;
  }
  
  function customer_deposit_get(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $data = $this->global_models->get_query("SELECT A.id_crm_customer, A.name, A.email, A.telp"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
			. " ,(SELECT B.deposit FROM crm_customer_deposit AS B WHERE B.id_crm_customer = A.id_crm_customer) AS deposit"
      . " FROM crm_customer AS A"
      . " ORDER BY A.name ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
					array(
            "view"    => $dt->name,
            "value"   => $dt->name
          ),
          array(
            "view"    => $dt->company,
            "value"   => $dt->company
          ),
          array(
            "view"    => $dt->email,
            "value"   => $dt->email
          ),
					array(
            "view"    => $dt->telp,
            "value"   => $dt->telp
          ),
          array(
            "view"    => number_format($dt->deposit),
            "value"   => $dt->deposit,
            "class"   => "kanan"
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer
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
  
  function customer_deposit_set(){
    $pst = $this->input->post();
    $this->load->model("crm/m_crmcustomer");
//    $this->debug($pst, true);
    if($pst['status'] == 1){
      $id_crm_customer_deposit_log = $this->m_crmcustomer->customer_deposit_add($pst);
    }
    else{
      $id_crm_customer_deposit_log = $this->m_crmcustomer->customer_deposit_reduce($pst);
    }
    $hasil['status']  = 2;
    $hasil['data_log']    = $this->_customer_deposit_log_return_single_record($id_crm_customer_deposit_log);
    $hasil['data']        = $this->_customer_deposit_return_single_record($pst['id_crm_customer']);
    print json_encode($hasil);
    die;
  }
  
  function customer_deposit_log_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.in, A.out, A.tanggal, A.id_crm_customer_deposit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_deposit_log AS A"
      . " WHERE A.id_crm_customer = '{$pst['id_crm_customer']}'"
      . " ORDER BY A.tanggal DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->tanggal,
            "value"   => $dt->tangga
          ),
          array(
            "view"    => $dt->users,
            "value"   => $dt->users
          ),
          array(
            "view"    => number_format($dt->in),
            "value"   => $dt->in,
            "class"   => "kanan"
          ),
          array(
            "view"    => number_format($dt->out),
            "value"   => $dt->out,
            "class"   => "kanan"
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_customer_deposit_log
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
  
  private function _customer_deposit_log_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.in, A.out, A.tanggal, A.id_crm_customer_deposit_log"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.id_users) AS users"
      . " FROM crm_customer_deposit_log AS A"
      . " WHERE A.id_crm_customer_deposit_log = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->tanggal,
          "value"   => $data[0]->tanggal
        ),
        array(
          "view"    => $data[0]->users,
          "value"   => $data[0]->users
        ),
        array(
          "view"    => number_format($data[0]->in),
          "value"   => $data[0]->in,
          "class"   => "kanan"
        ),
        array(
          "view"    => number_format($data[0]->out),
          "value"   => $data[0]->out,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
  
  private function _customer_deposit_return_single_record($id){
    $data = $this->global_models->get_query("SELECT A.id_crm_customer, A.name, A.email, A.telp"
      . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
			. " ,(SELECT B.deposit FROM crm_customer_deposit AS B WHERE B.id_crm_customer = A.id_crm_customer) AS deposit"
      . " FROM crm_customer AS A"
      . " WHERE A.id_crm_customer = '{$id}'");
    
    $return = array(
      "data"    => array(
        array(
          "view"    => $data[0]->name,
          "value"   => $data[0]->name
        ),
				array(
          "view"    => $data[0]->company,
          "value"   => $data[0]->company
        ),
				array(
          "view"    => $data[0]->email,
          "value"   => $data[0]->email
        ),
        array(
          "view"    => $data[0]->telp,
          "value"   => $data[0]->telp
        ),
        array(
          "view"    => number_format($data[0]->deposit),
          "value"   => $data[0]->deposit,
          "class"   => "kanan"
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    
    return $return;
  }
  
  function company_pricing_scheme_set(){
    $pst = $this->input->post();
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    $kirim = array(
      "pricing_type"        => $truefalse[$pst['type']],
      "margin"              => $pst['margin'],
      "management_fee"      => $pst['fee'],
      "update_by_users"     => $this->session->userdata("id")
    );
    $this->global_models->update("crm_customer_company", array("id_crm_customer_company" => $pst['id_crm_customer_company']), $kirim);
    $hasil['status']  = 2;
    print json_encode($hasil);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */