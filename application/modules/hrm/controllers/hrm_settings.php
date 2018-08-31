<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrm_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function session_biodata(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('hrm/hrm-settings-ajax/biodata-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "if(hasil.banding[ind] == '{$this->session->userdata("hrm_biodata")}'){"
                    . "$( rowNode ).addClass('selected');"
                  . "}"
                . "}"
              . '}'
              . 'ambil_data(table, hasil.start);'
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
        
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("hrm/hrm-settings-ajax/biodata-set")."',{id:id},function(data){"
          . "})"
          . ".fail(function(){"
            . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
          . "})"
          . ".always(function(){"
          . "});"
        . "});"
          
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Biodata")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-home'></i> ".lang("Biodata")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/biodata', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "hrm/hrm-settings/session-biodata",
        'title'       => lang("Biodata"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/biodata");
    
	}
  
  public function multi_struktural(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "var table_struktural = "
        . "$('#tableboxy-struktural').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('hrm/hrm-settings-ajax/biodata-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . "}"
              . '}'
              . 'ambil_data(table, hasil.start);'
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
        
        . "function ambil_data_struktural(table_struktural, mulai){"
          . "$.post('".site_url('hrm/hrm-settings-ajax/multi-struktural-get')."', {start: mulai, id_hrm_biodata: $('#id-hrm-biodata').val()}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table_struktural.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "if(hasil.flag[ind] == '2' || hasil.flag[ind] == 2){"
                    . "$( rowNode ).addClass('selected');"
                  . "}"
                . "}"
              . '}'
              . 'ambil_data_struktural(table_struktural, hasil.start);'
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
        
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$('#id-hrm-biodata').val(id);"
          . "table_struktural.clear().draw();"
          . "ambil_data_struktural(table_struktural, 0);"
        . "});"
          
        . "$('#tableboxy-struktural tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
            . "$(this).removeClass('selected');"
            . "$.post('".site_url("hrm/hrm-settings-ajax/multi-struktural-unset")."',{id_hrm_struktural:id, id_hrm_biodata: $('#id-hrm-biodata').val()},function(data){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
          . "else {"
            . "$(this).addClass('selected');"
            . "$.post('".site_url("hrm/hrm-settings-ajax/multi-struktural-set")."',{id_hrm_struktural:id, id_hrm_biodata: $('#id-hrm-biodata').val()},function(data){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "});"
          
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Multi Struktural")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-home'></i> ".lang("Multi Struktural")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/multi-struktural', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "hrm/hrm-settings/multi-struktural",
        'title'       => lang("Multi Struktural"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/multi-struktural");
    
	}
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */