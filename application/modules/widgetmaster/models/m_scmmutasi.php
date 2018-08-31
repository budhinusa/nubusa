<?php
class M_personal_development extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function history_projects_log($id, $data, $type, $tambahan = ""){
    $this->global_models->generate_id($id_hrm_dev_projects_log, "hrm_dev_projects_log");
    $post = array(
      "id_hrm_dev_projects_log" => $id_hrm_dev_projects_log,
      "id_hrm_dev_projects"     => $id,
      "type"                    => $type,
      "status"                  => $this->global_models->get_field("hrm_dev_projects", "status", array("id_hrm_dev_projects" => $id)),
      "note"                    => $this->history_projects_format($data, $tambahan),
      "create_by_users"         => $this->session->userdata("id"),
      "create_date"             => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("hrm_dev_projects_log", $post);
    return true;
  }
  
  function history_tasks_log($id, $data, $type, $tambahan = ""){
    $this->global_models->generate_id($id_hrm_dev_tasks_log, "hrm_dev_tasks_log");
    $post = array(
      "id_hrm_dev_tasks_log"    => $id_hrm_dev_tasks_log,
      "id_hrm_dev_tasks"        => $id,
      "type"                    => $type,
      "status"                  => $this->global_models->get_field("hrm_dev_tasks", "status", array("id_hrm_dev_tasks" => $id)),
      "note"                    => $this->history_tasks_format($data, $tambahan),
      "create_by_users"         => $this->session->userdata("id"),
      "create_date"             => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("hrm_dev_tasks_log", $post);
    return true;
  }
  
  function history_job_request_log($id, $data, $type, $tambahan = ""){
    $this->global_models->generate_id($id_hrm_dev_job_request_log, "hrm_dev_job_request_log");
    $post = array(
      "id_hrm_dev_job_request_log"  => $id_hrm_dev_job_request_log,
      "id_hrm_dev_job_request"      => $id,
      "type"                        => $type,
      "status"                      => $this->global_models->get_field("hrm_dev_job_request", "status", array("id_hrm_dev_job_request" => $id)),
      "note"                        => $this->history_job_request_format($data, $tambahan),
      "create_by_users"             => $this->session->userdata("id"),
      "create_date"                 => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("hrm_dev_job_request_log", $post);
    return true;
  }
  
  function history_projects_format($data, $tambahan = ""){
    $biodata = $this->global_models->get_query("SELECT A.first_name, A.last_name"
      . " ,(SELECT B.title FROM hrm_struktural AS B WHERE B.id_hrm_struktural = A.id_hrm_struktural) AS struktural"
      . " ,(SELECT C.title FROM hrm_fungsional AS C WHERE C.id_hrm_fungsional = A.id_hrm_fungsional) AS fungsional"
      . " FROM hrm_biodata AS A"
      . " WHERE A.id_hrm_biodata = '{$data['id_hrm_biodata']}'");
      
    $status = $this->global_variable->hrm_dev_projects_status(1);
    
    $isi = ""
      . "<dl>"
        . "<dt>".lang("Employee")."</dt>"
          . "<dd>{$biodata[0]->first_name} {$biodata[0]->last_name}</dd>"
        . "<dt>".lang("Fungsional")."</dt>"
          . "<dd>{$biodata[0]->fungsional}</dd>"
        . "<dt>".lang("Struktural")."</dt>"
          . "<dd>{$biodata[0]->struktural}</dd>"
        . "<dt>".lang("Title")."</dt>"
          . "<dd>{$data['title']}</dd>"
        . "<dt>".lang("Start Date")."</dt>"
          . "<dd>{$data['start_date']}</dd>"
        . "<dt>".lang("End Date")."</dt>"
          . "<dd>{$data['end_date']}</dd>"
        . "<dt>".lang("Status")."</dt>"
          . "<dd>{$status[$data['status']]}</dd>"
        . "<dt>".lang("Note")."</dt>"
          . "<dd>{$data['note']}</dd>"
        . "<dt>".lang("Tambahan")."</dt>"
          . "<dd>{$tambahan}</dd>"
      . "</dl>"
      . "";
    return $isi;
  }
  
  function history_tasks_format($data, $tambahan = ""){
    $biodata = $this->global_models->get_query("SELECT A.first_name, A.last_name"
      . " ,(SELECT B.title FROM hrm_struktural AS B WHERE B.id_hrm_struktural = A.id_hrm_struktural) AS struktural"
      . " ,(SELECT C.title FROM hrm_fungsional AS C WHERE C.id_hrm_fungsional = A.id_hrm_fungsional) AS fungsional"
      . " FROM hrm_biodata AS A"
      . " WHERE A.id_hrm_biodata = '{$data['id_hrm_biodata']}'");
      
    $biodata_own = $this->global_models->get_query("SELECT A.first_name, A.last_name"
      . " FROM hrm_biodata AS A"
      . " WHERE A.id_hrm_biodata = '{$data['id_hrm_biodata_own']}'");
      
    $status = $this->global_variable->hrm_dev_tasks_status(1);
    
    $isi = ""
      . "<dl>"
        . "<dt>".lang("Projects")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_dev_projects", "title", array("id_hrm_dev_projects" => $data['id_hrm_dev_projects']))}</dd>"
        . "<dt>".lang("Job Request")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_dev_projects", "title", array("id_hrm_dev_projects" => $data['id_hrm_dev_projects']))}</dd>"
        . "<dt>".lang("Title")."</dt>"
          . "<dd>{$data['title']}</dd>"
        . "<dt>".lang("Date")."</dt>"
          . "<dd>{$data['tanggal']}</dd>"
        . "<dt>".lang("Biodata Own")."</dt>"
          . "<dd>{$biodata_own[0]->first_name} {$biodata_own[0]->last_name}</dd>"
        . "<dt>".lang("Biodata")."</dt>"
          . "<dd>{$biodata[0]->first_name} {$biodata[0]->last_name}</dd>"
        . "<dt>".lang("Struktural")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_struktural", "title", array("id_hrm_struktural" => $data['id_hrm_struktural']))}</dd>"
        . "<dt>".lang("Category")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_dev_task_category", "title", array("id_hrm_dev_task_category" => $data['id_hrm_dev_task_category']))}</dd>"
        . "<dt>".lang("Range Date")."</dt>"
          . "<dd>{$data['start_date']} ".lang("sd")." {$data['end_date']}</dd>"
        . "<dt>".lang("Status")."</dt>"
          . "<dd>{$status[$data['status']]}</dd>"
        . "<dt>".lang("Note")."</dt>"
          . "<dd>{$data['note']}</dd>"
        . "<dt>".lang("Tambahan")."</dt>"
          . "<dd>{$tambahan}</dd>"
      . "</dl>"
      . "";
    return $isi;
  }
  
  function history_job_request_format($data, $tambahan = ""){
    $biodata = $this->global_models->get_query("SELECT A.first_name, A.last_name"
      . " FROM hrm_biodata AS A"
      . " WHERE A.id_hrm_biodata = '{$data['id_hrm_biodata']}'");
    $biodata2 = $this->global_models->get_query("SELECT A.first_name, A.last_name"
      . " FROM hrm_biodata AS A"
      . " WHERE A.id_hrm_biodata = '{$data['id_hrm_biodata_response']}'");
      
    $status = $this->global_variable->hrm_dev_job_request_status(1);
    
    $isi = ""
      . "<dl>"
        . "<dt>".lang("Projects")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_dev_projects", "title", array("id_hrm_dev_projects" => $data['id_hrm_dev_projects']))}</dd>"
        . "<dt>".lang("Title")."</dt>"
          . "<dd>{$data['title']}</dd>"
        . "<dt>".lang("Date")."</dt>"
          . "<dd>{$data['tanggal']}</dd>"
        . "<dt>".lang("Biodata")."</dt>"
          . "<dd>{$biodata[0]->first_name} {$biodata[0]->last_name}</dd>"
        . "<dt>".lang("Struktural")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_struktural", "title", array("id_hrm_struktural" => $data['id_hrm_struktural']))}</dd>"
        . "<dt>".lang("Date Response")."</dt>"
          . "<dd>{$data['tanggal_response']}</dd>"
        . "<dt>".lang("Biodata Response")."</dt>"
          . "<dd>{$biodata2[0]->first_name} {$biodata2[0]->last_name}</dd>"
        . "<dt>".lang("Destination")."</dt>"
          . "<dd>{$this->global_models->get_field("hrm_struktural", "title", array("id_hrm_struktural" => $data['id_hrm_struktural_destination']))}</dd>"
        . "<dt>".lang("Range Date")."</dt>"
          . "<dd>{$data['start_date']} ".lang("sd")." {$data['end_date']}</dd>"
        . "<dt>".lang("Status")."</dt>"
          . "<dd>{$status[$data['status']]}</dd>"
        . "<dt>".lang("Note")."</dt>"
          . "<dd>{$data['note']}</dd>"
        . "<dt>".lang("Tambahan")."</dt>"
          . "<dd>{$tambahan}</dd>"
      . "</dl>"
      . "";
    return $isi;
  }
  
  function history_contract_set($data){
    $this->global_models->generate_id($id_hrm_dev_contract_history, "hrm_dev_contract_history");
    $post = array(
      "id_hrm_dev_contract_history" => $id_hrm_dev_contract_history,
      "id_hrm_biodata"          => $data['id_hrm_biodata'],
      "title"                   => $data['title'],
      "note"                    => $data['note'],
      "create_by_users"         => $this->session->userdata("id"),
      "create_date"             => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("hrm_dev_contract_history", $post);
    return $id_hrm_dev_contract_history;
  }
  
}
?>
