<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bridge_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function index(){
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Redirect", "Option"));
    $header_detail = $this->global_format->standart_head(array("Name", "Email", "Privilege"));
    $header_users = $this->global_format->standart_head(array("Name", "ID", "Link", "Options"));
    
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
    
    $grid_detail = array(
      "limit"         => 10,
      "id"            => "table-detail",
      "search"        => "",
      "variable"      => "vm_detail",
      "cari"          => "searchDetail",
      "onselect"      => "select_users();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_lokal = array(
      "limit"         => 10,
      "id"            => "table-lokal",
      "search"        => "",
      "variable"      => "vm_lokal",
      "cari"          => "searchLokal",
      "onselect"      => "select_lokal();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_users = array(
      "limit"         => 10,
      "id"            => "table-users",
      "search"        => "",
      "variable"      => "vm_users",
      "cari"          => "searchUsers",
//      "onselect"      => "select_users();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_detail, $grid_detail)
      . $this->global_format->js_grid_table(array(), $header_detail, $grid_lokal)
      . $this->global_format->js_grid_table(array(), $header_users, $grid_users)
      . $this->global_format->standart_get("ambil_data", site_url('login/bridge-master-ajax/bridge-get'), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_detail", site_url('login/bridge-master-ajax/users-get'), "{start: mulai, id_bridge: formutama.id_bridge}", $grid_detail)
      . $this->global_format->standart_get("ambil_lokal", site_url('login/bridge-master-ajax/index-lokal-get'), "{start: mulai, id_bridge: formutama.id_bridge}", $grid_lokal)
      . $this->global_format->standart_get("ambil_users", site_url('login/bridge-master-ajax/bridge-users-get'), "{start: mulai, id_bridge: formutama.id_bridge}", $grid_users)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"    => "formutama",
      "id"          => "form-utama",
      "loading"     => "page-loading-post"
    );
    $param = array(
      "redirect"  => "",
      "id_bridge" => "",
    );
    $kirim = array(
      "update"    => "{redirect: this.redirect, id_bridge: this.id_bridge}",
      "insert"    => "{redirect: this.redirect}",
    );
    
    $form_detail = array(
      "variable"    => "formdetail",
      "id"          => "form-detail",
      "loading"     => "page-loading-detail"
    );
    $param_detail = array(
      "id_users_partner"  => "",
      "id_bridge_users"   => "",
      "id_users"          => "",
    );
    $kirim_detail = array(
      "update"    => "{}",
      "insert"    => "{id_users_partner: this.id_users_partner, id_bridge: formutama.id_bridge, id_users: this.id_users}",
    );
    
    $form_watch = ""
      . "id_bridge: function(val){"
        . "vm_users.clear();"
        . "ambil_users(0);"
        . "vm_detail.clear();"
        . "ambil_detail(0);"
        . "vm_lokal.clear();"
        . "ambil_lokal(0);"
      . "}"
      . "";
    
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("login/bridge-master-ajax/bridge-set"), $grid, $form_watch)
      . $this->global_format->standart_form($form_detail, $param_detail, $kirim_detail, site_url("login/bridge-master-ajax/users-set"), $grid_users, "")
      . "";
    
    $this->load->model("login/js/j_bridge");
    
    $foot .= ""
      . $this->j_bridge->bridge_select_utama()
      . $this->j_bridge->bridge_select_users()
      . $this->j_bridge->bridge_select_lokal()
      . $this->j_bridge->bridge_users_delete()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Bridge")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'> ".lang("Bridge")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/bridge/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "login/bridge-master",
        'title'       => lang("Bridge"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
        'grid_detail'       => $grid_detail,
        'grid_lokal'        => $grid_lokal,
        'grid_users'        => $grid_users,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/bridge/main");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */