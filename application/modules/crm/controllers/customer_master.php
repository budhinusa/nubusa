<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }

  public function company($parent = NULL){
//      $data_json = $this->nbscache->get("crmtrans_account");
//                $data_banding = json_decode($data_json);
//                
//          
//        $this->debug($data_banding->company_grouping[5]);        
//      $a = array(1,2,5);
//      $b = array(1,3,2);
//      $ss =array_intersect($b,$a);
//      print_r($ss);
//      die('cek');
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    if($parent){
        $company = lang("Customer Name");
        $form_company = lang("Form Customer");
    }else{
        $company = lang("Channel Type");
        $form_company = lang("Form Channel Type");
   
    }
    
    $header = $this->global_format->standart_head(array("Code", "Parent", $company, "Address", "Status", "Option"));
    $header_discount = $this->global_format->standart_head(array("Title", "Option"));
    
    $header_pic = $this->global_format->standart_head(array("Code", "Customer Name", "Name", "Telp", "Email", "Users"));
    
//    $this->debug(json_encode($data), true);
    $grid_pic = array(
      "limit"         => 10,
      "id"            => "table-pic",
      "search"        => "",
      "variable"      => "vm_pic",
      "cari"          => "searchStringPic",
      "onselect"      => "select_pic();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "unselect_pic();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_discount = array(
      "limit"         => 10,
      "id"            => "table-discount",
      "search"        => "",
      "variable"      => "vm_discount",
      "cari"          => "searchDiscount",
      "onselect"      => "select_discount();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid = array(
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
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_discount, $grid_discount)
      . $this->global_format->js_grid_table(array(), $header_pic, $grid_pic)      
      . $this->global_format->standart_get("ambil_discount", site_url('crm/customer-master-ajax/company-discount-get'), "{start: mulai, id_crm_customer_company: formutama.id_crm_customer_company}", $grid_discount)
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/customer-master-ajax/company-get')."', {start: mulai, parent: '{$parent}'}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
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
      
      . "ambil_data(0);"
      . ""
    . $this->global_format->standart_get("ambil_pic", site_url('crm/customer-master-ajax/customer-get'), "{start: mulai, id_crm_customer_company: formutama.id_crm_customer_company}", $grid_pic)
    . "";
//    print_r($this->global_variable->crm_customer_industry());
//    die;
    $data_users = $this->global_models->get_query("SELECT A.id_users, A.name"
      . " FROM m_users AS A"
      . " WHERE A.status = 1"
      . " AND A.id_users NOT IN (SELECT B.id_users FROM crm_customer AS B WHERE B.id_users IS NOT NULL)"
      . " ORDER BY A.name ASC");
    foreach ($data_users AS $cs){
      $users[] = array(
        "id"    => $cs->id_users,
        "text"  => $cs->name,
      );
    }
    
    $data_title = $this->global_variable->title_name();
    foreach ($data_title AS $id => $cs){
      $title[] = array(
        "id"    => $id,
        "text"  => $cs,
      );
    }
    
    foreach ($this->global_variable->crm_company_type() as $key =>  $value) {
        $type[] = array(
        "id"    => $key,
        "text"  => $value,
      );
    }
    
    $data_json = $this->nbscache->get("crmtrans_account");
    $data_banding = json_decode($data_json);
    foreach($data_banding->company_grouping AS $key => $dt){
      if($key > 0){
         $company_grouping[] = array(
        "id"    => $key,
        "text"  => $dt->title,
      );
      }
    }
   
    foreach ($this->global_variable->crm_company_type() as $key =>  $value) {
        $type[] = array(
        "id"    => $key,
        "text"  => $value,
      );
    }

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
            . '$(this.$el).select2({ data: options });'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy");'
        . "}"
      . "});"
      . "$(document).on('click', '.discount-delete', function(evt){"
        . "id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-discount-delete")."', {id: id}, function(data){"
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
              . "{$grid_discount['variable']}.delete_items(id);"
              . "{$grid_discount['variable']}.cari($('#{$grid_discount['cari']}').val());"
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
      . "var formcg = new Vue({"
        . "el: '#form-company-grouping',"
        . "data: {"
          . "company_grouping: '',"
          . "options_company_grouping: ".json_encode($company_grouping).","            
        . "},"
        . "methods: {"
          . "update: function(){"
            . "$('#page-loading-form-channel-type').show();"
            . "var kirim = {"
              . "id_crm_customer_company: this.id_crm_customer_company,"
              . "company_grouping: this.company_grouping,"        
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-set")."', kirim, function(data){"
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
                . "$('#page-loading-form-channel-type').hide();"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
        . "}"
      . "});"
      . ""      
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "kode : '',"
          . "utama : true,"
          . "location : '',"
          . "telp : '',"
          . "telp2 : '',"            
		  . "email : '',"  
          . "id_crm_customer_company: '',"
          . "type: 2,"
          . "company_grouping: '',"             
          . "options_type: ".json_encode($type).","
          . "options_company_grouping: ".json_encode($company_grouping).","            
        . "},"
        . "watch: {"
          . "id_crm_customer_company: function(val){"
            . "vm_discount.clear();"
            . "ambil_discount(0);"
          . "}"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "$('#page-loading-form-channel-type').show();"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "utama: this.utama,"
              . "location: this.location,"
              . "telp: this.telp,"
              . "telp2: this.telp2,"      
			  . "email: this.email,"    			  
              . "type: this.type,"
			  . "parent: '{$parent}',"
              . "id_crm_customer_company: this.id_crm_customer_company,"
              . "company_grouping: this.company_grouping,"        
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-set")."', kirim, function(data){"
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
                . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer_company);"
                . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
                . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
                . "$('#page-loading-form-channel-type').hide();"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "$('#page-loading-form-channel-type').show();"            
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "utama: this.utama,"
              . "location: this.location,"
			  . "telp: this.telp,"
              . "telp2: this.telp2,"          
			  . "email: this.email,"          
              . "type: this.type,"       
              . "parent: '{$parent}',"
              . "company_grouping: this.company_grouping,"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-set")."', kirim, function(data){"
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
                . "formutama.id_crm_customer_company = hasil.data.id;"
                . $this->global_format->js_grid_add($grid, "hasil.data")
                . "$('#page-loading-form-channel-type').hide();"       
              . "}"
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
      . "var formscheme = new Vue({"
        . "el: '#form-pricing-scheme',"
        . "data: {"
          . "type : true,"
          . "fee : 0,"
          . "margin : 0"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "type: this.type,"
              . "fee: this.fee,"
              . "margin: this.margin,"
              . "id_crm_customer_company: formutama.id_crm_customer_company"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-pricing-scheme-set")."', kirim, function(data){"
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
      . "function select_utama(){"
        . "{$grid_pic['variable']}.clear();"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/company-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.kode = hasil.kode;"
          . "formscheme.type = hasil.type;"
          . "formscheme.fee = hasil.fee;"
          . "formscheme.margin = hasil.margin;"
          . "formutama.type = hasil.type_company;"      
          . "formutama.utama = hasil.utama;"
          . "formutama.location = hasil.location;"
          . "formutama.telp = hasil.telp;"
          . "formutama.telp2 = hasil.telp2;"      
          . "formutama.email = hasil.email;" 
          . "formutama.id_crm_customer_company = hasil.id_crm_customer_company;"
          . "formutama.company_grouping = hasil.company_grouping;"
          . "ambil_pic(0,hasil.id_crm_customer_company);"
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
      . "function unselect_utama(){"
        . "{$grid_pic['variable']}.clear();"
          . "formutama.title = '';"
          . "formutama.kode = '';"
          . "formscheme.type = '';"
          . "formscheme.fee = '';"
          . "formscheme.margin = '';"
          . "formutama.type = '';"      
          . "formutama.utama = '';"
          . "formutama.location = '';"
          . "formutama.telp = '';"
          . "formutama.telp2 = '';"      
		  . "formutama.email = '';"
          . "formutama.id_crm_customer_company = '';"
          . "formutama.company_grouping = '';"
          . ""
          . "formpic.name = '';"
          . "formpic.title = 1;"      
          . "formpic.telp = '';"
          . "formpic.email = '';"
          . "formpic.division = '';"      
          . "formpic.handphone = '';"
          . "formpic.fax = '';"
          . "formpic.note = '';"
          . "formpic.id_crm_customer = '';"      
      . "}"
      . ""
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-status")."', {id: id, status: 2}, function(data){"
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
      . "var formpic = new Vue({"
        . "el: '#form-pic',"
        . "data: {"
          . "title: 1,"
          . "name: '',"
          . "telp : '',"
          . "email : '',"
          . "division : '',"  
          . "handphone : '',"
          . "fax : '',"
          . "note : '',"
          . "id_users : '',"      
          . "id_crm_customer_company : '',"
          . "id_crm_customer : '',"
          . "options_status: ".json_encode($company).","
          . "options_users: ".json_encode($users).","
          . "options_title: ".json_encode($title)
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "name : this.name,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division : this.division,"
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "flag: 2,"    
              . "note : this.note,"
              . "id_crm_customer_company : formutama.id_crm_customer_company,"
              . "id_crm_customer : this.id_crm_customer"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid_pic['variable']}.replace_items(hasil.data, kirim.id_crm_customer);"
              . "{$grid_pic['variable']}.items_live[{$grid_pic['variable']}.page.select[0]] = hasil.data;"
              . "{$grid_pic['variable']}.cari($('#{$grid_pic['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "name : this.name,"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division  : this.division,"        
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "flag: 2,"           
              . "note : this.note,"
              . "id_crm_customer_company : formutama.id_crm_customer_company,"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
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
                . "formpic.id_crm_customer = hasil.data.id;"
                . $this->global_format->js_grid_add($grid_pic, "hasil.data")
              . "}"
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
      . "function select_pic(){"
        . "var id = {$grid_pic['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/customer-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formpic.name = hasil.name;"
          . "formpic.telp = hasil.telp;"
          . "formpic.title = hasil.title;"      
          . "formpic.email = hasil.email;"
          . "formpic.division = hasil.division;"      
          . "formpic.handphone = hasil.handphone;"
          . "formpic.fax = hasil.fax;"
          . "formpic.note = hasil.note;"
          . "formpic.id_crm_customer = hasil.id_crm_customer;"
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
      . "$(document).on('click', '#li-pic', function(evt){"
        . "$('#pic-users').select2('');"              
        . "$('#pic-title').select2('');"
      . "});"
      . ""
    . "function unselect_pic(){"
          . "formpic.name = '';"
          . "formpic.title = 1;"      
          . "formpic.telp = '';"
          . "formpic.email = '';"
          . "formpic.division = '';"      
          . "formpic.handphone = '';"
          . "formpic.fax = '';"
          . "formpic.note = '';"
          . "formpic.id_crm_customer = '';"            
    . "}"
      . ""            
      . "$(document).on('click', '.company-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-status")."', {id: id, status: 1}, function(data){"
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
    $form = array(
      "variable"    => "formdiscount",
      "id"          => "form-discount",
      "loading"     => "page-loading-discount",
//      "else"        => "$('#spn-education').show(); formutama.status_education = 1;"
    );
    
    $param = array(
      "id_crm_pos_discount"               => "",
      "id_crm_customer_company_discount"  => "",
    );
    
    $kirim = array(
      "update"    => "{}",
      "insert"    => "{id_crm_pos_discount: this.id_crm_pos_discount, id_crm_customer_company: formutama.id_crm_customer_company}",
    );
    
    $foot .= ""
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/customer-master-ajax/company-discount-set"), $grid_discount, "")
      . "";
          
    $this->load->model("crm/m_crmdiscount");
    $discount_companny = $this->m_crmdiscount->discount_company_list();
//    $this->debug($discount_companny, true);
    $foot .= "</script>";
    
    
    
    $head = ""
      . "<h1>".$company."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-building'></i> ".$company."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/company', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/company",
        'title'       => $company,
        'foot'        => $foot,
        'css'         => $css,
        'discount'    => $discount_companny["v1"],
        'form_company'  => $form_company,
        'grid'        => $grid,
        'parent'        => $parent,  
        'company'       => $company,  
        'grid_discount' => $grid_discount,
        'grid_pic'      => $grid_pic  
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/company");
  }
	
	public function company_all($parent = NULL){
      
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    if($parent){
        $company = lang("Customer Name");
        $form_company = lang("Form Customer");
    }else{
        $company = lang("Channel Type");
        $form_company = lang("Form Channel Type");
   
    }
    
    $header = $this->global_format->standart_head(array("Code", "Parent", $company, "Address", "Status", "Option"));
    $header_discount = $this->global_format->standart_head(array("Title", "Option"));
    
    $header_pic = $this->global_format->standart_head(array("Code", "Customer Name", "Name", "Telp", "Email", "Users"));
    
//    $this->debug(json_encode($data), true);
    $grid_pic = array(
      "limit"         => 10,
      "id"            => "table-pic",
      "search"        => "",
      "variable"      => "vm_pic",
      "cari"          => "searchStringPic",
      "onselect"      => "select_pic();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "unselect_pic();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_discount = array(
      "limit"         => 10,
      "id"            => "table-discount",
      "search"        => "",
      "variable"      => "vm_discount",
      "cari"          => "searchDiscount",
      "onselect"      => "select_discount();",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid = array(
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
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_discount, $grid_discount)
      . $this->global_format->js_grid_table(array(), $header_pic, $grid_pic)      
      . $this->global_format->standart_get("ambil_discount", site_url('crm/customer-master-ajax/company-discount-get'), "{start: mulai, id_crm_customer_company: formutama.id_crm_customer_company}", $grid_discount)
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/customer-master-ajax/company-all-get')."', {start: mulai, parent: '{$parent}'}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
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
      
      . "ambil_data(0);"
      . ""
    . $this->global_format->standart_get("ambil_pic", site_url('crm/customer-master-ajax/customer-get'), "{start: mulai, id_crm_customer_company: formutama.id_crm_customer_company}", $grid_pic)
    . "";
//    print_r($this->global_variable->crm_customer_industry());
//    die;
    $data_users = $this->global_models->get_query("SELECT A.id_users, A.name"
      . " FROM m_users AS A"
      . " WHERE A.status = 1"
      . " AND A.id_users NOT IN (SELECT B.id_users FROM crm_customer AS B WHERE B.id_users IS NOT NULL)"
      . " ORDER BY A.name ASC");
    foreach ($data_users AS $cs){
      $users[] = array(
        "id"    => $cs->id_users,
        "text"  => $cs->name,
      );
    }
    
    $data_title = $this->global_variable->title_name();
    foreach ($data_title AS $id => $cs){
      $title[] = array(
        "id"    => $id,
        "text"  => $cs,
      );
    }
    
    foreach ($this->global_variable->crm_company_type() as $key =>  $value) {
        $type[] = array(
        "id"    => $key,
        "text"  => $value,
      );
    }
    
    $data_json = $this->nbscache->get("crmtrans_account");
    $data_banding = json_decode($data_json);
    foreach($data_banding->company_grouping AS $key => $dt){
      if($key > 0){
         $company_grouping[] = array(
        "id"    => $key,
        "text"  => $dt->title,
      );
      }
    }
   
    foreach ($this->global_variable->crm_company_type() as $key =>  $value) {
        $type[] = array(
        "id"    => $key,
        "text"  => $value,
      );
    }

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
            . '$(this.$el).select2({ data: options });'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy");'
        . "}"
      . "});"
      . "$(document).on('click', '.discount-delete', function(evt){"
        . "id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-discount-delete")."', {id: id}, function(data){"
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
              . "{$grid_discount['variable']}.delete_items(id);"
              . "{$grid_discount['variable']}.cari($('#{$grid_discount['cari']}').val());"
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
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title : '',"
          . "kode : '',"
          . "utama : true,"
          . "location : '',"
          . "telp : '',"
          . "telp2 : '',"            
		  . "email : '',"  
          . "id_crm_customer_company: '',"
          . "type: 2,"
          . "company_grouping: '',"             
          . "options_type: ".json_encode($type).","
          . "options_company_grouping: ".json_encode($company_grouping).","            
        . "},"
        . "watch: {"
          . "id_crm_customer_company: function(val){"
            . "vm_discount.clear();"
            . "ambil_discount(0);"
          . "}"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "utama: this.utama,"
              . "location: this.location,"
              . "telp: this.telp,"
              . "telp2: this.telp2,"      
			  . "email: this.email,"    			  
              . "type: this.type,"
              . "id_crm_customer_company: this.id_crm_customer_company,"
              . "company_grouping: this.company_grouping,"        
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-set")."', kirim, function(data){"
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
                . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer_company);"
                . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
                . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "kode: this.kode,"
              . "utama: this.utama,"
              . "location: this.location,"
			  . "telp: this.telp,"
              . "telp2: this.telp2,"          
			  . "email: this.email,"          
              . "type: this.type,"       
              . "parent: '{$parent}',"
              . "company_grouping: this.company_grouping,"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-set")."', kirim, function(data){"
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
                . "formutama.id_crm_customer_company = hasil.data.id;"
                . $this->global_format->js_grid_add($grid, "hasil.data")
              . "}"
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
      . "var formscheme = new Vue({"
        . "el: '#form-pricing-scheme',"
        . "data: {"
          . "type : true,"
          . "fee : 0,"
          . "margin : 0"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "type: this.type,"
              . "fee: this.fee,"
              . "margin: this.margin,"
              . "id_crm_customer_company: formutama.id_crm_customer_company"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-pricing-scheme-set")."', kirim, function(data){"
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
      . "function select_utama(){"
        . "{$grid_pic['variable']}.clear();"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/company-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.title;"
          . "formutama.kode = hasil.kode;"
          . "formscheme.type = hasil.type;"
          . "formscheme.fee = hasil.fee;"
          . "formscheme.margin = hasil.margin;"
          . "formutama.type = hasil.type_company;"      
          . "formutama.utama = hasil.utama;"
          . "formutama.location = hasil.location;"
          . "formutama.telp = hasil.telp;"
          . "formutama.telp2 = hasil.telp2;"      
		  . "formutama.email = hasil.email;" 
          . "formutama.id_crm_customer_company = hasil.id_crm_customer_company;"
          . "formutama.company_grouping = hasil.company_grouping;"
          . "ambil_pic(0,hasil.id_crm_customer_company);"
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
      . "function unselect_utama(){"
        . "{$grid_pic['variable']}.clear();"
          . "formutama.title = '';"
          . "formutama.kode = '';"
          . "formscheme.type = '';"
          . "formscheme.fee = '';"
          . "formscheme.margin = '';"
          . "formutama.type = '';"      
          . "formutama.utama = '';"
          . "formutama.location = '';"
          . "formutama.telp = '';"
          . "formutama.telp2 = '';"      
		  . "formutama.email = '';"
          . "formutama.id_crm_customer_company = '';"
          . "formutama.company_grouping = '';"
          . ""
          . "formpic.name = '';"
          . "formpic.title = 1;"      
          . "formpic.telp = '';"
          . "formpic.email = '';"
          . "formpic.division = '';"      
          . "formpic.handphone = '';"
          . "formpic.fax = '';"
          . "formpic.note = '';"
          . "formpic.id_crm_customer = '';"      
      . "}"
      . ""
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-status")."', {id: id, status: 2}, function(data){"
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
      . "var formpic = new Vue({"
        . "el: '#form-pic',"
        . "data: {"
          . "title: 1,"
          . "name: '',"
          . "telp : '',"
          . "email : '',"
          . "division : '',"  
          . "handphone : '',"
          . "fax : '',"
          . "note : '',"
          . "id_users : '',"      
          . "id_crm_customer_company : '',"
          . "id_crm_customer : '',"
          . "options_status: ".json_encode($company).","
          . "options_users: ".json_encode($users).","
          . "options_title: ".json_encode($title)
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "name : this.name,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division : this.division,"
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "flag: 2,"    
              . "note : this.note,"
              . "id_crm_customer_company : formutama.id_crm_customer_company,"
              . "id_crm_customer : this.id_crm_customer"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid_pic['variable']}.replace_items(hasil.data, kirim.id_crm_customer);"
              . "{$grid_pic['variable']}.items_live[{$grid_pic['variable']}.page.select[0]] = hasil.data;"
              . "{$grid_pic['variable']}.cari($('#{$grid_pic['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "name : this.name,"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division  : this.division,"        
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "flag: 2,"           
              . "note : this.note,"
              . "id_crm_customer_company : formutama.id_crm_customer_company,"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
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
                . "formpic.id_crm_customer = hasil.data.id;"
                . $this->global_format->js_grid_add($grid_pic, "hasil.data")
              . "}"
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
      . "function select_pic(){"
        . "var id = {$grid_pic['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/customer-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formpic.name = hasil.name;"
          . "formpic.telp = hasil.telp;"
          . "formpic.title = hasil.title;"      
          . "formpic.email = hasil.email;"
          . "formpic.division = hasil.division;"      
          . "formpic.handphone = hasil.handphone;"
          . "formpic.fax = hasil.fax;"
          . "formpic.note = hasil.note;"
          . "formpic.id_crm_customer = hasil.id_crm_customer;"
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
      . "$(document).on('click', '#li-pic', function(evt){"
        . "$('#pic-users').select2('');"              
        . "$('#pic-title').select2('');"
      . "});"
      . ""
    . "function unselect_pic(){"
          . "formpic.name = '';"
          . "formpic.title = 1;"      
          . "formpic.telp = '';"
          . "formpic.email = '';"
          . "formpic.division = '';"      
          . "formpic.handphone = '';"
          . "formpic.fax = '';"
          . "formpic.note = '';"
          . "formpic.id_crm_customer = '';"            
    . "}"
      . ""            
      . "$(document).on('click', '.company-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/customer-master-ajax/company-status")."', {id: id, status: 1}, function(data){"
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
    $form = array(
      "variable"    => "formdiscount",
      "id"          => "form-discount",
      "loading"     => "page-loading-discount",
//      "else"        => "$('#spn-education').show(); formutama.status_education = 1;"
    );
    
    $param = array(
      "id_crm_pos_discount"               => "",
      "id_crm_customer_company_discount"  => "",
    );
    
    $kirim = array(
      "update"    => "{}",
      "insert"    => "{id_crm_pos_discount: this.id_crm_pos_discount, id_crm_customer_company: formutama.id_crm_customer_company}",
    );
    
    $foot .= ""
      . $this->global_format->standart_form($form, $param, $kirim, site_url("crm/customer-master-ajax/company-discount-set"), $grid_discount, "")
      . "";
          
    $this->load->model("crm/m_crmdiscount");
    $discount_companny = $this->m_crmdiscount->discount_company_list();
