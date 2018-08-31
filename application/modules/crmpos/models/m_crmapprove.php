<?php
class M_crmapprove extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function approve($id){
    $status = $this->global_models->get_field("crm_pos_quotation_discount", "status", array("id_crm_pos_quotation" => $id, "status" => 4));
    if($status)
      return true;
    else
      return false;
  }
  
  function order_approve($id){
    $status = $this->global_models->get_field("crm_pos_order_discount", "status", array("id_crm_pos_order" => $id, "status" => 4));
    if($status)
      return true;
    else
      return false;
  }
  
}
?>
