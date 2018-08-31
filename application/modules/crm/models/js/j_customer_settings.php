<?php
class J_customer_settings extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function session_customer_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("crm/customer-settings-ajax/session-customer-set")."', {id_crm_customer: id}, function(data){"
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
          . "}"
        . "})"
        . ".done(function(){"
//          . "console.log(vm_utama);"
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
  
}
?>
