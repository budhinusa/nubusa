<?php
class M_hrm extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function list_komando_fungsional_biodata($id_hrm_biodata, $id_hrm_struktural, $id_hrm_fungsional){
    $biodata = $this->global_models->get_query("SELECT A.id_hrm_biodata"
      . " FROM hrm_biodata AS A"
      . " WHERE (A.id_hrm_struktural IN (SELECT B.id_hrm_struktural FROM hrm_struktural_biodata AS B WHERE B.id_hrm_biodata = '{$id_hrm_biodata}')"
      . " OR A.id_hrm_struktural = '{$id_hrm_struktural}')"
      . " AND (SELECT C.sort FROM hrm_fungsional AS C WHERE C.id_hrm_fungsional = A.id_hrm_fungsional) >= (SELECT D.sort FROM hrm_fungsional AS D WHERE D.id_hrm_fungsional = '{$id_hrm_fungsional}')");
    foreach($biodata AS $bio){
      $in_temp .= ",'{$bio->id_hrm_biodata}'";
    }
    $in_temp = trim($in_temp, ",");
    $in = "({$in_temp})";
    return array(
      "in" => $in
    );
  }
  
  function list_komando_struktural($id_hrm_biodata){
    $multi = $this->global_models->get("hrm_struktural_biodata", array("id_hrm_biodata" => $id_hrm_biodata));
    foreach($multi AS $ml){
      $in_temp .= $this->get_anakan($ml->id_hrm_struktural);
    }
    $in_temp .= $this->get_anakan($this->global_models->get_field("hrm_biodata", "id_hrm_struktural", array("id_hrm_biodata" => $id_hrm_biodata)));
    $in_temp = trim($in_temp, ",");
    $in = "({$in_temp})";
    return array(
      "in" => $in
    );
  }
  
  function get_anakan($id_hrm_struktural){
    $code = $this->global_models->get_field("hrm_struktural", "code", array("id_hrm_struktural" => $id_hrm_struktural));
    $data = $this->global_models->get_query("SELECT D.id_hrm_struktural FROM hrm_struktural AS D WHERE D.code LIKE '{$code}-{$id_hrm_struktural}-%'");
    $return = ",{$id_hrm_struktural}";
    foreach ($data AS $dt){
      $return .= ",{$dt->id_hrm_struktural}";
    }
    return $return;
  }
  
  function cek_session_biodata(){
    if(!$this->session->userdata("hrm_biodata")){
      $hrm_biodata = $this->global_models->get("hrm_biodata", array("id_users" => $this->session->userdata("id")));
      if($hrm_biodata){
        if(count($hrm_biodata) > 1)
          redirect("hrm/hrm-settings/session-biodata");
        else{
          $this->session->set_userdata(array(
            "hrm_biodata"    => $hrm_biodata[0]->id_hrm_biodata,
            "hrm_struktural" => $hrm_biodata[0]->id_hrm_struktural,
            "hrm_fungsional" => $hrm_biodata[0]->id_hrm_fungsional,
          ));
          return TRUE;
        }
      }
      else if($this->session->userdata("id") == 1){
        redirect("hrm/hrm-settings/session-biodata");
      }
      else{
        $this->session->set_flashdata('notice', 'Tidak Ada Hak Akses Biodata');
        redirect($this->session->userdata('dashbord'));
      }
    }
    else{
      return TRUE;
    }
  }
  
}
?>
