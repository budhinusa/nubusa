<?php
class J_settings extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function notifications_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("settings/settings-ajax/notifications-get-detail")."', {id_settings_notifications: id}, function(data){"
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
            . "formutama.tanggal = hasil.tanggal;"
            . "formutama.link = hasil.link;"
            . "formutama.title = hasil.title;"
            . "formutama.code = hasil.code;"
            . "formutama.id_settings_notifications = hasil.id_settings_notifications;"
            . "formutama.id_users = hasil.id_users;"
            . "formutama.note = hasil.note;"
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
  
  function notifications_not_delete(){
    $html = ""
      . "$(document).on('click', '.not-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("settings/settings-ajax/notifications-delete")."', {id_settings_notifications: id}, function(data){"
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
            . "vm_utama.delete_items(hasil.id);"
            . "vm_utama.cari($('#searchString').val());"
          . "}"
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
  
}
?>
