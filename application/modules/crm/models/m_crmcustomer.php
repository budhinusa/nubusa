<?php
class M_crmcustomer extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function company_credit_add($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_credit_log, "crm_customer_company_credit_log");
    $kirim = array(
      "id_crm_customer_company_credit_log"    => $id_crm_customer_company_credit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "in"                                    => $pst['credit'],
      "out"                                   => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    if($this->global_models->get_field("crm_customer_company_credit", "id_crm_customer_company", array("id_crm_customer_company" => $pst['id_crm_customer_company']))){
      $this->global_models->query("UPDATE crm_customer_company_credit"
        . " SET credit = credit + {$pst['credit']}"
        . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
    }
    else{
      $this->global_models->generate_id($id_crm_customer_company_credit, "crm_customer_company_credit");
      $kirim_new = array(
        "id_crm_customer_company_credit"    => $id_crm_customer_company_credit,
        "id_crm_customer_company"           => $pst['id_crm_customer_company'],
        "credit"                            => $pst['credit'],
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_customer_company_credit", $kirim_new);
    }
    $this->global_models->insert("crm_customer_company_credit_log", $kirim);
    return $id_crm_customer_company_credit_log;
  }
  
  function company_credit_log_create($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_credit_log, "crm_customer_company_credit_log");
    //log status 10 create
    $kirim = array(
      "id_crm_customer_company_credit_log"    => $id_crm_customer_company_credit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => 10,
      "in"                                    => $pst['credit'],
      "out"                                   => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    
    $id_crm_customer_company_credit = $this->global_models->get_field("crm_customer_company_credit", "id_crm_customer_company_credit", array("id_crm_customer_company" => $pst['id_crm_customer_company']));
    
    if(!$id_crm_customer_company_credit){
      $this->global_models->generate_id($id_crm_customer_company_credit, "crm_customer_company_credit");
      $kirim_new = array(
        "id_crm_customer_company_credit"    => $id_crm_customer_company_credit,
        "id_crm_customer_company"           => $pst['id_crm_customer_company'],
        "credit"                            => 0,
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_customer_company_credit", $kirim_new);
    }
    
    $this->global_models->insert("crm_customer_company_credit_log", $kirim);
    
    return $id_crm_customer_company_credit_log;
  }
  
  function company_credit_void($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_credit_log, "crm_customer_company_credit_log");
    $kirim = array(
      "id_crm_customer_company_credit_log"    => $id_crm_customer_company_credit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "in"                                    => $pst['credit'],
      "out"                                   => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    $this->global_models->query("UPDATE crm_customer_company_credit"
      . " SET credit = credit + {$pst['credit']}"
      . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
    $this->global_models->insert("crm_customer_company_credit_log", $kirim);
    return $id_crm_customer_company_credit_log;
  }
  
  function company_credit_reduce($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_credit_log, "crm_customer_company_credit_log");
    $kirim = array(
      "id_crm_customer_company_credit_log"    => $id_crm_customer_company_credit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "in"                                    => 0,
      "out"                                   => $pst['credit'],
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    $this->global_models->query("UPDATE crm_customer_company_credit"
      . " SET credit = credit - {$pst['credit']}"
      . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
    $this->global_models->insert("crm_customer_company_credit_log", $kirim);
    return $id_crm_customer_company_credit_log;
  }
	
    function company_deposit_add($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_deposit_log, "crm_customer_company_deposit_log");
    $kirim = array(
      "id_crm_customer_company_deposit_log"    => $id_crm_customer_company_deposit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "credit"                                => $pst['deposit'],
      "debit"                                 => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    if($this->global_models->get_field("crm_customer_company_deposit", "id_crm_customer_company", array("id_crm_customer_company" => $pst['id_crm_customer_company']))){
      $this->global_models->query("UPDATE crm_customer_company_deposit"
        . " SET deposit = deposit + {$pst['deposit']}"
        . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
    }
    else{
      $this->global_models->generate_id($id_crm_customer_company_deposit, "crm_customer_company_deposit");
      $kirim_new = array(
        "id_crm_customer_company_deposit"    => $id_crm_customer_company_deposit,
        "id_crm_customer_company"           => $pst['id_crm_customer_company'],
        "deposit"                            => $pst['deposit'],
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_customer_company_deposit", $kirim_new);
    }
    $this->global_models->insert("crm_customer_company_deposit_log", $kirim);
    return $id_crm_customer_company_deposit_log;
  }
  
  function company_deposit_void($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_deposit_log, "crm_customer_company_deposit_log");
    $kirim = array(
      "id_crm_customer_company_deposit_log"    => $id_crm_customer_company_deposit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "credit"                                => $pst['deposit'],
      "debit"                                 => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    $this->global_models->query("UPDATE crm_customer_company_deposit"
      . " SET deposit = deposit + {$pst['deposit']}"
      . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
		$this->global_models->insert("crm_customer_company_deposit_log", $kirim);
    return $id_crm_customer_company_deposit_log;
  }
  
  function company_deposit_reduce($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_company_deposit_log, "crm_customer_company_deposit_log");
    $kirim = array(
      "id_crm_customer_company_deposit_log"    => $id_crm_customer_company_deposit_log,
      "id_crm_customer_company"               => $pst['id_crm_customer_company'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "credit"                                => 0,
      "debit"                                 => $pst['deposit'],
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    $this->global_models->query("UPDATE crm_customer_company_deposit"
      . " SET deposit = deposit - {$pst['deposit']}"
      . " WHERE id_crm_customer_company = '{$pst['id_crm_customer_company']}'");
		$this->global_models->insert("crm_customer_company_deposit_log", $kirim);
    return $id_crm_customer_company_deposit_log;
  }
	
	function customer_deposit_add($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_deposit_log, "crm_customer_deposit_log");
    $kirim = array(
      "id_crm_customer_deposit_log"    => $id_crm_customer_deposit_log,
      "id_crm_customer"               => $pst['id_crm_customer'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "in"                                    => $pst['deposit'],
      "out"                                   => 0,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    if($this->global_models->get_field("crm_customer_deposit", "id_crm_customer", array("id_crm_customer" => $pst['id_crm_customer']))){
      $this->global_models->query("UPDATE crm_customer_deposit"
        . " SET deposit = deposit + {$pst['deposit']}"
        . " WHERE id_crm_customer = '{$pst['id_crm_customer']}'");
    }
    else{
      $this->global_models->generate_id($id_crm_customer_deposit, "crm_customer_deposit");
      $kirim_new = array(
        "id_crm_customer_deposit"    => $id_crm_customer_deposit,
        "id_crm_customer"           => $pst['id_crm_customer'],
        "deposit"                            => $pst['deposit'],
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_customer_deposit", $kirim_new);
    }
    $this->global_models->insert("crm_customer_deposit_log", $kirim);
    return $id_crm_customer_deposit_log;
  }
  
  function customer_deposit_reduce($pst, $id = NULL, $tabledatabase = NULL){
    $this->global_models->generate_id($id_crm_customer_deposit_log, "crm_customer_deposit_log");
    $kirim = array(
      "id_crm_customer_deposit_log"    => $id_crm_customer_deposit_log,
      "id_crm_customer"               => $pst['id_crm_customer'],
      "id_users"                              => $this->session->userdata("id"),
      "id"                                    => $id,
      "tabledatabase"                         => $tabledatabase,
      "status"                                => $pst['status'],
      "in"                                    => 0,
      "out"                                   => $pst['deposit'],
      "tanggal"                               => date("Y-m-d H:i:s"),
      "note"                                  => $pst['note'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s"),
    );
    $this->global_models->query("UPDATE crm_customer_deposit"
      . " SET deposit = deposit - {$pst['deposit']}"
      . " WHERE id_crm_customer = '{$pst['id_crm_customer']}'");
		$this->global_models->insert("crm_customer_deposit_log", $kirim);
    return $id_crm_customer_deposit_log;
  }
  
  function company_deposit_check($kirim){
    $deposit = $this->global_models->get_field("crm_customer_company_deposit", "deposit", array("id_crm_customer_company" => $kirim['id_crm_customer_company']));
    if($deposit >= $kirim["nominal"]){
      $hasil = array(
        "status"      => 2,
      );
    }
    else{
      $hasil = array(
        "status"      => 3,
        "nominal"     => $kirim["nominal"],
        "deposit"     => $deposit,
        "note"        => lang("Deposit tidak mencukupi"),
      );
    }
    return $hasil;
  }
  
  function company_credit_check($kirim){
   
    $deposit = $this->global_models->get_field("crm_customer_company_credit", "credit", array("id_crm_customer_company" => $kirim['id_crm_customer_company']));
    if($deposit >= $kirim["nominal"]){
      $hasil = array(
        "status"      => 2,
      );
    }
    else{
      $hasil = array(
        "status"      => 3,
        "nominal"     => $kirim["nominal"],
        "deposit"     => $credit,
        "note"        => lang("Credit tidak mencukupi"),
      );
    }
    return $hasil;
  }
  
  function company_dropdown_get($parent = NULL){
    $where = "(A.parent IS NOT NULL OR A.parent > 0)";
    if($parent)
      $where = "A.parent = '{$parent}'";
    $data_company = $this->global_models->get_query("SELECT A.id_crm_customer_company, A.title, A.kode"
      . " FROM crm_customer_company AS A"
      . " WHERE A.status = 1"
      . " AND {$where}"
      . " ORDER BY A.code ASC");
    foreach ($data_company AS $cs){
      $company[] = array(
        "id"    => $cs->id_crm_customer_company,
        "text"  => $cs->kode."-".$cs->title,
      );
      $company2[$cs->id_crm_customer_company] = $cs->kode."-".$cs->title;
    }
    $hasil['status'] = 2;
    $hasil['v1'] = $company2;
    $hasil['v2'] = $company;
    return $hasil;
  }
  
  function company_group_dropdown_get(){
    $data_company = $this->global_models->get_query("SELECT A.id_crm_customer_company, A.title, A.kode"
      . " FROM crm_customer_company AS A"
      . " WHERE A.status = 1"
      . " AND A.parent IS NULL"
      . " ORDER BY A.code ASC");
    foreach ($data_company AS $cs){
      $company[] = array(
        "id"    => $cs->id_crm_customer_company,
        "text"  => $cs->kode."-".$cs->title,
      );
      $company2[$cs->id_crm_customer_company] = $cs->kode."-".$cs->title;
    }
    $hasil['status'] = 2;
    $hasil['v1'] = $company2;
    $hasil['v2'] = $company;
    return $hasil;
  }
  
  function customer_company_active(){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_customer_company AS A"
      . " WHERE A.parent IS NOT NULL"
      . " AND A.id_crm_customer_company NOT IN ("
        . "SELECT B.id_crm_customer_company FROM crm_customer_company AS B WHERE kode LIKE CONCAT('%-',A.id_crm_customer_company,'-%')"
      . ")"
      . "ORDER BY A.title ASC");
    
    $dropdown[0] = "- Pilih -";
    $select2[] = array(
      "text"      => "- Pilih -",
      "id"        => 0,
    );
    foreach ($data AS $dt){
      $dropdown[$dt->id_crm_customer_company] = $dt->title;
      $select2[] = array(
        "text"      => $dt->title,
        "id"        => $dt->id_crm_customer_company,
      );
    }
    
    $return = array(
      "status"    => 2,
      "data"      => array(
        "dropdown"    => array(
          "standart"    => $dropdown,
          "select2"     => $select2,
        )
      )
    );
    return $return;
  }
  
  function session_customer_cek(){
    if($this->session->userdata("id") > 1 AND !$this->session->userdata("crm_customer")){
      $id_crm_customer = $this->global_models->get_field("crm_customer", "id_crm_customer", array("id_users" => $this->session->userdata("id")));
      if($id_crm_customer){
        $this->session->set_userdata(array(
          "crm_customer"    => $id_crm_customer
        ));
        $hasil = array(
          "status"  => 2
        );
      }
      else{
        redirect("crm/customer-settings/session-customer");
      }
    }
    else if($this->session->userdata("crm_customer")){
      $hasil = array(
        "status"  => 2
      );
    }
    else{
      redirect("crm/customer-settings/session-customer");
    }
    return $hasil;
  }
  
  function harga_customer($harga){
    $schema = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_customer_company AS A"
      . " LEFT JOIN crm_customer AS B ON B.id_crm_customer_company = A.id_crm_customer_company"
      . " WHERE B.id_crm_customer = '{$this->session->userdata("crm_customer")}'");
    if($schema){
      $discount = $schema[0]->margin/100 * $harga;
      $total = $harga - $discount;
      $fee = $schema[0]->management_fee/100 * $total;
      $return = array(
        "status"      => 2,
        "data"        => array(
          "basic"       => $harga,
          "discount"    => $discount,
          "fee"         => $fee,
          "type"        => $schema[0]->pricing_type,
        ),
      );
    }
    else{
      $return = array(
        "status"      => 3,
        "data"        => array(
          "basic"       => $harga,
          "discount"    => 0,
          "fee"         => 0,
          "type"        => 0,
        ),
      );
    }
    return $return;
  }
  
}
?>
