<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends MX_Controller {
    
  function __construct() {
//   $this->menu = $this->cek();
  }
  /**
   * @author Andi Wibowo
   * Type Backend
	*/
  public function cms_kategori(){
		
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
			array(
        "title"       => lang("Title"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
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
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('cms/cms-ajax/kategori-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
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
    
    $foot .= ""
      . ""
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "title : '',"
          . "note : '',"
          . "id_cms_kategori: '',"
        . "},"
        . "methods: {"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var form_data = new FormData();"
						. "form_data.append('id_cms_kategori', this.id_cms_kategori);"
						. "form_data.append('title', this.title);"
						. "form_data.append('note', this.note);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/kategori-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "{$grid['variable']}.replace_items(hasil.data, hasil.id);"
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
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
						. "var form_data = new FormData();"
						. "form_data.append('title', this.title);"
						. "form_data.append('note', this.note);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/kategori-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "this.id_cms_page = hasil.id;"
								. $this->global_format->js_grid_add($grid, "hasil.data")
							. "}"
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
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        // . "console.log(id);"
        . "$.post('".site_url("cms/cms-ajax/kategori-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.id_cms_kategori = hasil.id_cms_kategori;"
          . "formutama.note = hasil.note;"
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
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/kategori-delete")."', {id: id}, function(data){"
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
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("kategori")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("kategori")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('kategori/kategori', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "kategori",
        'title'       => lang("kategori"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
        'kategori'      => $kategori,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("kategori/kategori");
  }
	/**
   * @author Andi Wibowo
   * Type Backend
	*/
	public function page(){
		
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Gambar"),
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
        "title"       => lang("link"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
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
      "watch"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('cms/cms-ajax/page-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          // . 'console.log(hasil);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
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
    
    $foot .= ""
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
      . ""
      . ""
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "id_cms_page : '',"
          . "title : '',"
          . "file : '',"
          . "link : '',"
          . "status : '',"
          . "note : '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					. "onGambarChange(e) {"
						. "var files = e.target.files || e.dataTransfer.files;"
						. "if (!files.length)"
							. "return;"
							// . "console.log(files[0]);"
						. "this.file = files[0];"
					. "},"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var form_data = new FormData();"
						. "form_data.append('id_cms_page', this.id_cms_page);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', $('#note1').val());"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/page-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "if(hasil.status == 0){"
									. "alert('Link tidak boleh sama, Link sudah ada!!');"
									. "return false;"
								. "}"
								. "{$grid['variable']}.replace_items(hasil.data, hasil.id);"
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
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
						. "var form_data = new FormData();"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', $('#note1').val());"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/page-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "if(hasil.status == 0){"
									. "alert('Link tidak boleh sama, Link sudah ada!!');"
									. "return false;"
								. "}"
								. "this.id_cms_page = hasil.id;"
								. $this->global_format->js_grid_add($grid, "hasil.data")
							. "}"
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
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        // . "console.log(id);"
        . "$.post('".site_url("cms/cms-ajax/page-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.file = hasil.file;"
          . "formutama.link = hasil.link;"
          . "formutama.status = hasil.status;"
          . "formutama.note = hasil.note;"
          . "formutama.id_cms_page = hasil.id_cms_page;"
          . "formutama.title_file = hasil.title_file;"
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
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/page-delete")."', {id: id}, function(data){"
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
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Page")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("Page")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('page/page', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "cms/cms-master/page",
        'title'       => lang("Page"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("page/page");
  }
	/**
   * @author Andi Wibowo
   * Type Backend
	*/
	public function cms_article(){
		$this->menu = $this->cek();
		
		 # Kategori
		$kategoris = $this->db->get('cms_kategori')->result();
		foreach($kategoris as $idx=>$val){
			$kategori[$val->id_cms_kategori] = $val->title;
		}
		
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Gambar"),
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
        "title"       => lang("link"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Kategori"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Type"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
        "asc"         => false,
        "desc"        => false,
      ),
    );
		
		$header2 = array(
      array(
        "title"       => lang("Title"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Note"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Status"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
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
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
		
		$grid2 = array(
      "limit"         => 10,
      "id"            => "table-gambar",
      "search"        => "",
      "variable"      => "vm_gambar",
      "cari"          => "searchGambar",
      "onselect"      => "select_gambar();",
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
      . $this->global_format->js_grid_table(array(), $header2, $grid2)
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('cms/cms-ajax/article-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          // . 'console.log(hasil);'
//            . '$("#article-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
          . '}'
          . 'else{'
//              . '$("#article-loading").hide();'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
			
			# ---------- FUNGSI AMBIL DATA COMMENT ------------
      . "function ambil_data_comment(id){"
        . "$.post('".site_url('cms/cms-ajax/comment-get')."', {id: id}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          // . 'console.log(hasil);'
//            . '$("#article-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid2, "hasil.data[ind]")
              . "}"
            . "}"
          . '}'
          . 'else{'
//              . '$("#article-loading").hide();'
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
    
    $foot .= ""
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
      . ""
      . ""
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "id_cms_article : '',"
          . "id_cms_kategori : '',"
          . "title : '',"
          . "file : '',"
          . "link : '',"
          . "status : '',"
          . "type : '',"
          . "note : '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					. "onGambarChange(e) {"
						. "var files = e.target.files || e.dataTransfer.files;"
						. "if (!files.length)"
							. "return;"
							// . "console.log(files[0]);"
						. "this.file = files[0];"
					. "},"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var form_data = new FormData();"
						. "form_data.append('id_cms_article', this.id_cms_article);"
						. "form_data.append('id_cms_kategori', this.id_cms_kategori);"
						. "form_data.append('type', this.type);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', $('#note1').val());"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/article-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "if(hasil.status == 0){"
									. "alert('Link tidak boleh sama, Link sudah ada!!');"
									. "return false;"
								. "}"
								. "{$grid['variable']}.replace_items(hasil.data, hasil.id);"
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
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
						. "var form_data = new FormData();"
						. "form_data.append('id_cms_kategori', this.id_cms_kategori);"
						. "form_data.append('type', this.type);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', $('#note1').val());"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/article-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "if(hasil.status == 0){"
									. "alert('Link tidak boleh sama, Link sudah ada!!');"
									. "return false;"
								. "}"
								. "this.id_cms_article = hasil.id;"
								. $this->global_format->js_grid_add($grid, "hasil.data")
							. "}"
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
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        // . "console.log(id);"
        . "$.post('".site_url("cms/cms-ajax/article-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.file = hasil.file;"
          . "formutama.link = hasil.link;"
          . "formutama.status = hasil.status;"
          . "formutama.note = hasil.note;"
          . "formutama.id_cms_article = hasil.id_cms_article;"
          . "formutama.id_cms_kategori = hasil.id_cms_kategori;"
          . "formutama.type = hasil.type;"
          . "formutama.title_file = hasil.title_file;"
        . "})"
        . ".done(function(){"
				. "{$grid2['variable']}.clear();"
          . "ambil_data_comment(id,0);"
					. "$('#tab_comment').css('display', 'block');"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . ""
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/article-delete")."', {id: id}, function(data){"
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
			. "$(document).on('click', '.delete_comment', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/comment-delete")."', {id: id}, function(data){"
          . "{$grid2['variable']}.delete_items(id);"
          . "{$grid2['variable']}.cari($('#{$grid2['cari']}').val());"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . ""
				. ""
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Article")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("Article")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('article/article', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "article",
        'title'       => lang("Article"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'        => $grid2,
        'kategori'        => $kategori,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("article/article");
  }
	/**
   * @author Andi Wibowo
   * Type Backend
	*/
	public function cms_gallery(){
    # Kategori
		$kategoris = $this->db->get('cms_kategori')->result();
		foreach($kategoris as $idx=>$val){
			$kategori[$val->id_cms_kategori] = $val->title;
		}
		
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Gambar"),
        "id"          => 0,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Title"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
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
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('cms/cms-ajax/gallery-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
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
    
    $foot .= ""
      . ""
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "title : '',"
          . "file : '',"
          . "status : '',"
          . "id_cms_gallery: '',"
          . "id_cms_kategori: '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					. "onGambarChange(e) {"
						. "var files = e.target.files || e.dataTransfer.files;"
						. "if (!files.length)"
							. "return;"
							. "console.log(files[0]);"
						. "this.file = files[0];"
					. "},"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var form_data = new FormData();"
						. "form_data.append('id_cms_gallery', this.id_cms_gallery);"
						. "form_data.append('id_cms_kategori', this.id_cms_kategori);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('status', this.status);"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/gallery-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "{$grid['variable']}.replace_items(hasil.data, hasil.id);"
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
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
						. "var form_data = new FormData();"
						. "form_data.append('id_cms_kategori', this.id_cms_kategori);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('status', this.status);"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/gallery-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "this.id_cms_page = hasil.id;"
								. $this->global_format->js_grid_add($grid, "hasil.data")
							. "}"
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
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        // . "console.log(id);"
        . "$.post('".site_url("cms/cms-ajax/gallery-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.file = hasil.file;"
          . "formutama.status = hasil.status;"
          . "formutama.id_cms_gallery = hasil.id_cms_gallery;"
          . "formutama.id_cms_kategori = hasil.id_cms_kategori;"
          . "formutama.title_file = hasil.title_file;"
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
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/gallery-delete")."', {id: id}, function(data){"
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
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("gallery")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("gallery")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('gallery/gallery', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "gallery",
        'title'       => lang("gallery"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
        'kategori'      => $kategori,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("gallery/gallery");
  }
	
	public function cms_service(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Gambar"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Title"),
        "id"          => 6,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("link"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
			array(
        "title"       => lang("Urutan"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Status"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Option"),
        "id"          => 4,
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
    
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('cms/cms-ajax/service-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          // . 'console.log(hasil);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
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
    
    $foot .= ""
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "id_site_tour_slideshow : '',"
          . "title : '',"
          . "file : '',"
          . "link : '',"
          . "sort : '',"
          . "status : '',"
          . "note : '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					. "onGambarChange(e) {"
						. "var files = e.target.files || e.dataTransfer.files;"
						. "if (!files.length)"
							. "return;"
							// . "console.log(files[0]);"
						. "this.file = files[0];"
					. "},"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var form_data = new FormData();"
						. "form_data.append('id_site_tour_slideshow', this.id_site_tour_slideshow);"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('sort', this.sort);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', this.note);"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/service-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								. "{$grid['variable']}.replace_items(hasil.data, kirim.id_site_tour_slideshow);"
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
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
						. "var form_data = new FormData();"
						. "form_data.append('title', this.title);"
						. "form_data.append('file', this.file);"
						. "form_data.append('link', this.link);"
						. "form_data.append('sort', this.sort);"
						. "form_data.append('status', this.status);"
						. "form_data.append('note', this.note);"
						. "form_data.append('title_file', this.title_file);"
						. "$.ajax({"
							. "url: '".site_url("cms/cms-ajax/service-set")."',"
							. "dataType: 'text',"
							. "cache: false,"
							. "contentType: false,"
							. "processData: false,"
							. "data: form_data,"
							. "type: 'post',"
							. "async: false,"
							. "success: function(data){"
								. "var hasil = $.parseJSON(data);"
								// . "console.log(hasil);"
								. "this.id_site_tour_slideshow = hasil.id;"
								. $this->global_format->js_grid_add($grid, "hasil.data")
							. "}"
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
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        // . "console.log(id);"
        . "$.post('".site_url("cms/cms-ajax/service-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.file = hasil.file;"
          . "formutama.link = hasil.link;"
          . "formutama.sort = hasil.sort;"
          . "formutama.status = hasil.status;"
          . "formutama.note = hasil.note;"
          . "formutama.id_site_tour_slideshow = hasil.id_site_tour_slideshow;"
          . "formutama.title_file = hasil.title_file;"
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
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("cms/cms-ajax/service-delete")."', {id: id}, function(data){"
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
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("CMS Service")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("CMS Service")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('service/service', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "CMS Service",
        'title'       => lang("CMS Service"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
        'outlet'      => $outlet,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("service/service");
  }
  
	/**
   * @author Andi Wibowo
   * Type Public
	*/
	public function umum_page($id=''){
		
		# -- GET DATA --
		$this->db->select('*');
		$this->db->from('cms_page');
		$this->db->where('status',2);
		$this->db->where('link',$id);
		$result = $this->db->get()->row();
		
		$css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
			
		$foot = "<script>"
        . "</script>"
        . "";
    
    $this->template
      ->set_layout('default')
      ->build('page/main', array(
        'url'         => base_url()."themes/turin-merah/",
        'theme2nd'    => 'turin-merah',
        'foot'        => $foot,
        'css'         => $css,
        'data'         => $result,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads("first")
      ->build("page/main");
	}
	/**
   * @author Andi Wibowo
   * Type Public
	*/
	public function list_article($type=''){

		$grid = array(
			"limit"         => 100,
			"id"            => "table-utama",
			"search"        => "",
			"variable"      => "vm_utama",
			"cari"          => "searchString",
			"onselect"      => "",
			"select"        => array(),
			"select_value"  => "",
			"on_unselect"   => "",
			"unselect"      => array(),
			"unselect_value"=> "",
			"multi_select"  => false,
		);
		$header = array(
			array(
				"title"       => lang("HTML"),
				"id"          => 1,
				"asc"         => false,
				"desc"        => false,
			),
			array(
				"title"       => lang("Harga"),
				"id"          => 2,
				"asc"         => false,
				"desc"        => false,
			),
		);
		
		$css = ""
			. "<style>"
			 // . $this->global_format->css_grid()
			. "</style>";
		
		$foot .= ""
			. $this->global_format->framework()
			. '<script type="text/javascript">'
			. "";
		
		$foot .= ""
			. "{$this->global_format->js_grid_table2(array(), $header, $grid)}"
			. "$(document).on('click', '#load-more', function(evt){"
					. "var akhir = $('#akhir-data').val() * 1;"
					. "tour_get(akhir);"
				. "});"
			. "function tour_get(start){"
				. "var type = '{$type}';"
				. "$.post('".site_url('cms/cms-ajax/artikel-public-get')."', {start:start, type:type}, function(data){"
					. "var hasil = $.parseJSON(data);"
					. "if(hasil.status == 2){"
						. "if(hasil.data){"
						// . "console.log(hasil);"
							. "for(ind = 0; ind < hasil.data.length; ++ind){"
								. $this->global_format->js_grid_add($grid, "hasil.data[ind]")
								. "{$grid['variable']}.sort_data_always_asc(1);"
							. "}"
							. "{$grid['variable']}.page.ga = hasil.isi;"
							. "var akhir = $('#akhir-data').val() * 1;"
							. "$('#akhir-data').val((akhir + 10));"
						. "}"
					. "}"
					. "else{"
					. "}"
				. "})"
				. ".fail(function(){"
					. "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
				. "})"
				. ".always(function(){"
					. "$('.progress-bar').css('width', '100%');"
					. "$('.progress-bar-percent').html('(100%)');"
				. "});"
			. "}"

		 . "tour_get(0);"
			. "$(document).on('click', '#urutharga', function(evt){"
				. "{$grid['variable']}.sort_data(1);"
				. "{$grid['variable']}.select(1);"
			. "});"
			. "$(document).on('click', '#urutdurasi', function(evt){"
				. "{$grid['variable']}.sort_data(2);"
				. "{$grid['variable']}.select(1);"
			. "});"
			. "$(document).on('change', '.departure', function(evt){"
				. "var kode = $(this).attr('isi');"
				. "var nilai = $(this).val();"
				. "console.log(kode);"
				. "console.log(nilai);"
				. "$('#'+kode).attr('action', '".site_url("site/book-detail")."/'+nilai);"
			. "});"
			. ""
			. ""
			. "";
			
		$foot .= "</script>";
		
		# ---------- TITLE -------
		$title = 'NEWS & OTHER';
		if($type == 1){
			$title = "NEWS";
		}elseif($type == 2){
			$title = "PROMO";
		}elseif($type == 3){
			$title = "TESTIMONIAL";
		}
		
		$this->template
			->set_layout('default')
			->build('article/list', array(
				'url'         => base_url()."themes/turin/",
				'theme2nd'    => 'turin',
				'foot'        => $foot,
				'css'         => $css,
				'rute'        => $rute,
				'region'      => $region,
				'tgl'         => $tgl,
				'title'         => $title,
				
				'grid'        => $grid,
			));
		$this->template
			->set_layout('default')
			->build("article/list");
		
	}
	/**
   * @author Andi Wibowo
   * Type Public
	*/
	public function article($id=''){
		# -- GET DATA --
		$this->db->select('*');
		$this->db->from('cms_article');
		$this->db->where('status',2);
		$this->db->where('link',$id);
		$result = $this->db->get()->row();
		
		# -- GET DATA COMMENT --
		$this->db->select('cms_comment.*, m_users.name USER');
		$this->db->from('cms_comment');
		$this->db->join('m_users','m_users.id_users = cms_comment.create_by_users','LEFT');
		$this->db->where('cms_comment.status',2);
		$this->db->where('id_cms_article',$result->id_cms_article);
		$this->db->order_by('create_date','ASC');
		$comment = $this->db->get()->result();
		
		$css = ""
			. "<style>"
				. ".body{"
					. "padding-top: inherit !important;"
				. "}"
			. "</style>"
			. "";
		
		$foot .= "<script type='text/javascript'>"
						. "$(document).ready(function(){"
							. "$('#btn-comment').click(function(){"
									. "var form_data = new FormData();"
									. "form_data.append('id_cms_article', $('#id_cms_article').val());"
									. "form_data.append('comment', $('#comment').val());"
									. "$.ajax({"
										. "url: '".site_url("cms/cms-ajax/comment-set")."',"
										. "dataType: 'text',"
										. "cache: false,"
										. "contentType: false,"
										. "processData: false,"
										. "data: form_data,"
										. "type: 'post',"
										. "async: false,"
										. "success: function(data){"
											. "var hasil = $.parseJSON(data);"
											. "if(hasil.status == 2){"
												. "alert('Komentar Berhasil Ditambahkan.');"
												. "window.location.replace(window.location.href);"
											. "}else{"
												. "alert('Login terlebih dahulu untuk Menambahkan Komentar.');"
												. "window.location.replace('".site_url('login')."');"
											. "}"
										. "}"
									. "})"
							. "});"
						. "});"
				. "</script>"
				. "";
		
		$this->template
			->set_layout('default')
			->build('article/main', array(
				'url'         => base_url()."themes/turin/",
				'theme2nd'    => 'turin',
				'foot'        => $foot,
				'css'         => $css,
				'data'         => $result,
				'comment'         => $comment,
				
			));
		$this->template
			->set_layout('default')
			->build("article/main");
	}	
	/**
   * @author Andi Wibowo
   * Type Public
	*/
	public function gallery($kategori = ''){
		
		# -- GET DATA --
		$this->db->select('cms_gallery.*, cms_kategori.title kategori');
		$this->db->from('cms_gallery');
		$this->db->join('cms_kategori','cms_kategori.id_cms_kategori = cms_gallery.id_cms_kategori','INNER');
		$this->db->where('cms_gallery.status',2);
		$this->db->like('cms_kategori.title', $kategori);
		$result = $this->db->get()->result();
		
		$this->db->select('cms_gallery.*, cms_kategori.title kategori');
		$this->db->from('cms_gallery');
		$this->db->join('cms_kategori','cms_kategori.id_cms_kategori = cms_gallery.id_cms_kategori','INNER');
		$this->db->where('cms_gallery.status',2);
		$this->db->like('cms_kategori.title', $kategori);
		$this->db->group_by('cms_kategori.title');
		$result_kategori = $this->db->get()->result();

		
		$css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
		
		$foot .= '<link href="'.site_url().'themes/antavaya/assets/vendor/magnific-popup/magnific-popup.css" media="all" rel="stylesheet" type="text/css">';
    $foot .= '<script src="'.site_url().'themes/antavaya/assets/vendor/magnific-popup/jquery.magnific-popup.min.js" type="text/javascript"></script>';
		$foot .= "<script type='text/javascript'>"
        . "$('.popup-link').magnificPopup({
							type: 'image',
							// other options
							
							mainClass: 'mfp-with-zoom', // this class is for CSS animation below

							zoom: {
								enabled: true, // By default it's false, so don't forget to enable it

								duration: 300, // duration of the effect, in milliseconds
								easing: 'ease-in-out', // CSS transition easing function


								opener: function(openerElement) {
									return openerElement.is('img') ? openerElement : openerElement.find('img');
								}
							},
							gallery: {
								// options for gallery
								enabled: true
							}
						});
						// $('.filter').hide('3000');
						$('.filter-button').click(function(){
									var value = $(this).attr('data-filter');
									console.log(value);
									if(value == 'all')
									{
											//$('.filter').removeClass('hidden');
											$('.filter').show('1000');
									}
									else
									{
											$('.filter').not('.'+value).hide('3000');
											$('.filter').filter('.'+value).show('3000');
											
									}
							});
							
							if ($('.filter-button').removeClass('active')) {
							$(this).removeClass('active');
							}
							$(this).addClass('active');
						
						"
        . "</script>"
        . "";
		
    $this->template
      ->set_layout('default')
      ->build('gallery/main', array(
        'url'         => base_url()."themes/turin/",
				'theme2nd'    => 'turin',
        'foot'        => $foot,
        'css'         => $css,
        'data'        => $result,
        'kategori'        => $result_kategori,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("gallery/main");
	}
  
  public function banner_promo(){
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Picture", "Title", "Code", "Start Date", "End Date", "Status", "Option"));
    
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
      . $this->global_format->standart_get("ambil_data", site_url('cms/cms-ajax/banner-promo-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . $this->global_format->standart_component()
      . "";
    
    $this->load->model("cms/js/j_cms_master");
    
    $foot .= ""
      . $this->j_cms_master->banner_promo_form($grid)
      . $this->j_cms_master->banner_promo_select_utama()
      . $this->j_cms_master->banner_promo_delete($grid)
      . $this->j_cms_master->banner_promo_active($grid)
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Banner Promo")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'>".lang("Banner Promo")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/banner-promo/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "cms/cms-master/banner-promo",
        'title'       => lang("Banner Promo"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/banner-promo/main");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */