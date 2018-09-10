<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crm_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->library('crm/lokal_variable');
    $this->load->model("users/musers");
    $this->musers->session_group_cek();
  }
  
  public function inventory_groups(){
    
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Status", "Options"));
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
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url("crm/crm-master-ajax/inventory-groups-get"), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "form-loading",
    );
    $param = array(
      "title"                     => "",
      "kode"                      => "",
      "id_crm_inventory_groups"   => "",
    );
    $kirim = array(
      "update"      => "{title: this.title, kode: this.kode, id_crm_inventory_groups: this.id_crm_inventory_groups}",
      "insert"      => "{title: this.title, kode: this.kode}",
    );
    $form_watch = ""
      . "id_frm_account: function(val){"
      . "}"
      . "";
    
    $this->load->model("crm/js/j_crmmaster");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/crm-master-ajax/inventory-groups-set"), $grid, $form_watch)
      . $this->j_crmmaster->inventory_groups_select_utama()
      . $this->j_crmmaster->inventory_groups_delete()
      . $this->j_crmmaster->inventory_groups_active()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Inventory Groups")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("CRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-object-group'></i> <a href='".site_url("crm/crm-master/inventory-groups")."'> ".lang("Inventory Groups")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/inventory-groups/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/crm-master/inventory-groups",
        'title'       => lang("Inventory Groups"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'parent'      => $parent,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/inventory-groups/main");
  }
  
  public function satuan(){
    
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Status", "Options"));
    $header_satuan = $this->global_format->standart_head(array("Level", "Title", "Nilai", "Status", "Options"));
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
    
    $grid_satuan = array(
      "limit"         => 10,
      "id"            => "table-satuan",
      "search"        => "",
      "variable"      => "vm_satuan",
      "cari"          => "searchSatuan",
      "onselect"      => "select_satuan();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_satuan, $grid_satuan)
      . $this->global_format->standart_get("ambil_data", site_url("crm/crm-master-ajax/satuan-groups-get"), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_satuan", site_url("crm/crm-master-ajax/satuan-get"), "{start: mulai, id_crm_satuan_groups: formutama.id_crm_satuan_groups}", $grid_satuan)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "form-loading",
    );
    $param = array(
      "title"                     => "",
      "code"                      => "",
      "id_crm_satuan_groups"      => "",
    );
    $kirim = array(
      "update"      => "{title: this.title, code: this.code, id_crm_satuan_groups: this.id_crm_satuan_groups}",
      "insert"      => "{title: this.title, code: this.code}",
    );
    $form_watch = ""
      . "id_crm_satuan_groups: function(val){"
        . "{$grid_satuan['variable']}.clear();"
        . "ambil_satuan(0);"
      . "}"
      . "";
    
    $form_satuan = array(
      "variable"      => "formsatuan",
      "id"            => "form-satuan",
      "loading"       => "form-loading-satuan",
    );
    $param_satuan = array(
      "title"                     => "",
      "level"                     => "",
      "nilai"                     => "",
      "id_crm_satuan"             => "",
    );
    $kirim_satuan = array(
      "update"      => "{title: this.title, level: this.level, nilai: this.nilai, id_crm_satuan: this.id+crm_satuan}",
      "insert"      => "{title: this.title, id_crm_satuan_groups: formutama.id_crm_satuan_groups, level: this.level, nilai: this.nilai}",
    );
    $form_watch_satuan = ""
      . "";
    
    $this->load->model("crm/js/j_crmmaster");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/crm-master-ajax/satuan-groups-set"), $grid, $form_watch)
      . $this->global_format->standart_form($form_satuan, $param_satuan, $kirim_satuan, site_url("crm/crm-master-ajax/satuan-set"), $grid_satuan, $form_watch_satuan)
      . $this->j_crmmaster->satuan_groups_select_utama()
      . $this->j_crmmaster->satuan_groups_delete()
      . $this->j_crmmaster->satuan_groups_active()
      
      . $this->j_crmmaster->satuan_select_utama()
      . $this->j_crmmaster->satuan_delete()
      . $this->j_crmmaster->satuan_active()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Satuan")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("CRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-tag'></i> <a href='".site_url("crm/crm-master/inventory-groups")."'> ".lang("Satuan")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/satuan/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/crm-master/satuan",
        'title'       => lang("Satuan Groups"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'grid_satuan' => $grid_satuan,
        'parent'      => $parent,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/satuan/main");
  }
  
  public function inventory(){
    
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
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Groups", "Satuan", "Status", "Options"));
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
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url("crm/crm-master-ajax/inventory-get"), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "form-loading",
    );
    $groups_select = $this->global_models->get_query("SELECT A.id_crm_inventory_groups, A.title"
      . " FROM crm_inventory_groups AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " AND A.status = 1"
      . " ORDER BY A.kode ASC");
    foreach ($groups_select AS $gs){
      $groups_options[] = array(
        "id"    => $gs->id_crm_inventory_groups,
        "text"  => $gs->title,
      );
    }
    $satuan_select = $this->global_models->get_query("SELECT A.id_crm_satuan_groups, A.title"
      . " FROM crm_satuan_groups AS A"
      . " WHERE A.code_users = '{$this->session->userdata("code_users")}'"
      . " AND A.status = 1"
      . " ORDER BY A.code ASC");
    foreach ($satuan_select AS $gs){
      $satuan_options[] = array(
        "id"    => $gs->id_crm_satuan_groups,
        "text"  => $gs->title,
      );
    }
    $param = array(
      "title"                     => "",
      "code"                      => "",
      "note"                      => "",
      "id_crm_inventory"          => "",
      "id_crm_inventory_groups"   => "",
      "options_groups"            => $groups_options,
      "id_crm_satuan_groups"      => "",
      "options_satuan"            => $satuan_options,
    );
    $kirim = array(
      "update"      => "{title: this.title, code: this.code, note: this.note, id_crm_inventory_groups: this.id_crm_inventory_groups, id_crm_satuan_groups: this.id_crm_satuan_groups, id_crm_inventory: this.id_crm_inventory}",
      "insert"      => "{title: this.title, code: this.code, note: this.note, id_crm_inventory_groups: this.id_crm_inventory_groups, id_crm_satuan_groups: this.id_crm_satuan_groups}",
    );
    $form_watch = ""
      . "";
    
    $this->load->model("crm/js/j_crmmaster");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/crm-master-ajax/inventory-set"), $grid, $form_watch)
      . $this->j_crmmaster->inventory_select_utama()
      . $this->j_crmmaster->inventory_delete()
      . $this->j_crmmaster->inventory_active()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Inventory")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("CRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-cubes'></i> <a href='".site_url("crm/crm-master/inventory")."'> ".lang("Inventory")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/inventory/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/crm-master/inventory",
        'title'       => lang("Inventory"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/inventory/main");
  }
  
  public function storage(){
    
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
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Status", "Options"));
    $header_inventory = $this->global_format->standart_head(array("Title", "Groups", "HPP", "Satuan", "Options"));
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
    
    $grid_master_inventory = array(
      "limit"         => 10,
      "id"            => "table-master-inventory",
      "search"        => "",
      "variable"      => "vm_master_inventory",
      "cari"          => "searchMasterInventory",
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
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_inventory, $grid_master_inventory)
      . $this->global_format->js_grid_table(array(), $header_inventory, $grid_inventory)
      . $this->global_format->standart_get("ambil_data", site_url("crm/crm-master-ajax/storage-get"), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_master_inventory", site_url("crm/crm-master-ajax/master-inventory-get"), "{start: mulai}", $grid_master_inventory)
      . $this->global_format->standart_get("ambil_inventory", site_url("crm/crm-master-ajax/storage-inventory-get"), "{start: mulai, id_crm_storage: formutama.id_crm_storage}", $grid_inventory)
      . "ambil_data(0);"
      . "ambil_master_inventory(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "form-loading",
    );
    $param = array(
      "title"                     => "",
      "code"                      => "",
      "note"                      => "",
      "id_crm_storage"            => "",
    );
    $kirim = array(
      "update"      => "{title: this.title, code: this.code, note: this.note, id_crm_storage: this.id_crm_storage}",
      "insert"      => "{title: this.title, code: this.code, note: this.note}",
    );
    $form_watch = ""
      . "id_crm_storage: function(val){"
        . "{$grid_inventory['variable']}.clear();"
        . "ambil_inventory(0);"
      . "}"
      . "";
    
    $this->load->model("crm/js/j_crmmaster");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/crm-master-ajax/storage-set"), $grid, $form_watch)
      . $this->j_crmmaster->storage_select_utama()
      . $this->j_crmmaster->storage_delete()
      . $this->j_crmmaster->storage_active()
      . $this->j_crmmaster->storage_inventory_set($grid_inventory)
      . $this->j_crmmaster->storage_inventory_unset($grid_inventory)
      . $this->j_crmmaster->storage_inventory_hpp()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Storage")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-thumbs-o-up'></i> <a href='javascript:void(0)'> ".lang("CRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("CRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-database'></i> <a href='".site_url("crm/crm-master/storage")."'> ".lang("Storage")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/storage/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/crm-master/storage",
        'title'       => lang("Storage"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'grid_master_inventory' => $grid_master_inventory,
        'grid_inventory'        => $grid_inventory,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/storage/main");
  }
  
}