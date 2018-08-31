<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }

  public function biodata(){
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
    
    $header = array(
      array(
        "title"       => lang("Number"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Name"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Users"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Telp"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Email"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Store"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
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
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/agent-master-ajax/biodata-get')."', {start: mulai}, function(data){"
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
    
		# -- DATA USER --
    $data_users = $this->global_models->get_query("SELECT A.id_users, A.name"
      . " FROM m_users AS A"
      . " WHERE A.status = 1"
//      . " AND A.id_users NOT IN (SELECT B.id_users FROM crm_agent AS B)"
      . " ORDER BY A.name ASC");
    foreach ($data_users AS $cs){
      $users[] = array(
        "id"    => $cs->id_users,
        "text"  => $cs->name,
      );
    }
		
			# -- DATA STORE --
    $data_stores = $this->global_models->get_query("SELECT A.id_crm_agent_store, A.title"
      . " FROM crm_agent_store AS A"
      . " ORDER BY A.sort ASC");
    foreach ($data_stores AS $cs){
      $stores[] = array(
        "id"    => $cs->id_crm_agent_store,
        "text"  => $cs->title,
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
            . '$(this.$el).select2({ data: options })'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy")'
        . "}"
      . "});"
      
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "name: '',"
          . "title: '',"
          . "jabatan: '',"
          . "telp : '',"
          . "email : '',"
          . "note : '',"
          . "no : '',"
          . "id_users : '',"
          . "id_crm_agent_store : '',"
          . "id_crm_agent : '',"
          . "options_status: ".json_encode($users).","
          . "options_store: ".json_encode($stores)
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "name : this.name,"
              . "title : this.title,"
              . "jabatan : this.jabatan,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "no : this.no,"
              . "note : this.note,"
              . "id_users : this.id_users,"
              . "id_crm_agent_store : this.id_crm_agent_store,"
              . "id_crm_agent : this.id_crm_agent"
            . "};"
            . "$.post('".site_url("crm/agent-master-ajax/biodata-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_agent);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
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
              . "jabatan : this.jabatan,"
              . "no : this.no,"
              . "telp : this.telp,"
              . "email : this.email,"
              . "note : this.note,"
              . "id_users : this.id_users,"
              . "id_crm_agent_store : this.id_crm_agent_store"
            . "};"
            . "$.post('".site_url("crm/agent-master-ajax/biodata-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_agent = hasil.data.id;"
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
      . ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/agent-master-ajax/biodata-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.no = hasil.no;"
          . "formutama.name = hasil.name;"
          . "formutama.telp = hasil.telp;"
          . "formutama.email = hasil.email;"
          . "formutama.title = hasil.title;"
          . "formutama.jabatan = hasil.jabatan;"
          . "formutama.note = hasil.note;"
          . "formutama.id_crm_agent = hasil.id_crm_agent;"
          . "formutama.id_users = hasil.id_users;"
          . "formutama.id_crm_agent_store = hasil.id_crm_agent_store;"
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
      . "<h1>".lang("Biodata")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-user-secret'></i> ".lang("Biodata")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('agent-master/biodata', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/agent-master/biodata",
        'title'       => lang("Agent"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
        'grid_quantity'     => $grid_quantity,
        'grid_merchandise'  => $grid_merchandise,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("agent-master/biodata");
  }
	
	public function store(){
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
    
    $header = array(
      array(
        "title"       => lang("Sort"),
        "id"          => 1,
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
        "title"       => lang("Telp"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Fax"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
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
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      
      . "function ambil_data(mulai){"
        . "$.post('".site_url('crm/agent-master-ajax/store-get')."', {start: mulai}, function(data){"
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
    
    $data_users = $this->global_models->get_query("SELECT A.id_users, A.name"
      . " FROM m_users AS A"
      . " WHERE A.status = 1"
//      . " AND A.id_users NOT IN (SELECT B.id_users FROM crm_agent AS B)"
      . " ORDER BY A.name ASC");
    foreach ($data_users AS $cs){
      $users[] = array(
        "id"    => $cs->id_users,
        "text"  => $cs->name,
      );
    }
//    $this->debug($company);
//    $this->debug(json_encode($company), true);
    $foot .= ""
      
      . "var formutama = new Vue({"
        . "el: '#form-utama',"
        . "data: {"
          . "title: '',"
          . "code: '',"
          . "telp : '',"
          . "fax : '',"
          . "address : '',"
          . "sort : '',"
          . "id_crm_agent_store : '',"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "code : this.code,"
              . "telp : this.telp,"
              . "fax : this.fax,"
              . "address : this.address,"
              . "sort : this.sort,"
              . "id_crm_agent_store : this.id_crm_agent_store"
            . "};"
            . "$.post('".site_url("crm/agent-master-ajax/store-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_crm_agent_store);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "add_new: function(){"
            . "var kirim = {"
              . "title : this.title,"
              . "code : this.code,"
              . "telp : this.telp,"
              . "fax : this.fax,"
              . "address : this.address,"
              . "sort : this.sort,"
              . "id_crm_agent_store : this.id_crm_agent_store"
            . "};"
            . "$.post('".site_url("crm/agent-master-ajax/store-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "formutama.id_crm_agent_store = hasil.data.id;"
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
      . ""
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("crm/agent-master-ajax/store-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.sort = hasil.sort;"
          . "formutama.title = hasil.title;"
          . "formutama.code = hasil.code;"
          . "formutama.telp = hasil.telp;"
          . "formutama.fax = hasil.fax;"
          . "formutama.address = hasil.address;"
          . "formutama.id_crm_agent_store = hasil.id_crm_agent_store;"
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
//      . "formutama.id_site_transport_products_categories = 'TZOX2AV6QY86RAPY';"
      . "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("crm/agent-master-ajax/store-delete")."', {id: id}, function(data){"
          . "{$grid['variable']}.delete_items(id);"
          . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
      . ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Store")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-user-secret'></i> ".lang("Store")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('agent-master/store', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "crm/agent-master/store",
        'title'       => lang("Store"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
        'grid_quantity'     => $grid_quantity,
        'grid_merchandise'  => $grid_merchandise,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("agent-master/store");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */