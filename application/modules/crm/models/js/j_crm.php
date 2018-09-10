<?php
class J_crm extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function stock_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$('#id_crm_storage').val(id);"
        . "vm_inventory.clear();"
        . "ambil_inventory(0);"
      . "}"
      . "";
    return $html;
  }
    
  function stock_select_inventory(){
    $hpp = <<<EOD
<div class="grid-tr"><div>'+vm_inventory.items[idx].data[1].value+'</div><div><input type="number" value="1" class="qty form-control input-sm" style="width: 50px" /></div><div><input type="number" value="'+hpp+'" class="hpp form-control input-sm" style="width: 70%; display: initial" /> /porsi <input type="text" value="'+id_crm_inventory+'" class="id-crm-inventory" style="display: none" /> <input type="text" value="'+id_crm_satuan+'" class="id-crm-satuan" style="display: none" /> </div><div><button class="btn btn-danger btn-sm hpp-delete" isi="1"><i class="fa fa-times"></i></button> </div></div>
EOD;
    $html = ""
      . "function select_inventory(){"
        . "var id = vm_utama.page.select_value;"
        . "var id_crm_inventory = vm_inventory.page.select_value;"
        . "var idx = vm_inventory.cari_id(id_crm_inventory);"
        . "var hpp = vm_inventory.items[idx].data[3].value * 1;"
        . "var id_crm_satuan = vm_inventory.items[idx].data[2].value;"
        . "$('#setelah-hpp').after('{$hpp}');"
      . "}"
      . "";
    return $html;
  }
    
  function stock_rg_create(){
    $hpp = <<<EOD
<div id="setelah-hpp"></div>
EOD;
    $html = ""
      . "$(document).on('click', '#rg-create', function(evn){"
        . "$('#rg-form-loading').show();"
        . "var qty = [];"
        . "var hpp = [];"
        . "var id_crm_inventory = [];"
        . "var id_crm_satuan = [];"
        . "$('.qty').each(function(idx){"
          . "qty[idx] = $(this).val();"
        . "});"
        . "$('.hpp').each(function(idx){"
          . "hpp[idx] = $(this).val();"
        . "});"
        . "$('.id-crm-inventory').each(function(idx){"
          . "id_crm_inventory[idx] = $(this).val();"
        . "});"
        . "$('.id-crm-satuan').each(function(idx){"
          . "id_crm_satuan[idx] = $(this).val();"
        . "});"
        . "$.post('".site_url("crm/crm-ajax/stock-rg-set")."', {id_crm_storage: $('#id_crm_storage').val(), qty: qty, hpp: hpp, id_crm_inventory: id_crm_inventory, id_crm_satuan: id_crm_satuan}, function(data){"
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
            . "$('#tempat-hpp').html('{$hpp}');"
          . "}"
        . "})"
        . ".done(function(){"
          . "$('#rg-form-loading').hide();"
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
