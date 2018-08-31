<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function products(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Title", "Category", "Status", "Option"));
    
    $header_merchandise = $this->global_format->standart_head(array("Title", "Price", "Editable", "Qty", "Status", "Option"));
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_merchandise = array(
      "limit"         => 10,
      "id"            => "table-merchandise",
      "search"        => "",
      "variable"      => "vm_merchandise",
      "cari"          => "searchString",
      "onselect"      => "select_merchandise();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_merchandise, $grid_merchandise)
      
      . $this->global_format->standart_get("ambil_data", site_url('crmpos/pos-master-ajax/inventory-get'), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_merchandise", site_url('crmpos/pos-master-ajax/inventory-merchandise-get'), "{start: mulai, id_crm_pos_products: formutama.id_crm_pos_products}", $grid_merchandise)
      
      . "ambil_data(0);"
      . "";
    
    $data_specification = $this->global_models->get_query("SELECT A.id_crm_pos_products_specification, A.title"
      . " FROM crm_pos_products_specification AS A"
      . " ORDER BY A.title ASC");
    foreach ($data_specification AS $cs){
      $specification[] = array(
        "id"    => $cs->id_crm_pos_products_specification,
        "text"  => $cs->title,
      );
    }
    
    $categories_temp = $this->global_models->get_query("SELECT A.id_crm_pos_products_categories, A.title"
      . " FROM crm_pos_products_categories AS A"
      . " ORDER BY A.title ASC");
    foreach ($categories_temp AS $ct){
      $categories[] = array(
        "id"    => $ct->id_crm_pos_products_categories,
        "text"  => $ct->title,
      );
    }
//    $this->debug($categories, true);
    $foot .= ""
      . $this->global_format->standart_component()
      
      . "var formspec = new Vue({"
        . "el: '#specification',"
        . "data: {"
          . "id_crm_pos_products_specification : '',"
          . "options_status: ".json_encode($specification)
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "id_crm_pos_products_specification : this.id_crm_pos_products_specification,"
              . "id_site_transport_products : formutama.id_site_transport_products"
            . "};"
            . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-specification-set")."', kirim, function(data){"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-specification-detail")."', {id_crm_pos_products_specification: kirim.id_crm_pos_products_specification}, function (data){"
                . "$('#form-specification').html(data);"
              . "});"
            . "});"
          . "}"
        . "}"
      . "});"
      
      . $this->global_format->standart_form(array("variable" => "formutama", "id" => "form-utama", "loading" => "page-loading-post"), array(
        "title" => "",
        "description" => "",
        "id_crm_pos_products_categories" => "",
        "options_status" => $categories,
        "id_crm_pos_products" => "",
      ), array(
        "update"  => "{title: this.title, description: this.description, id_crm_pos_products_categories: this.id_crm_pos_products_categories, id_crm_pos_products: this.id_crm_pos_products}",
        "insert"  => "{title: this.title, description: this.description, id_crm_pos_products_categories: this.id_crm_pos_products_categories}",
      ), site_url("crmpos/pos-master-ajax/inventory-set"), $grid, ""
        . "id_crm_pos_products: function(val){"
          . "$('#inventory-detail').show();"
          . "{$grid_merchandise['variable']}.clear();"
          . "ambil_merchandise(0);"
        . "}"
        . "")
      
      . $this->global_format->standart_form(
        array("variable" => "formmerchandise", "id" => "form-merchandise", "loading" => "page-loading-merchandise"), 
        array(
          "id_crm_pos_products"             => "",
          "id_crm_pos_products_merchandise" => "",
          "title"                           => "",
          "harga"                           => "",
          "editable"                        => false,
          "qty"                             => "",
          "type"                            => false,
          "tambahan"                        => "",
          "note"                            => "",
        ),
        array(
          "update"  => "{"
            . "id_crm_pos_products: formutama.id_crm_pos_products,"
            . "id_crm_pos_products_merchandise: this.id_crm_pos_products_merchandise,"
            . "title: this.title,"
            . "qty: this.qty,"
            . "type: this.type,"
            . "editable: this.editable,"
            . "tambahan: this.tambahan,"
            . "note: this.note,"
            . "harga: this.harga"
          . "}",
          "insert"  => "{"
            . "id_crm_pos_products: formutama.id_crm_pos_products,"
            . "title: this.title,"
            . "qty: this.qty,"
            . "type: this.type,"
            . "editable: this.editable,"
            . "tambahan: this.tambahan,"
            . "note: this.note,"
            . "harga: this.harga"
          . "}",
        ), 
        site_url("crmpos/pos-master-ajax/inventory-merchandise-set"), 
        $grid_merchandise)
      
      . $this->_products_select($grid)
      . $this->_products_merchandise_select($grid_merchandise)
      . ""
//      . "formutama.id_site_transport_products_categories = 'TZOX2AV6QY86RAPY';"
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-delete")."', {id: id}, function(data){"
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
      . ""
      . "$(document).on('click', '.form-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-active")."', {id: id}, function(data){"
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
            
      . "$(document).on('click', '.merchandise-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-merchandise-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_merchandise['variable']}.replace_items(hasil.data, hasil.data.id);"
          . "{$grid_merchandise['variable']}.items_live[{$grid_merchandise['variable']}.page.select[0]] = hasil.data;"
          . "{$grid_merchandise['variable']}.cari($('#{$grid_merchandise['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
      . "$(document).on('click', '.merchandise-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-merchandise-active")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_merchandise['variable']}.replace_items(hasil.data, hasil.data.id);"
          . "{$grid_merchandise['variable']}.items_live[{$grid_merchandise['variable']}.page.select[0]] = hasil.data;"
          . "{$grid_merchandise['variable']}.cari($('#{$grid_merchandise['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
            
      . "$(document).on('click', '#simpan-specification', function(evt){"
        . "var data = [];"
        . "var id = [];"
        . "$('.isi-data').each(function(index){"
          . "data[index] = $(this).val();"
        . "});"
        . "$('.id-data').each(function(index){"
          . "id[index] = $(this).val();"
        . "});"
            
        . "$('#page-loading-post-specification').show();"
        
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-specification-set-detail")."', {id: JSON.stringify(id), data: JSON.stringify(data)}, function(data){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#page-loading-post-specification').hide();"
        . "});"
      . "});"
      . ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Inventory")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-car'></i> ".lang("Inventory")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/products', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmtrans/transport-master/inventory",
        'title'       => lang("Inventory"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
        'grid_merchandise'  => $grid_merchandise,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/products");
  }
  
  public function specification(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Title"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $header2 = array(
      array(
        "title"       => lang("Sort"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Code"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Type"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid2 = array(
      "limit"         => 10,
      "id"            => "table-inventory",
      "search"        => "",
      "variable"      => "vm_inventory",
      "cari"          => "searchInventory",
      "onselect"      => "select_details();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header2, $grid2)
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crmpos/pos-master-ajax/products-specification-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
          . '}'
          . 'else{'
//              . '$("#page-loading").hide();'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "function ambil_data_details(mulai){"
        . "$.post('".site_url('crmpos/pos-master-ajax/products-specification-details-get')."', {start: mulai, id_crm_pos_products_specification: formutama.id_crm_pos_products_specification}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid2, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data_details(hasil.start);'
          . '}'
          . 'else{'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "id_crm_pos_products_specification: ''"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "id_crm_pos_products_specification: this.id_crm_pos_products_specification"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_pos_products_specification);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_pos_products_specification = hasil.data.id;"
                . "console.log(hasil.data.id);"
                . "console.log(this.id_crm_pos_products_specification);"
                . "console.log(formutama.id_crm_pos_products_specification);"
              . $this->global_format->js_grid_add($grid, "hasil.data")
            . "})"
            . ".done(function(){"
              . "$('#details').show();"
              . "{$grid2['variable']}.clear();"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "}"
      . "});"
      . ""
      . "var formdetails = new Vue({"
        . "el: '#form-details',"
        . "data: {"
          . "title : '',"
          . "code : '',"
          . "sort : '',"
          . "type : '',"
          . "id_crm_pos_products_specification_details: ''"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "sort: this.sort,"
              . "code: this.code,"
              . "type: this.type,"
              . "id_crm_pos_products_specification_details: this.id_crm_pos_products_specification_details"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-details-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid2['variable']}.replace_items(hasil.data, kirim.id_crm_pos_products_specification_details);"
              . "{$grid2['variable']}.items_live[{$grid2['variable']}.page.select[0]] = hasil.data;"
              . "{$grid2['variable']}.cari($('#{$grid2['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "sort: this.sort,"
              . "code: this.code,"
              . "type: this.type,"
              . "id_crm_pos_products_specification: formutama.id_crm_pos_products_specification"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-details-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "this.id_crm_pos_products_specification_details = hasil.id;"
              . $this->global_format->js_grid_add($grid2, "hasil.data")
            . "})"
            . ".done(function(){"
              . "$('#details').show();"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "}"
      . "});"
      . ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.id_crm_pos_products_specification = hasil.id_crm_pos_products_specification;"
        . "})"
        . ".done(function(){"
          . "$('#details').show();"
          . "{$grid2['variable']}.clear();"
          . "ambil_data_details(0);"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
      . "function select_details(){"
        . "var id_crm_pos_products_specification_details = {$grid2['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-details-get-detail")."', {id_crm_pos_products_specification_details: id_crm_pos_products_specification_details}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formdetails.title = hasil.title;"
          . "formdetails.code = hasil.code;"
          . "formdetails.type = hasil.type;"
          . "formdetails.sort = hasil.sort;"
          . "formdetails.id_crm_pos_products_specification_details = hasil.id_crm_pos_products_specification_details;"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-delete")."', {id: id}, function(data){"
          . "{$grid['variable']}.delete_items(id);"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
      . "$(document).on('click', '.delete-details', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-specification-details-delete")."', {id: id}, function(data){"
          . "{$grid2['variable']}.delete_items(id);"
          . "{$grid2['variable']}.cari($('#{$grid2['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Specification")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("Specification")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/specification', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmpos/pos-master/specification",
        'title'       => lang("Specification"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/specification");
  }
  
  public function categories(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Code"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crmpos/pos-master-ajax/products-categories-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
//            . 'ambil_data(hasil.start);'
          . '}'
          . 'else{'
//              . '$("#page-loading").hide();'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "kode : '',"
          . "id_crm_pos_products_categories: ''"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "id_crm_pos_products_categories: this.id_crm_pos_products_categories"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_pos_products_categories);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_pos_products_categories = hasil.data.id;"
              . $this->global_format->js_grid_add($grid, "hasil.data")
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "}"
      . "});"
      . ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.kode = hasil.kode;"
          . "formutama.id_crm_pos_products_categories = hasil.id_crm_pos_products_categories;"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-delete")."', {id: id}, function(data){"
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
      . ""
      . "$(document).on('click', '.active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-active")."', {id: id}, function(data){"
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
      . ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Categories")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-tasks'></i> ".lang("Categories")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/categories', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmpos/pos-master/categories",
        'title'       => lang("Categories"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/categories");
  }
  
  public function brands(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Code"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crmpos/pos-master-ajax/products-categories-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
//            . 'ambil_data(hasil.start);'
          . '}'
          . 'else{'
//              . '$("#page-loading").hide();'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "kode : '',"
          . "id_crm_pos_products_categories: ''"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "id_crm_pos_products_categories: this.id_crm_pos_products_categories"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_pos_products_categories);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode"
            . "};"
            . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_pos_products_categories = hasil.data.id;"
              . $this->global_format->js_grid_add($grid, "hasil.data")
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "}"
      . "});"
      . ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.kode = hasil.kode;"
          . "formutama.id_crm_pos_products_categories = hasil.id_crm_pos_products_categories;"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-delete")."', {id: id}, function(data){"
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
      . ""
      . "$(document).on('click', '.active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmpos/pos-master-ajax/products-categories-active")."', {id: id}, function(data){"
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
      . ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Categories")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-tasks'></i> ".lang("Categories")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/categories', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmpos/pos-master/categories",
        'title'       => lang("Categories"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/categories");
  }
  
  private function _products_merchandise_select($grid_merchandise){
    $html = ""
      . "function select_merchandise(){"
        . "var id = {$grid_merchandise['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/inventory-merchandise-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formmerchandise.title = hasil.title;"
          . "formmerchandise.harga = hasil.harga;"
          . "formmerchandise.qty = hasil.qty;"
          . "formmerchandise.tambahan = hasil.tambahan;"
          . "formmerchandise.editable = hasil.editable;"
          . "formmerchandise.type = hasil.type;"
          . "formmerchandise.note = hasil.note;"
          . "formmerchandise.id_crm_pos_products_merchandise = hasil.id_crm_pos_products_merchandise;"
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
  
  private function _products_select($grid){
    $html = ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crmpos/pos-master-ajax/inventory-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.id_crm_pos_products = hasil.id_crm_pos_products;"
          . "formutama.description = hasil.description;"
          . "formutama.id_crm_pos_products_categories = hasil.id_crm_pos_products_categories;"
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
  
  public function locations_dc(){
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      // . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css'>"
      . "<style>"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".not-editable{"
          . "display: none;"
        . "}"
        . ".editable{"
          . "display: show;"
        . "}"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/moment.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
			// . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
		
    $header = $this->global_format->standart_head(array("Sort", "Title", "Code", "Status", "Options"));
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
		
    $grid_dc = array(
      "limit"         => 10,
      "id"            => "table-dc",
      "search"        => "",
      "variable"      => "vm_dc",
      "cari"          => "searchDC",
      "onselect"      => "select_dc();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
		
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header, $grid_dc)
      . $this->global_format->standart_get("ambil_data", site_url('crmpos/pos-master-ajax/locations-get'), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_dc", site_url('crmpos/pos-master-ajax/locations-dc-get'), "{start: mulai, id_crm_pos_location: formutama.id_crm_pos_location}", $grid_dc)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"    => "formutama",
      "id"          => "form-utama",
      "loading"     => "regions-loading"
    );
    
    $param = array(
      "title"                           => "",
      "code"                            => "",
      "urut"                            => "",
      "id_crm_pos_location"             => "",
    );
		
    $kirim = array(
      "update"    => "{"
        . "title: formutama.title,"
        . "code: formutama.code,"
        . "urut: formutama.urut,"
        . "id_crm_pos_location: formutama.id_crm_pos_location,"
      . "}",
      "insert"    => "{"
        . "title: formutama.title,"
        . "code: formutama.code,"
        . "urut: formutama.urut,"
      . "}",
    );
    
    $form_dc = array(
      "variable"    => "formdc",
      "id"          => "form-dc",
      "loading"     => "dc-loading"
    );
    
    $param_dc = array(
      "title"                           => "",
      "code"                            => "",
      "urut"                            => "",
      "id_crm_pos_location_dc"          => "",
    );
		
    $kirim_dc = array(
      "update"    => "{"
        . "title: this.title,"
        . "code: this.code,"
        . "urut: this.urut,"
        . "id_crm_pos_location_dc: this.id_crm_pos_location_dc,"
      . "}",
      "insert"    => "{"
        . "title: this.title,"
        . "code: this.code,"
        . "urut: this.urut,"
        . "id_crm_pos_location: formutama.id_crm_pos_location,"
      . "}",
    );
    
    $watch = ""
      . "id_crm_pos_location: function(val){"
        . "ambil_dc(0);"
      . "}"
      . "";
     
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crmpos/pos-master-ajax/locations-set"), $grid, $watch)
      . $this->global_format->standart_form($form_dc, $param_dc, $kirim_dc, site_url("crmpos/pos-master-ajax/locations-dc-set"), $grid_dc, "")
      . "";
    
    $this->load->model("crmpos/js/j_pos_master");
    
    $foot .= ""
      . $this->j_pos_master->locations_select()
      . $this->j_pos_master->locations_dc_select()
      . $this->j_pos_master->locations_delete($grid)
      . $this->j_pos_master->locations_active($grid)
      
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Locations")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'> ".lang("Locations")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/locations-dc/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmpos/pos-master/locations-dc",
        'title'       => lang("Locations DC"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'grid_dc'     => $grid_dc,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/locations-dc/main");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */