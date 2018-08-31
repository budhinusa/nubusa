<?php
class J_discount extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function discount_payment_channel_delete(){
    $html = ""
      . "$(document).on('click', '.payment-channel-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/discount-payment-channel-delete")."', {id_crm_pos_discount_payment_channel: id}, function(data){"
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
            . "vm_payment_channel.delete_items(id);"
            . "vm_payment_channel.cari($('#searchPaymentChannel').val());"
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
    
  function discount_voucher_delete(){
    $html = ""
      . "$(document).on('click', '.voucher-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/discount-voucher-delete")."', {id_crm_pos_discount_voucher: id}, function(data){"
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
            . "vm_voucher.delete_items(id);"
            . "vm_voucher.cari($('#searchVoucher').val());"
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
