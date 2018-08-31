<?php
class Lokal_variable{
  function __construct(){      
  }
  
  function frm_account_position($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Normal")."</label>",
        2 => "<label class='label label-success'>".lang("Modal")."</label>",
        3 => "<label class='label label-info'>".lang("Laba/Rugi")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Normal"),
        2 => lang("Modal"),
        3 => lang("Laba/Rugi"),
      );
    }
    return $hasil;
  }
  
  function frm_journal_period_status($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Open")."</label>",
        2 => "<label class='label label-success'>".lang("Close")."</label>",
        3 => "<label class='label label-danger'>".lang("Cancel")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Open"),
        2 => lang("Close"),
        3 => lang("Cancel"),
      );
    }
    return $hasil;
  }
  
  function frm_journal_status($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Open")."</label>",
        3 => "<label class='label label-danger'>".lang("Cancel")."</label>",
        5 => "<label class='label label-default'>".lang("Draft")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Open"),
        5 => lang("Draft"),
        3 => lang("Cancel"),
      );
    }
    return $hasil;
  }
  
  function frm_account_pos($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Debit")."</label>",
        2 => "<label class='label label-success'>".lang("Credit")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Debit"),
        2 => lang("Credit"),
      );
    }
    return $hasil;
  }
  
  function frm_account_jumlah_digit(){
    $hasil = array(
      1 => 1,
      2 => 1,
      3 => 2,
      4 => 2,
      5 => 4,
    );
    return $hasil;
  }
  
}



?>
