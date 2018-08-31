<?php
class M_frm_master extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function frm_account_code($id_frm_account, $id_parent = NULL, $jml_digit = 1){
    $ref_parent = $this->global_models->get_field("frm_account", "ref", array("id_frm_account" => $id_parent));
    $code = ($ref_parent ? $ref_parent." " : "").str_pad($id_frm_account, $jml_digit, '0', STR_PAD_LEFT);
    $id_frm_account = $this->global_models->get_field("frm_account", "id_frm_account", array("id_frm_account" => $code));
    if($id_frm_account){
      $return = array(
        "status"  => 3,
        "note"    => lang("Digunakan")
      );
    }
    else{
      $return = array(
        "status"  => 2,
        "data"    => array(
          "nomor"     => $code
        ),
        "note"    => lang("Berhasil")
      );
    }
    return $return;
  }
  
}



?>
