<?php
class J_crmpos_settings extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function inventory_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("crm/crm-master-ajax/inventory-get-detail")."', {id_crm_inventory: id}, function(data){"
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
            . "formutama.id_crm_inventory = hasil.data.id_crm_inventory;"
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
    
}
?>
