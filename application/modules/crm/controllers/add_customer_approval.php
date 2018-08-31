<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_customer_approval extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
	
  public function approval(){
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Parent","Name","Alamat","Status","Option"));
    
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
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('crm/add-customer-approval-ajax/approval-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
	
	
	///------------
	 $foot .= ""
      
     
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
		." console.log('ini');"
        . "$.post('".site_url("crm/add-customer-approval-ajax/approval-delete")."', {id: id}, function(data){"
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
        . "$.post('".site_url("crm/add-customer-approval-ajax/approval-active")."', {id: id}, function(data){"
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
	///------------
	    
        
    $foot .= "</script>";
	
    $head = ""
      . "<h1>".lang("Approval to Add Customer")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-calendar-check-o'></i> ".lang("Approval to Add Customer")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-approval/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/add-customer-approval/approval",		                      
        'title'       => lang("Approval"),
        'foot'        => $foot,
        'css'         => $css,        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-approval/main");
  }
  

  
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */