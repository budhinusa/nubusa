<?php
class Api_hrm extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function bs_set($kirim){
    $nomor = $this->global_models->generate_nomor_format('hrm_bs', 'hrm_bs', 'tanggal', date("Y-m-d H:i:s"));
    $this->global_models->generate_id($id_hrm_bs, 'hrm_bs');
    $kirim["id_hrm_bs"] = $id_hrm_bs;
    $kirim["nomor"] = $nomor['nomor'];
    $kirim["urut"] = $nomor['urut'];
    $kirim["status"] = 1;
    $kirim["create_by_users"] = $this->session->userdata("id");
    $kirim["create_date"] = date("Y-m-d H:i:s");
    $this->global_models->insert("hrm_bs", $kirim);
    $balik['status']    = 2;
    $balik['id_hrm_bs'] = $id_hrm_bs;
    return $balik;
  }
  
  function bs_closing_set($kirim){
    $nomor = $this->global_models->generate_nomor_format('hrm_bs_closing', 'hrm_bs_closing', 'tanggal', date("Y-m-d H:i:s"));
    $this->global_models->generate_id($id_hrm_bs_closing, 'hrm_bs_closing');
    $kirim["id_hrm_bs_closing"] = $id_hrm_bs_closing;
    $kirim["nomor"] = $nomor['nomor'];
    $kirim["urut"] = $nomor['urut'];
    $kirim["status"] = ($kirim['status'] ? $kirim['status'] : 1);
    $kirim["create_by_users"] = $this->session->userdata("id");
    $kirim["create_date"] = date("Y-m-d H:i:s");
    $this->global_models->insert("hrm_bs_closing", $kirim);
    $balik['status']    = 2;
    $balik['id_hrm_bs_closing'] = $id_hrm_bs_closing;
    return $balik;
  }
  
  function bs_update($kirim, $id_hrm_bs){
    $kirim["update_by_users"] = $this->session->userdata("id");
    $kirim["create_date"] = date("Y-m-d H:i:s");
    $this->global_models->update("hrm_bs", array("id_hrm_bs" => $id_hrm_bs), $kirim);
    $balik['status']    = 2;
    $balik['id_hrm_bs'] = $id_hrm_bs;
    return $balik;
  }
  
  function bs_closing_update($kirim, $id_hrm_bs_closing){
    $kirim["update_by_users"] = $this->session->userdata("id");
    $kirim["create_date"] = date("Y-m-d H:i:s");
    $this->global_models->update("hrm_bs_closing", array("id_hrm_bs_closing" => $id_hrm_bs_closing), $kirim);
    $balik['status']    = 2;
    $balik['id_hrm_bs_closing'] = $id_hrm_bs_closing;
    return $balik;
  }
}
?>
