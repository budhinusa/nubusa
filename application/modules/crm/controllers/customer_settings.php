<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function session_customer(){
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Name", "Company", "Users"));
    
//    $this->debug($this->session->userdata("id_hrm_employee"), true);
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
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('crm/customer-settings-ajax/session-customer-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . $this->global_format->standart_component()
      . "";
    
    $this->load->model("crm/js/j_customer_settings");
    
    $foot .= ""
      . $this->j_customer_settings->session_customer_select_utama()
      
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Session Customer")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'> ".lang("Session Customer")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/customer/session-customer/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-settings/session-customer",
        'title'       => lang("Session Customer"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'                  => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/customer/session-customer/main");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */