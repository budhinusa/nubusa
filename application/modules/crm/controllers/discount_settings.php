<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  private function _ambil_data($grid, $url, $kirim, $fungsi){
    $html = ""
      . "function {$fungsi}(mulai){"
        . "$.post('{$url}', {{$kirim}}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . "{$fungsi}(hasil.start);"
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
  
  private function _header($header){
    $no = 1;
    foreach($header AS $hd){
      $head[] = array(
        "title"       => $hd,
        "id"          => $no,
        "asc"         => false,
        "desc"        => false,
      );
      $no++;
    }
    return $head;
  }


  public function approval_discount(){
    $search = $this->global_models->get_field("crm_pos_order", "nomor", array("id_crm_pos_order" => $id_crm_pos_order));
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/moment.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $foot .= ""
      . "Vue.component('select2', {"
        . "props: ['options', 'value'],"
        . "template: '#select2-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(this.$el).select2();'
          . '$(this.$el).select2({ data: this.options });'
          . '$(this.$el).select2("val", this.value);'
          . '$(this.$el).on("change", function () {'
            . 'vm.$emit("input", this.value);'
          . '});'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).select2("val", value);'
          . "},"
          . "options: function (options) {"
//            . '$(this.$el).select2({ data: options });'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy");'
        . "}"
      . "});"
      . "";
    
    $header = $this->_header(array(lang("Title"), lang("Status"), lang("Option")));
    
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
    $grid_privilege = array(
      "limit"         => 10,
      "id"            => "table-privilege",
      "search"        => "",
      "variable"      => "vm_privilege",
      "cari"          => "searchPrivilege",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->_ambil_data($grid, site_url('crm/discount-settings-ajax/settings-discount-get'), 'start: mulai', 'ambil_data')
      . "ambil_data(0);"
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/discount-settings-ajax/settings-discount-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.id_crm_pos_approval_settings = hasil.id_crm_pos_approval_settings;"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
          
      . "$(document).on('click', '.discount-delete', function(){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-settings-ajax/settings-discount-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid['variable']}.replace_items(hasil.data, id);"
          . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
        . "});"
      . "});"
          
      . "$(document).on('click', '.discount-active', function(){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-settings-ajax/settings-discount-active")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid['variable']}.replace_items(hasil.data, id);"
          . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
        . "});"
      . "});"
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "id_crm_pos_approval_settings: ''"
        . "},"
        . "watch: {"
          . "id_crm_pos_approval_settings: function(val){"
            . "{$grid_privilege['variable']}.clear();"
            . "ambil_privilege(0);"
          . "}"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "title : this.title,"
              . "id_crm_pos_approval_settings : this.id_crm_pos_approval_settings"
            . "};"
            . "$.post('".site_url("crm/discount-settings-ajax/settings-discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_pos_approval_settings);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "title : this.title"
            . "};"
            . "$.post('".site_url("crm/discount-settings-ajax/settings-discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "vm.id_crm_pos_approval_settings = hasil.data.id;"
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
          
      . "";
    
    $header_privilege = $this->_header(array(lang("Title"), lang("Nilai"), lang("Option")));
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header_privilege, $grid_privilege)
      . $this->_ambil_data($grid_privilege, site_url('crm/discount-settings-ajax/privilege-settings-discount-get'), 'start: mulai, id_crm_pos_approval_settings: formutama.id_crm_pos_approval_settings', 'ambil_privilege')
          
      . "$(document).on('click', '.privilege-delete', function(){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-settings-ajax/privilege-settings-discount-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_privilege['variable']}.delete_items(id);"
          . "{$grid_privilege['variable']}.cari($('#{$grid_privilege['cari']}').val());"
        . "});"
      . "});"
          
      . "";
          
    $data_privilege = $this->global_models->get_query("SELECT A.id_privilege, A.name"
      . " FROM m_privilege AS A"
      . " WHERE A.parent > 0"
      . " ORDER BY A.name ASC");
    foreach ($data_privilege AS $cs){
      $privilege[] = array(
        "id"    => $cs->id_privilege,
        "text"  => $cs->name,
      );
    }
    
    $foot .= ""
      . "var formprivilege = new Vue({"
        . "el: '#form-privilege',"
        . "data: {"
          . "nilai : '',"
          . "options_privilege : ".json_encode($privilege).","
          . "id_privilege : ''"
        . "},"
        . "watch: {"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "nilai : this.nilai,"
              . "id_crm_pos_approval_settings : formutama.id_crm_pos_approval_settings,"
              . "id_privilege : this.id_privilege"
            . "};"
            . "$.post('".site_url("crm/discount-settings-ajax/privilege-settings-discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . $this->global_format->js_grid_add($grid_privilege, "hasil.data")
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
          
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Approval for Discount")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-check-circle-o'></i> ".lang("Approval for Discount")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('discount/settings/approval-discount', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/discount-settings/approval-discount",
        'title'       => lang("Approval for Discount"),
        'foot'        => $foot,
        'css'         => $css,
        
        'category'    => $category,
        
        'grid'              => $grid,
        'grid_privilege'    => $grid_privilege,
        'grid_classification' => $grid_classification,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("discount/settings/approval-discount");
  }
  
}