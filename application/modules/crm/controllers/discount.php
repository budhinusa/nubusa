<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function index(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"      
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".tutupi{"
          . "display: none;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/moment.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
       . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Start Date"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("End Date"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Name"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),	  
      array(
        "title"       => lang("Info"),
        "id"          => 7,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Nominal"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 4,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $header_privilege = array(
      array(
        "title"       => lang("Approval"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Nilai"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $header_merchandise_hasil = array(
      array(
        "title"       => lang("Products"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $header_merchandise = array(
      array(
        "title"       => lang("Products"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $header_group_customer = $this->global_format->standart_head(array("Code", "Channel Type", "Group Customer","option"));
    
    $header_block_date = $this->global_format->standart_head(array("Start Date", "End Date", "Options"));
    $header_payment_channel= $this->global_format->standart_head(array("Title", "Code", "Options"));
    $header_voucher= $this->global_format->standart_head(array("Title", "Start Date", "End Date", "Limit", "Options"));
    
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
    
    $grid_merchandise_hasil = array(
      "limit"         => 10,
      "id"            => "table-merchandise-hasil",
      "search"        => "",
      "variable"      => "vm_merchandise_hasil",
      "cari"          => "searchMerchandiseHasil",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_merchandise = array(
      "limit"         => 10,
      "id"            => "table-merchandise",
      "search"        => "",
      "variable"      => "vm_merchandise",
      "cari"          => "searchMerchandise",
      "onselect"      => "merchandise_hasil_set();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_block_date = array(
      "limit"         => 10,
      "id"            => "table-block-date",
      "search"        => "",
      "variable"      => "vm_block_date",
      "cari"          => "searchBlockDate",
      "onselect"      => "discount_block_date_select();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_group_customer = array(
      "limit"         => 10,
      "id"            => "table-group-customer",
      "search"        => "",
      "variable"      => "vm_group_customer",
      "cari"          => "searchGroupCustomer",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_payment_channel = array(
      "limit"         => 10,
      "id"            => "table-payment-channel",
      "search"        => "",
      "variable"      => "vm_payment_channel",
      "cari"          => "searchPaymentChannel",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_voucher = array(
      "limit"         => 10,
      "id"            => "table-voucher",
      "search"        => "",
      "variable"      => "vm_voucher",
      "cari"          => "searchVoucher",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_privilege, $grid_privilege)
      . $this->global_format->js_grid_table(array(), $header_merchandise_hasil, $grid_merchandise_hasil)
      . $this->global_format->js_grid_table(array(), $header_merchandise, $grid_merchandise)
      . $this->global_format->js_grid_table(array(), $header_block_date, $grid_block_date)
      . $this->global_format->js_grid_table(array(), $header_group_customer, $grid_group_customer)
      . $this->global_format->js_grid_table(array(), $header_payment_channel, $grid_payment_channel)
      . $this->global_format->js_grid_table(array(), $header_voucher, $grid_voucher)
      . $this->global_format->standart_get("ambil_group_customer", site_url('crm/discount-ajax/group-customer-discount-get'), "{start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}", $grid_group_customer)
      . $this->global_format->standart_get("ambil_payment_channel", site_url('crm/discount-ajax/discount-payment-channel-get'), "{start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}", $grid_payment_channel)
      . $this->global_format->standart_get("ambil_voucher", site_url('crm/discount-ajax/discount-voucher-get'), "{start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}", $grid_voucher)
     
      . "function merchandise_hasil_set(){"
        . "var kirim = {"
          . "id_crm_pos_products_merchandise : {$grid_merchandise['variable']}.page.select_value,"
          . "id_crm_pos_discount : formutama.id_crm_pos_discount"
        . "};"
        . "$.post('".site_url("crm/discount-ajax/merchandise-discount-set")."', kirim, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_merchandise['variable']}.delete_items(kirim.id_crm_pos_products_merchandise);"
          . "{$grid_merchandise['variable']}.cari($('#{$grid_merchandise['cari']}').val());"
          . $this->global_format->js_grid_add($grid_merchandise_hasil, "hasil.data")
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
	  . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/discount-ajax/discount-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
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
                    
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/discount-ajax/discount-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
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
      
      . "function ambil_privilege(mulai){"
        . "$.post('".site_url('crm/discount-ajax/settings-discount-get')."', {start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid_privilege, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_privilege(hasil.start);'
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
      
      . "function ambil_merchandise(mulai){"
        . "$.post('".site_url('crm/discount-ajax/merchandise-get')."', {start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid_merchandise, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_merchandise(hasil.start);'
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
      
      . "function ambil_merchandise_hasil(mulai){"
        . "$.post('".site_url('crm/discount-ajax/merchandise-discount-get')."', {start: mulai, id_crm_pos_discount: formutama.id_crm_pos_discount}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid_merchandise_hasil, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_merchandise_hasil(hasil.start);'
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
      
      . "ambil_data(0);"
      . "";
    
    $data_privilege = $this->global_models->get_query("SELECT A.id_crm_pos_approval_settings, A.title"
      . " FROM crm_pos_approval_settings AS A"
      . " ORDER BY A.title ASC");
    foreach ($data_privilege AS $cs){
      $privilege[] = array(
        "id"    => $cs->id_crm_pos_approval_settings,
        "text"  => $cs->title,
      );
    }
//    $this->debug($privilege, true);
    $form = array(
      "variable"    => "formblockdate",
      "id"          => "form-block-date",
      "loading"     => "page-loading-block-date",
//      "else"        => "$('#spn-education').show(); formutama.status_education = 1;"
    );
    
    $param = array(
      "id_crm_pos_discount_block_date"  => "",
      "startdate"                       => "",
      "enddate"                         => "",
    );
    
    $kirim = array(
      "update"    => "{}",
      "insert"    => "{startdate: this.startdate, enddate: this.enddate, id_crm_pos_discount: formutama.id_crm_pos_discount}",
    );
    $form_payment = array(
      "variable"    => "formpaymentchannel",
      "id"          => "form-payment-channel",
      "loading"     => "page-loading-payment-channel",
//      "else"        => "$('#spn-education').show(); formutama.status_education = 1;"
    );
    
    $param_payment = array(
      "id_crm_payment_channel"              => "",
      "id_crm_pos_discount_payment_channel" => "",
    );
    
    $kirim_payment = array(
      "update"    => "{}",
      "insert"    => "{id_crm_payment_channel: this.id_crm_payment_channel, id_crm_pos_discount: formutama.id_crm_pos_discount}",
    );
    
    $form_voucher = array(
      "variable"    => "formvoucher",
      "id"          => "form-voucher",
      "loading"     => "page-loading-voucher",
    );
    
    $param_voucher = array(
      "id_crm_pos_discount_voucher" => "",
      "title"                       => "",
      "type"                        => "",
      "batas"                       => 0,
      "startdate"                   => "",
      "enddate"                     => "",
    );
    
    $kirim_voucher = array(
      "update"    => "{}",
      "insert"    => "{title: this.title, type: this.type, batas: this.batas, id_crm_pos_discount: formutama.id_crm_pos_discount, startdate: this.startdate, enddate: this.enddate}",
    );
    
    $this->load->model("crm/m_crmcustomer");
    $company_temp = $this->m_crmcustomer->company_group_dropdown_get();
    $channel = $company_temp['v2'];
    
    $foot .= ""
      . $this->global_format->standart_component()
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
      . "Vue.component('datetime', {"
        . "props: ['value'],"
        . "template: '#detapicker-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(this.$el).daterangepicker();'
          . '$(this.$el).daterangepicker({'
            . "timePicker: true,"
            . "timePicker24Hour: true,"
            . "timePickerIncrement: 15,"
            . "format: 'DD/MM/YYYY HH:mm'"
          . "}, function(start, end, label) {"
            . "formutama.startdate = start.format('YYYY-MM-DD HH:mm');"
            . "formutama.enddate = end.format('YYYY-MM-DD HH:mm');"
          . "});"
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).data("daterangepicker").setStartDate(formutama.startdate);'
            . '$(this.$el).data("daterangepicker").setEndDate(formutama.enddate);'
          . "},"
//          . "options: function (options) {"
//            . '$(this.$el).select2({ data: options })'
//          . "}"
        . "},"
        . "destroyed: function () {"
//          . '$(this.$el).off().select2("destroy")'
        . "}"
      . "});"
      
      . "Vue.component('ckeditor', {"
        . "props: ['value'],"
        . "template: '#ckeditor-template',"
        . "methods: {"
          . "isi: function (id, value) {"
            . "$('#'+id).val(value);"
          . "}"
        . "},"
        . "mounted: function () {"
          . "var vm = this;"
          . 'CKEDITOR.replace($(vm.$el).attr("id"));'
          . 'CKEDITOR.instances[$(vm.$el).attr("id")].on("change", function() {'
            . 'vm.isi($(vm.$el).attr("id"), CKEDITOR.instances[$(vm.$el).attr("id")].document.getBody().getHtml());'
          . '});'
          . 'CKEDITOR.instances[$(vm.$el).attr("id")].setData(this.value);'
          . '$(vm.$el).val(this.value);'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . 'CKEDITOR.instances[$(this.$el).attr("id")].setData(value);'
            . '$(this.$el).val(value);'
          . "},"
//          . "options: function (options) {"
//            . '$(this.$el).select2({ data: options })'
//          . "}"
        . "},"
        . "destroyed: function () {"
//          . '$(this.$el).off().select2("destroy")'
        . "}"
      . "});"
      
      . "Vue.component('checktoggle', {"
        . "props: ['value'],"
        . "template: '#checktoggle-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(vm.$el).prop("checked", vm.value).change();'
          . '$(vm.$el).change(function() {'
            . 'vm.$emit("input", $(vm.$el).prop("checked"));'
          . "});"
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).prop("checked", value).change();'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/discount-ajax/discount-block-date-set"), $grid_block_date, "")
      . $this->global_format->standart_form($form_payment, $param_payment, $kirim_payment, site_url("crm/discount-ajax/discount-payment-channel-set"), $grid_payment_channel, "")
      . $this->global_format->standart_form($form_voucher, $param_voucher, $kirim_voucher, site_url("crm/discount-ajax/discount-voucher-set"), $grid_voucher, "")
      
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "bataswaktu : false,"
          . "tanggal : '',"
          . "startdate : '',"
          . "enddate : '',"
          . "tutupi: 'tutupi',"
          . "type : true,"
          . "nilai : 0,"
          . "minimum: '',"
          . "maximum : '',"
          . "sort : 0,"
          . "approve : true,"
          . "merchandise : true,"
          . "gradual : true,"
          . "editable : false,"
          . "cashback : false,"
          . "is_company : false,"  
          . "is_payment_channel : false,"  
          . "is_voucher : false,"  
          . "code: '',"  
		  . "nameinprint: '',"  
          . "note : '',"
          . "id_crm_pos_discount: ''"
        . "},"
        . "watch: {"
          . "editable: function(val){"
            . "if(val == false){"
              . "this.cashback = false;"
            . "}"
          . "},"
          . "id_crm_pos_discount: function(val){"
            . "{$grid_privilege['variable']}.clear();"
            . "ambil_privilege(0);"
            . "{$grid_payment_channel['variable']}.clear();"
            . "ambil_payment_channel(0);"
            . "{$grid_voucher['variable']}.clear();"
            . "ambil_voucher(0);"
            . "if(this.merchandise == true){"
              . "{$grid_merchandise['variable']}.clear();"
              . "ambil_merchandise(0);"
              . "{$grid_merchandise_hasil['variable']}.clear();"
              . "ambil_merchandise_hasil(0);"
            . "}"
          . "},"
          . "approve: function(val){"
            . "if(val == true){"
              . "$('.need-approve').show();"
            . "}"
            . "else{"
              . "$('.need-approve').hide();"
            . "}"
          . "},"
          . "merchandise: function(val){"
            . "if(val == true){"
              . "$('.need-merchandise').show();"
            . "}"
            . "else{"
              . "$('.need-merchandise').hide();"
            . "}"
          . "},"
          . "is_payment_channel: function(val){"
            . "if(val == true){"
              . "$('.need-payment-channel').show();"
            . "}"
            . "else{"
              . "$('.need-payment-channel').hide();"
            . "}"
          . "},"
          . "is_voucher: function(val){"
            . "if(val == true){"
              . "$('.need-voucher').show();"
            . "}"
            . "else{"
              . "$('.need-voucher').hide();"
            . "}"
          . "}"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "bataswaktu : this.bataswaktu,"
              . "startdate : this.startdate,"
              . "enddate : this.enddate,"
              . "type : this.type,"
              . "nilai : this.nilai,"
              . "minimum : this.minimum,"
              . "maximum : this.maximum,"
              . "sort : this.sort,"
              . "editable : this.editable,"
              . "approve : this.approve,"
              . "merchandise : this.merchandise,"
              . "cashback : this.cashback,"
              . "is_company : this.is_company,"        
              . "is_payment_channel : this.is_payment_channel,"        
              . "is_voucher : this.is_voucher,"
              . "gradual : this.gradual,"
              . "code : this.code,"
			  . "nameinprint : this.nameinprint,"
              . "note : $('#note1').val(),"
              . "id_crm_pos_discount: this.id_crm_pos_discount"
            . "};"
            . "$('#page-loading-post').show();"
            . "$.post('".site_url("crm/discount-ajax/discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_pos_discount);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#page-loading-post').hide();"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "bataswaktu : this.bataswaktu,"
              . "startdate : this.startdate,"
              . "enddate : this.enddate,"
              . "type : this.type,"
              . "nilai : this.nilai,"
              . "minimum : this.minimum,"
              . "maximum : this.maximum,"
              . "sort : this.sort,"
              . "editable : this.editable,"
              . "approve : this.approve,"
              . "merchandise : this.merchandise,"
              . "cashback : this.cashback,"
              . "code : this.code,"
			  . "nameinprint : this.nameinprint,"
              . "is_company : this.is_company,"
              . "is_payment_channel : this.is_payment_channel,"        
              . "is_voucher : this.is_voucher,"
              . "gradual : this.gradual,"
              . "note : $('#note1').val()"
            . "};"
            . "$('#page-loading-post').show();"
            . "$.post('".site_url("crm/discount-ajax/discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_ = hasil.data.id;"
              . $this->global_format->js_grid_add($grid, "hasil.data")
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#page-loading-post').hide();"
            . "});"
          . "}"
        . "}"
      . "});"
      . ""
      . "var formprivilege = new Vue({"
        . "el: '#form-privilege',"
        . "data: {"
          . "id_crm_pos_approval_settings : '',"
          . "nilai : 0,"
          . "options_approval : ".json_encode($privilege).","
          . "id_crm_pos_discount_set: ''"
        . "},"
        . "watch: {"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "id_crm_pos_approval_settings : this.id_crm_pos_approval_settings,"
              . "nilai : this.nilai,"
              . "id_crm_pos_discount_set : this.id_crm_pos_discount_set,"
              . "id_crm_pos_discount: this.id_crm_pos_discount"
            . "};"
            . "$.post('".site_url("crm/discount-ajax/settings-discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid_privilege['variable']}.replace_items(hasil.data, kirim.id_crm_pos_discount_set);"
              . "{$grid_privilege['variable']}.items_live[{$grid_privilege['variable']}.page.select[0]] = hasil.data;"
              . "{$grid_privilege['variable']}.cari($('#{$grid_privilege['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "id_crm_pos_approval_settings : this.id_crm_pos_approval_settings,"
              . "nilai : this.nilai,"
              . "id_crm_pos_discount: formutama.id_crm_pos_discount"
            . "};"
            . "$.post('".site_url("crm/discount-ajax/settings-discount-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formprivilege.id_crm_pos_discount_set = hasil.data.id;"
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
      . ""
       . "$(document).on('click', '.group-customer-delete', function(evt){"
        . "id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/group-customer-discount-delete")."', {id: id}, function(data){"
              . "var hasil = $.parseJSON(data);"
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
              . "{$grid_group_customer['variable']}.delete_items(id);"
              . "{$grid_group_customer['variable']}.cari($('#{$grid_group_customer['cari']}').val());"
              . ""
            . "$('#positif-response-title').html('".lang("Note")."');"
            . "$('#positif-response-body').html(hasil.note);"
            . "$('#positif-response').modal('show');"
            . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
      . "});"
      . ""
      . "var formgroupcustomer = new Vue({"
        . "el: '#form-group-customer',"
        . "data: {"
          . "options_channel : ".json_encode($channel).","
          . "options_customer : '',"
          . "parent: '',"
          . "id_crm_customer_company: '',"
        . "},"
        . "watch: {"
          
        . "},"
        . "methods: {"
          . "add_new: function(){"
           . "$('#page-loading-group-customer').show();"            
            . "var kirim = {"
              . "parent : this.parent,"
              . "id_crm_customer_company : this.id_crm_customer_company,"
              . "id_crm_pos_discount : formutama.id_crm_pos_discount,"
            . "};"
            . "$.post('".site_url("crm/discount-ajax/group-customer-discount-set")."', kirim, function(data){"
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
                . "formutama.id_crm_pos_order = hasil.data.id;"
                . $this->global_format->js_grid_add($grid_group_customer, "hasil.data")
                . "{$grid_group_customer['variable']}.searchGroupCustomer = hasil.data.number;"
                . "{$grid_group_customer['variable']}.cari(hasil.data.number);"   
              . "}"          
            . "$('#page-loading-group-customer').hide();"
//            . "$('#page-loading-form-order').hide();"           
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
      . ""
       . "$(document).on('click', '.need-company', function(evt){"
        . "$('#select-channel').select2('');"              
        . "$('#select-customer').select2('');"
      . '});'                   
      . '$("#select-channel").on("change", function () {'
        . 'var id_crm_customer_temp = formgroupcustomer.parent;'
        . '$("#select-customer").html("");'
        . "$.post('".site_url("crm/discount-ajax/group-customer-dropdown-get")."', {id: formgroupcustomer.parent}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "$('#select-customer').select2({ data: hasil });"
//          . "formutama.options_customer = hasil;"
        . "})"
        . ".done(function(){"
          . "formutama.id_crm_customer_company = id_crm_customer_temp;"
          . "$('#select-customer').select2('val', id_crm_customer_temp);"
        . "})"
        . ";"
      . '});'                
      . ""                
      . "function select_utama(){"
        . "{$grid_group_customer['variable']}.clear();"         
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/discount-ajax/discount-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title        = hasil.title;"
          . "formutama.bataswaktu   = hasil.bataswaktu;"
          . "formutama.tanggal      = hasil.tanggal;"
          . "formutama.startdate    = hasil.startdate;"
          . "formutama.enddate      = hasil.enddate;"
          . "formutama.type         = hasil.type;"
          . "formutama.nilai        = hasil.nilai;"
          . "formutama.minimum      = hasil.minimum;"
          . "formutama.maximum      = hasil.maximum;"
          . "formutama.sort         = hasil.sort;"
          . "formutama.approve      = hasil.approve;"
          . "formutama.gradual      = hasil.gradual;"
          . "formutama.editable     = hasil.editable;"
          . "formutama.merchandise  = hasil.merchandise;"
          . "formutama.cashback     = hasil.cashback;"
          . "formutama.code         = hasil.code;"
		  . "formutama.nameinprint         = hasil.nameinprint;"
          . "formutama.is_company   = hasil.is_company;"      
          . "formutama.is_payment_channel   = hasil.is_payment_channel;"      
          . "formutama.is_voucher   = hasil.is_voucher;"
          . "formutama.note         = hasil.note;"
          . "formutama.id_crm_pos_discount = hasil.id_crm_pos_discount;"
           ."ambil_group_customer(0,hasil.id_crm_pos_discount);"      
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
      . "$(document).on('click', '.discount-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/discount-delete")."', {id: id}, function(data){"
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
      . "$(document).on('click', '.discount-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/discount-active")."', {id: id}, function(data){"
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
            
      . "$(document).on('click', '.privilege-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/settings-discount-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_privilege['variable']}.delete_items(id);"
          . "{$grid_privilege['variable']}.cari($('#{$grid_privilege['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
            
      . "$(document).on('click', '.merchandise-hasil-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/discount-ajax/merchandise-discount-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$grid_merchandise_hasil['variable']}.delete_items(id);"
          . "{$grid_merchandise_hasil['variable']}.cari($('#{$grid_merchandise_hasil['cari']}').val());"
          . $this->global_format->js_grid_add($grid_merchandise, "hasil.data")      
		  
		. "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
//      ."ambil_group_customer(0);"       
     
      //mj 23 nov 17
	  . "$(document).on('click', '.add_all', function(evt){"
        . "var kirim = {"
          . "id_crm_pos_discount : formutama.id_crm_pos_discount"
        . "};"
		. "{$grid_merchandise['variable']}.clear();" 
		. "$('#page-loading-post').show();"
        . "$.post('".site_url("crm/discount-ajax/merchandise-discount-set-all")."', kirim, function(data){"
          . "var hasil = $.parseJSON(data);"         
		  //. "alert(hasil.data);"
		  . 'if(hasil.status == 2){'
            . 'if(hasil.data){ '
				. "for(ind = 0; ind < hasil.data.length; ++ind){"
				//	. "alert(ind);"
					. $this->global_format->js_grid_add($grid_merchandise_hasil	, "hasil.data[ind]")
					. "}"
				. "}"            
			. "}"
          . 'else{'
          . '}'
		  
        . "})"
        
		. ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
		. "$('#page-loading-post').hide();"
        . "});"
      . "});"
	  
	  . "$(document).on('click', '.removed_all', function(evt){"
        . "var kirim = {"
          . "id_crm_pos_discount : formutama.id_crm_pos_discount"
        . "};"
		. "{$grid_merchandise_hasil['variable']}.clear();" 
		. "$('#page-loading-post').show();"
        . "$.post('".site_url("crm/discount-ajax/merchandise-discount-delete-all")."', kirim, function(data){"
          . "var hasil = $.parseJSON(data);"          
		 // . "alert(hasil.data);"
		  . 'if(hasil.status == 2){'
            . 'if(hasil.data){ '
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
			 // . "alert(ind);"
                . $this->global_format->js_grid_add($grid_merchandise	, "hasil.data[ind]")
              . "}"
            . "}else {}"
          . "}"
          . "else{"
          . "}"
	    . "})"
        
		. ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
		. "$('#page-loading-post').hide();"
        . "});"
      . "});"
	  
	  . "";
          
    $this->load->model("crm/js/j_discount");
    
    $foot .= ""
      . $this->j_discount->discount_payment_channel_delete()
      . $this->j_discount->discount_voucher_delete()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Scheme")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-tag'></i> ".lang("Scheme")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('discount/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/discount",
        'title'       => lang("Scheme"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid_privilege' => $grid_privilege,
        'grid_merchandise' => $grid_merchandise,
        'grid_merchandise_hasil' => $grid_merchandise_hasil,
        'grid_block_date' => $grid_block_date,
        'grid_group_customer' => $grid_group_customer,  
        'grid_payment_channel' => $grid_payment_channel,  
        'grid_voucher' => $grid_voucher,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("discount/main");
  }
  
}