<?php
class J_bridge extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function bridge_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("login/bridge-master-ajax/bridge-get-detail")."', {id_bridge: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
//      . "console.log(formutama);"
            . "formutama.redirect = hasil.data.redirect;"
            . "formutama.id_bridge = hasil.data.id_bridge;"
//      . "console.log(formutama);"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function bridge_users_delete(){
    $html = ""
      . "$(document).on('click', '.users-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("login/bridge-master-ajax/users-delete")."', {id_bridge_users: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "vm_users.clear();"
            . "ambil_users(0);"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . "";
    return $html;
  }
  
  function bridge_select_users(){
    $html = ""
      . "function select_users(){"
        . "var id = vm_detail.page.select_value;"
        . "formdetail.id_users = id;"
      . "}";
    return $html;
  }
  
  function bridge_select_lokal(){
    $html = ""
      . "function select_lokal(){"
        . "var id = vm_lokal.page.select_value;"
        . "formdetail.id_users_partner = id;"
      . "}";
    return $html;
  }
  
}
?>
