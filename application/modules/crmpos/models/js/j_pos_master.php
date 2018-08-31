<?php
class J_pos_master extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function locations_select(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/locations-get-detail")."', {id_crm_pos_location: id}, function(data){"
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
            . "formutama.id_crm_pos_location = hasil.data.id_crm_pos_location;"
            . "formutama.title = hasil.data.title;"
            . "formutama.code = hasil.data.code;"
            . "formutama.urut = hasil.data.urut;"
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
  
  function locations_dc_select(){
    $html = ""
      . "function select_dc(){"
        . "var id = vm_dc.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/locations-dc-get-detail")."', {id_crm_pos_location_dc: id}, function(data){"
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
            . "formdc.id_crm_pos_location_dc = hasil.data.id_crm_pos_location_dc;"
            . "formdc.title = hasil.data.title;"
            . "formdc.code = hasil.data.code;"
            . "formdc.urut = hasil.data.urut;"
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
  
  function locations_delete($grid){
    $html = ""
      . "$(document).on('click', '.location-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/locations-delete")."', {id_crm_pos_location: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid['variable']}.replace_items(hasil.data, hasil.data.id);"
          . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
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
  
  function locations_active($grid){
    $html = ""
      . "$(document).on('click', '.location-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/locations-active")."', {id_crm_pos_location: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid['variable']}.replace_items(hasil.data, hasil.data.id);"
          . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
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
