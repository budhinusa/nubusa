<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crmpos_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model("users/musers");
    $this->musers->session_group_cek();
  }
  
  public function inventory_price(){
    
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Groups", "Satuan"));
    $header_price = $this->global_format->standart_head(array("Start Date", "End Date", "Nominal", "Status"));
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
    
    $grid_price = array(
      "limit"         => 10,
      "id"            => "table-price",
      "search"        => "",
      "variable"      => "vm_price",
      "cari"          => "searchPrice",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_price, $grid_price)
      . $this->global_format->standart_get("ambil_data", site_url("crmpos/crmpos-settings-ajax/inventory-get"), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_price", site_url("crmpos/crmpos-settings-ajax/inventory-price-get"), "{start: mulai, id_crm_inventory: formutama.id_crm_inventory}", $grid_price)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "form-loading",
      "else"          => ""
      . "{$grid_price['variable']}.clear();"
      . "ambil_price(0);"
      . "",
    );
    $param = array(
      "nominal"           => "",
      "id_crm_inventory"  => "",
    );
    $kirim = array(
      "update"      => "{}",
      "insert"      => "{nominal: this.nominal, id_crm_inventory: this.id_crm_inventory}",
    );
    $form_watch = ""
      . "id_crm_inventory: function(val){"
        . "{$grid_price['variable']}.clear();"
        . "ambil_price(0);"
      . "}"
      . "";
    
    $this->load->model("crmpos/js/j_crmpos_settings");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crmpos/crmpos-settings-ajax/inventory-price-set"), $grid_price, $form_watch)
      . $this->j_crmpos_settings->inventory_select_utama()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Price")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-cubes'></i> <a href='javascript:void(0)'> ".lang("CRM Inventory")."</a></li>"
        . "<li class='active'><i class='fa fa-money'></i> <a href='".site_url("crmpos/crmpos-settings/inventory-price")."'> ".lang("Price")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/inventory-price/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crmpos/crmpos-settings/inventory-price",
        'title'       => lang("Inventory"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'grid_price'  => $grid_price,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/inventory-price/main");
  }
   
}