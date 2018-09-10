<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crm extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->library('crm/lokal_variable');
    $this->load->model("users/musers");
    $this->musers->session_group_cek();
  }
  
  public function stock(){
    
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
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title"));
    $header_rg = $this->global_format->standart_head(array("Number", "Date", "Users", "Status", "Options"));
    $header_inventory = $this->global_format->standart_head(array("Code", "Title", "Groups", "Satuan"));
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
    
    $grid_rg = array(
      "limit"         => 10,
      "id"            => "table-rg",
      "search"        => "",
      "variable"      => "vm_rg",
      "cari"          => "searchRG",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_inventory = array(
      "limit"         => 10,
      "id"            => "table-inventory",
      "search"        => "",
      "variable"      => "vm_inventory",
      "cari"          => "searchInventory",
      "onselect"      => "select_inventory();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_rg, $grid_rg)
      . $this->global_format->js_grid_table(array(), $header_inventory, $grid_inventory)
      . $this->global_format->standart_get("ambil_data", site_url("crm/crm-ajax/master-storage-get"), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_rg", site_url("crm/crm-ajax/rg-get"), "{start: mulai, id_crm_storage: formutama.id_crm_storage}", $grid_rg)
      . $this->global_format->standart_get("ambil_inventory", site_url("crm/crm-ajax/master-inventory-get"), "{start: mulai, id_crm_storage: vm_utama.page.select_value}", $grid_inventory)
      . "ambil_data(0);"
      . "";
    
    $this->load->model("crm/js/j_crm");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->j_crm->stock_select_utama()
      . $this->j_crm->stock_select_inventory()
      . $this->j_crm->stock_rg_create()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Stock")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("CRM Inventory")."</a></li>"
        . "<li class='active'><i class='fa fa-database'></i> <a href='".site_url("crmpos/stock")."'> ".lang("Stock")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('stock/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/stock",
        'title'       => lang("Stock"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'grid_rg'     => $grid_rg,
        'grid_inventory'  => $grid_inventory,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("stock/main");
  }
  
}