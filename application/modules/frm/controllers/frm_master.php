<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->library('frm/lokal_variable');
    $this->load->model("users/musers");
    $this->musers->session_group_cek();
  }
  
  public function coa($id_frm_account_parent = NULL){
    
    if($id_frm_account_parent){
      $id_frm_account_parent = urldecode($id_frm_account_parent);
      $parent = $this->global_models->get("frm_account", array("id_frm_account" => $id_frm_account_parent));
//      $this->debug($parent, true);
    }
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
    
    $header = $this->global_format->standart_head(array("Code", "Ref", "Title", "Position"));
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
      . $this->global_format->standart_get("ambil_data", site_url("frm/frm-master-ajax/account-get"), "{start: mulai, id_parent: '{$id_frm_account_parent}'}", $grid)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"      => "formutama",
      "id"            => "form-utama",
      "loading"       => "page-loading-post",
    );
    $param = array(
      "title"                     => "",
      "position"                  => "",
      "id_frm_account"            => "",
      "code"                      => "",
      "pos"                       => "",
      "id_parent"                 => $parent[0]->id_frm_account,
      "is_group"                  => ($parent[0]->is_group + 1),
    );
    $kirim = array(
      "update"      => "{title: this.title, id_frm_account: this.id_frm_account, position: this.position, is_group: this.is_group, pos: this.pos, id_parent: this.id_parent, code: this.code}",
      "insert"      => "{title: this.title, id_frm_account: this.id_frm_account, position: this.position, is_group: this.is_group, pos: this.pos, id_parent: this.id_parent, code: this.code}",
    );
    $form_watch = ""
      . "id_frm_account: function(val){"
      . "}"
      . "";
    
    $this->load->model("frm/js/j_frmmaster");
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("frm/frm-master-ajax/account-set"), $grid, $form_watch)
      . $this->j_frmmaster->account_select_utama()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("COA")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("FRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-map-signs'></i> <a href='".site_url("frm/frm-master/coa")."'> ".lang("COA")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/coa/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-master/coa",
        'title'       => lang("COA"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
        'parent'      => $parent,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/coa/main");
  }
  
  function period(){
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
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Period"));
    
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
      . $this->global_format->standart_get("ambil_data", site_url('frm/frm-master-ajax/period-get'), "{start: mulai}", $grid)
      
      . "ambil_data(0);"
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "window.location = '".site_url("frm/frm-siklus/transaksi")."/'+id;"
      . "}"
      . "$(document).on('click', '#add-new-period', function(evt){"
        . "$('#form-add-new-period').modal('show');"
      . "});"
      . "$(document).on('click', '#add-new-period-submit', function(evt){"
        . "$('#form-add-new-period').modal('hide');"
        . "$('#list-loading-period').show();"
        . "$.post('".site_url("frm/frm-master-ajax/period-set")."', {code: $('#period-code').val(),"
          . " title: $('#period-title').val(),"
          . " bulan: $('#period-bulan').val(),"
          . " tahun: $('#period-tahun').val()}, function(data){"
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
            
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#list-loading-period').hide();"
        . "});"
      . "});"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Journal Period")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-book'></i> <a href='javascript:void(0)'> ".lang("FRM Master")."</a></li>"
        . "<li class='active'><i class='fa fa-object-group'></i> <a href='".site_url("frm/frm-master/period")."'> ".lang("Journal Period")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/period/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-master/period",
        'title'       => lang("Period"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/period/main");
  }
}