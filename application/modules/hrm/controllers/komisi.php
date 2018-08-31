<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Komisi extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
   function _bulanan_form($grid_bulanan,$grid_crew){
    $tahun2 = date('Y');
    $html = ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "tahun : '{$tahun2}',"
          . "bulan: '',"
          . "id_site_transport_komisi: '',"
        . "},"
        . "watch: {"
          
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "$('#page-loading-post-bulanan').show();"
            . "$('#page-loading-post-utama').show();"
            . "vm = this;"
            . "var kirim = {"
              . "tahun : this.tahun,"
              . "bulan : this.bulan,"
            . "};"
            . "$.post('".site_url("hrm/komisi-ajax/bulanan-set")."', kirim, function(data){"
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
            . "{$grid_bulanan['variable']}.clear();"
            . "{$grid_crew['variable']}.clear();"
            . "ambil_data(0,kirim.tahun);"
            . "})"
            . ".done(function(){"
             
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
             
            . "})"
            . ".always(function(){"
               . "$('#page-loading-post-utama').hide();"     
               . "$('#page-loading-post-bulanan').hide();"      
            . "});"
          . "},"
        . "search: function(){"
          . "{$grid_bulanan['variable']}.clear();"
          . "{$grid_crew['variable']}.clear();"
          . "var id = formutama.tahun;"
           . "ambil_data(0,id);" 
        . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function _partner_form($grid_partner){
   
    $html = ""
      . "var formpartner = new Vue({"
        . "el: '#form-partner',"
        . "data: {"
          . "jalan : '',"
          . "masuk: '',"
          . "flag: 1,"
          . "off: '',"
          . "id_site_transport_komisi_partner: '',"
        . "},"
        . "watch: {"
          
        . "},"
        . "methods: {"
          . "update: function(){"
            . "$('#page-loading-post-form-partner').show();"
            . "$('#page-loading-post-driver-helper').show();"
            . "vm = this;"
            . "var kirim = {"
              . "jalan : this.jalan,"
              . "masuk : this.masuk,"
              . "off   : this.off,"
              . "id_site_transport_komisi_partner : formpartner.id_site_transport_komisi_partner,"
            . "};"
            . "$.post('".site_url("hrm/komisi-ajax/partner-set")."', kirim, function(data){"
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
              . "}else{"
                . "{$grid_partner['variable']}.replace_items(hasil.data, kirim.id_site_transport_komisi_partner);"
                . "{$grid_partner['variable']}.items_live[{$grid_partner['variable']}.page.select[0]] = hasil.data;"
                . "{$grid_partner['variable']}.cari($('#{$grid_partner['cari']}').val());"
              . "}"
            . "})"
            . ".done(function(){"
             
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
             
            . "})"
            . ".always(function(){"
               . "$('#page-loading-post-form-partner').hide();"     
               . "$('#page-loading-post-driver-helper').hide();"      
            . "});"
          . "},"
          . "posting: function(){"
            . "$('#page-loading-post-form-partner').show();"
            . "$('#page-loading-post-driver-helper').show();"
            . "var kirim = {"
              . "flag  : this.flag,"
              . "id_site_transport_komisi_partner : formpartner.id_site_transport_komisi_partner,"
            . "};"
             . "$.post('".site_url("hrm/komisi-ajax/partner-set")."', kirim, function(data){"
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
              . "}else{"
            . "{$grid_partner['variable']}.replace_items(hasil.data, kirim.id_site_transport_komisi_partner);"
            . "{$grid_partner['variable']}.items_live[{$grid_partner['variable']}.page.select[0]] = hasil.data;"
            . "{$grid_partner['variable']}.cari($('#{$grid_partner['cari']}').val());"
            . "}"
            . "})"
            . ".done(function(){"
             
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
             
            . "})"
            . ".always(function(){"
               . "$('#page-loading-post-form-partner').hide();"     
               . "$('#page-loading-post-driver-helper').hide();"      
            . "});"        
          . "}"          
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function cetakan_komisi($id=''){

    $this->load->model("hrm/m_report");
    $report = $this->m_report->export_komisi($id);
    die;
  }
    public function index(){
    
   $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
        . "$('.select2').select2();"
        . "$(document).ready(function(){"
           . "$('.box-body').attr('style', 'overflow-x:auto;');" 
           
        . "$('.harga').priceFormat({"
          . "prefix: '',"
          . "centsLimit: 0"
        . "});"
            
        . "});"
      . "";
    
//    $header = $this->global_format->standart_head(array("Date", "Number", "Subject", "Company", "Customer", "Agent", "Status", "Option"));
   
    $header_bulan = $this->global_format->standart_head(array(lang("Bulan"),lang("option")));
    
    $grid_bulan = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "unselect_utama();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $header_partner = $this->global_format->standart_head(array(lang("Name"),lang("Type Bus"),lang("Status"),lang("Jalan"),lang("Masuk"),lang("Off"),lang("Hari Kerja"),lang("Uang Pengganti"),lang("Biaya Retensi"),lang("Premi"),lang("BPJS Kesehatan"),lang("Total Retensi + BPJS Kes"),lang("Total Pendapatan"),lang("Gross"),lang("Pajak"),lang("Denda"),lang("Total PPh")));
    
    $grid_partner = array(
      "limit"         => 10,
      "id"            => "table-partner",
      "search"        => "",
      "variable"      => "vm_partner",
      "cari"          => "searchStringPartner",
      "onselect"      => "select_partner();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "unselect_partner();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
     
      . $this->global_format->js_grid_table(array(), $header_bulan, $grid_bulan)
      . $this->global_format->js_grid_table(array(), $header_partner, $grid_partner)      

      . $this->_standart_get_field("ambil_data", site_url('hrm/komisi-ajax/bulanan-get'), "{start: mulai,id:id}", $grid_bulan)
      . ""
      . $this->_standart_get_field("ambil_partner", site_url('hrm/komisi-ajax/partner-get'), "{start: mulai,id:id}", $grid_partner)
//      . "ambil_crew(0);" 
      . "";
   
    $foot .= ""
      . $this->global_format->standart_component()
      . "";
    
    $foot .= ""
        . $this->_bulanan_form($grid_bulan,$grid_partner)
        . $this->_bulanan_select($grid_bulan,$grid_partner)     
        . $this->_partner_select($grid_partner)
        . $this->_partner_form($grid_partner)    
      . $this->global_format->standart_number_format()
      . "";
        
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Komisi")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-shopping-cart'></i> ".lang("Komisi")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('komisi', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "hrm/komisi",
        'title'       => lang("Komisi"),
        'foot'        => $foot,
        'css'         => $css,
        'grid_bulanan'   => $grid_bulan,
        'grid_crew'      => $grid_partner
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("komisi");
  }
  
  private function _standart_get_field($fungsi, $url, $kirim, $grid){
      $html = ""
      . "function {$fungsi}(mulai,id){"
        . "$.post('{$url}', {$kirim}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->_js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . "{$fungsi}(hasil.start,id);"
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
      . "";
    return $html;
  }
  
 private function _js_grid_add($grid, $variable){
    return ""
      . "if(Array.isArray({$grid['variable']}.items)){"
        . "{$grid['variable']}.items.push({$variable});"
        . "{$grid['variable']}.items_live.push({$variable});"
      . "}"
      . "else{"
        . "{$grid['variable']}.items = {$grid['variable']}.items_live = [{$variable}];"
      . "}"
      . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
    . "";
  }
  
  private function _bulanan_select($grid_bulan,$grid_partner){
      $html = ""
      . "function select_utama(){"
            
        . "{$grid_partner['variable']}.clear();"      
        . "var id = {$grid_bulan['variable']}.page.select_value;"
        . "ambil_partner(0,id);"
       
      . "}"
      . "function unselect_utama(){"
           . "{$grid_partner['variable']}.clear();"
      . "}"
//      . "$(document).on('click', '.cetakan-komisi', function(evt){"
//           
//      . "});"             
//      . ""
      . "";
    return $html;
  }
  
  private function _partner_select($grid_partner){
      $html = ""
      . "function select_partner(){"
        . "var id = {$grid_partner['variable']}.page.select_value;"
        . "formpartner.id_site_transport_komisi_partner=id;"
         . "var kirim = {"
              . "id : id,"
            . "};"        
          . "$.post('".site_url("hrm/komisi-ajax/partner-get-detail")."', kirim, function(data){"
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
                . "formpartner.jalan = hasil.jalan;"
                . "formpartner.masuk = hasil.masuk; "
                . "formpartner.off = hasil.off;"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"        
      . "}"
      . "function unselect_partner(){"
       . "formpartner.id_site_transport_komisi_partner='';"
       . "formpartner.jalan = '';"
       . "formpartner.masuk = ''; "
       . "formpartner.off = '';"         
      . "}"
      . "";
    return $html;
  }
}