//    $this->debug($discount_companny, true);
    $foot .= "</script>";
    
    
    
    $head = ""
      . "<h1>".$company."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-building'></i> ".$company."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/company-all', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/company-all",
        'title'       => $company,
        'foot'        => $foot,
        'css'         => $css,
        'discount'    => $discount_companny["v1"],
        'form_company'  => $form_company,
        'grid'        => $grid,
        'parent'        => $parent,  
        'company'       => $company,  
        'grid_discount' => $grid_discount,
        'grid_pic'      => $grid_pic  
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/company-all");
  }
  
  public function customer(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Company", "Name", "Telp", "Email", "Users"));
    
    
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
      "on_unselect"   => "unselect_utama();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/customer-master-ajax/customer-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
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
      
      . "ambil_data(0);"
      . "";
    
    $this->load->model("crm/m_crmcustomer");
    $company_temp = $this->m_crmcustomer->company_dropdown_get();
    $company = $company_temp['v2'];
    
    $data_users = $this->global_models->get_query("SELECT A.id_users, A.name"
      . " FROM m_users AS A"
      . " WHERE A.status = 1"
      . " AND A.id_users NOT IN (SELECT B.id_users FROM crm_customer AS B WHERE B.id_users IS NOT NULL)"
      . " ORDER BY A.name ASC");
    foreach ($data_users AS $cs){
      $users[] = array(
        "id"    => $cs->id_users,
        "text"  => $cs->name,
      );
    }
    
    $data_title = $this->global_variable->title_name();
    foreach ($data_title AS $id => $cs){
      $title[] = array(
        "id"    => $id,
        "text"  => $cs,
      );
    }
//    $this->debug($company);
//    $this->debug(json_encode($company), true);
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
            . '$(this.$el).select2({ data: options });'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy");'
        . "}"
      . "});"
      
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title: 1,"
          . "name: '',"
          . "telp : '',"
          . "email : '',"
          . "division : '',"  
          . "handphone : '',"
          . "fax : '',"
          . "note : '',"
          . "id_users : '',"
          . "id_crm_customer_company : '',"
          . "id_crm_customer : '',"
          . "options_status: ".json_encode($company).","
          . "options_users: ".json_encode($users).","
          . "options_title: ".json_encode($title)
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "name : this.name,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division : this.division,"
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "note : this.note,"
              . "id_crm_customer_company : this.id_crm_customer_company,"
              . "id_crm_customer : this.id_crm_customer"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
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
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "name : this.name,"
              . "title : this.title,"
              . "id_users : this.id_users,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "division  : this.division,"        
              . "handphone : this.handphone,"
              . "fax : this.fax,"
              . "note : this.note,"
              . "id_crm_customer_company : this.id_crm_customer_company"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-set")."', kirim, function(data){"
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
            . "formutama.id_crm_customer = hasil.data.id;"
            . $this->global_format->js_grid_add($grid, "hasil.data")          
          . "}"          
              
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
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/customer-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.name = hasil.name;"
          . "formutama.title = hasil.title;"      
          . "formutama.telp = hasil.telp;"
          . "formutama.email = hasil.email;"
          . "formutama.division = hasil.division;"      
          . "formutama.handphone = hasil.handphone;"
          . "formutama.fax = hasil.fax;"
          . "formutama.note = hasil.note;"
          . "formutama.id_crm_customer_company = hasil.id_crm_customer_company;"
          . "formutama.id_crm_customer = hasil.id_crm_customer;"
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
      . "function unselect_utama(){"
          . "formutama.name = '';"
          . "formutama.title = 1;"      
          . "formutama.telp = '';"
          . "formutama.email = '';"
          . "formutama.division = '';"      
          . "formutama.handphone = '';"
          . "formutama.fax = '';"
          . "formutama.note = '';"
          . "formutama.id_crm_customer_company = '';"
          . "formutama.id_crm_customer = '';"          
      . "}"
      . ""
//      . "formutama.id_site_transport_products_categories = 'TZOX2AV6QY86RAPY';"
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-delete")."', {id: id}, function(data){"
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
      . "$(document).on('click', '.form-active', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crmtrans/transport-master-ajax/inventory-active")."', {id: id}, function(data){"
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
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Customers")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-users'></i> ".lang("Customers")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/customer', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/customer",
        'title'       => lang("Customers"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
        'grid_quantity'     => $grid_quantity,
        'grid_merchandise'  => $grid_merchandise,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/customer");
  }
  
  private function _ambil_data($grid, $url, $kirim, $fungsi){
    $html = ""
      . "function {$fungsi}(mulai){"
        . "$.post('{$url}', {{$kirim}}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          // . 'console.log(hasil.data);'
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


  public function company_credit(){
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
    
    $header = $this->_header(array(lang("Code"), lang("Company"), lang("Credit")));
    
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
    $grid_log = array(
      "limit"         => 10,
      "id"            => "table-log",
      "search"        => "",
      "variable"      => "vm_log",
      "cari"          => "searchLog",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->_ambil_data($grid, site_url('crm/customer-master-ajax/company-credit-get'), 'start: mulai', 'ambil_data')
      . "ambil_data(0);"
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/company-credit-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.id_crm_customer_company = hasil.id_crm_customer_company;"
        . "})"
        . ".done(function(){"
				. "$('#form-credit').css('display', 'block');"
				. "$('#list-log-credit').css('display', 'block');"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
          
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "status: 1,"
          . "credit : '',"
          . "note : '',"
          . "id_crm_customer_company: ''"
        . "},"
        . "watch: {"
          . "id_crm_customer_company: function(val){"
            . "{$grid_log['variable']}.clear();"
            . "ambil_log(0);"
          . "}"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "status : this.status,"
              . "credit : this.credit,"
              . "note : this.note,"
              . "id_crm_customer_company : this.id_crm_customer_company"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-credit-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer_company);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
              . $this->global_format->js_grid_add($grid_log, "hasil.data_log")
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
    
    $header_log = $this->_header(array(lang("Date"), lang("Users"), lang("In"), lang("Out")));
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header_log, $grid_log)
      . $this->_ambil_data($grid_log, site_url('crm/customer-master-ajax/company-credit-log-get'), 'start: mulai, id_crm_customer_company: formutama.id_crm_customer_company', 'ambil_log')
          
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Company Credit")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-money'></i> ".lang("Company Credit")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/company-credit', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/company-credit",
        'title'       => lang("Company Credit"),
        'foot'        => $foot,
        'css'         => $css,
        
        'category'    => $category,
        
        'grid'        => $grid,
        'grid_log'    => $grid_log,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/company-credit");
  }
	
	public function company_deposit(){
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
    
    $header = $this->_header(array(lang("Code"), lang("Company"), lang("Deposit")));
    
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
    $grid_log = array(
      "limit"         => 10,
      "id"            => "table-log",
      "search"        => "",
      "variable"      => "vm_log",
      "cari"          => "searchLog",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->_ambil_data($grid, site_url('crm/customer-master-ajax/company-deposit-get'), 'start: mulai', 'ambil_data')
      . "ambil_data(0);"
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/company-deposit-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.id_crm_customer_company = hasil.id_crm_customer_company;"
        . "})"
        . ".done(function(){"
				. "$('#form-deposit').css('display', 'block');"
				. "$('#list-log-deposit').css('display', 'block');"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
          
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "status: 1,"
          . "deposit : '',"
          . "note : '',"
          . "id_crm_customer_company: ''"
        . "},"
        . "watch: {"
          . "id_crm_customer_company: function(val){"
            . "{$grid_log['variable']}.clear();"
            . "ambil_log(0);"
          . "}"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "status : this.status,"
              . "deposit : this.deposit,"
              . "note : this.note,"
              . "id_crm_customer_company : this.id_crm_customer_company"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/company-deposit-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer_company);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
              . $this->global_format->js_grid_add($grid_log, "hasil.data_log")
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
    
    $header_log = $this->_header(array(lang("Date"), lang("Users"), lang("Debit"), lang("Credit")));
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header_log, $grid_log)
      . $this->_ambil_data($grid_log, site_url('crm/customer-master-ajax/company-deposit-log-get'), 'start: mulai, id_crm_customer_company: formutama.id_crm_customer_company', 'ambil_log')
          
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Company Deposit")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-money'></i> ".lang("Company Deposit")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/company-deposit', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/company-deposit",
        'title'       => lang("Company Deposit"),
        'foot'        => $foot,
        'css'         => $css,
        
        'category'    => $category,
        
        'grid'        => $grid,
        'grid_log'    => $grid_log,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/company-deposit");
  }
	
	public function customer_deposit(){
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
    
    $header = $this->_header(array( lang("Nama"), lang("Company"), lang("Email"), lang("Telp"), lang("Deposit")));
    
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
    $grid_log = array(
      "limit"         => 10,
      "id"            => "table-log",
      "search"        => "",
      "variable"      => "vm_log",
      "cari"          => "searchLog",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->_ambil_data($grid, site_url('crm/customer-master-ajax/customer-deposit-get'), 'start: mulai', 'ambil_data')
      . "ambil_data(0);"
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/customer-master-ajax/customer-deposit-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.id_crm_customer = hasil.id_crm_customer;"
        . "})"
        . ".done(function(){"
				. "$('#form-deposit').css('display', 'block');"
				. "$('#list-log-deposit').css('display', 'block');"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
          
      . "";
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "status: 1,"
          . "deposit : '',"
          . "note : '',"
          . "id_crm_customer: ''"
        . "},"
        . "watch: {"
          . "id_crm_customer: function(val){"
            . "{$grid_log['variable']}.clear();"
            . "ambil_log(0);"
          . "}"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var vm = this;"
            . "var kirim = {"
              . "status : this.status,"
              . "deposit : this.deposit,"
              . "note : this.note,"
              . "id_crm_customer : this.id_crm_customer"
            . "};"
            . "$.post('".site_url("crm/customer-master-ajax/customer-deposit-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_customer);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
              . $this->global_format->js_grid_add($grid_log, "hasil.data_log")
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
    
    $header_log = $this->_header(array(lang("Date"), lang("Users"), lang("In"), lang("Out")));
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header_log, $grid_log)
      . $this->_ambil_data($grid_log, site_url('crm/customer-master-ajax/customer-deposit-log-get'), 'start: mulai, id_crm_customer: formutama.id_crm_customer', 'ambil_log')
          
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Customer Deposit")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-money'></i> ".lang("Customer Deposit")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('customer-master/customer-deposit', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/customer-master/customer-deposit",
        'title'       => lang("Customer Deposit"),
        'foot'        => $foot,
        'css'         => $css,
        
        'category'    => $category,
        
        'grid'        => $grid,
        'grid_log'    => $grid_log,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("customer-master/customer-deposit");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */