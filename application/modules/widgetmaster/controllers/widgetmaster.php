<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetmaster extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    // $this->load->model('scmoutlet/m_scmoutlet');
  }
  
  public function index(){
    // $this->m_scmoutlet->cek_session_outlet();
    
    // $outlet = $this->global_models->get_dropdown("scm_outlet", "id_scm_outlet", "title", FALSE, array("id_scm_outlet <>" => $this->session->userdata("scm_outlet")));
    
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
    
    $header2 = array(
      array(
        "title"       => lang("Date"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("File"),
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
        . "$.post('".site_url('widgetmaster/widgetmaster-ajax/widgetmaster-get')."', {start: mulai}, function(data){"
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
      
      . "function ambil_data_file(id_m_widget,mulai){"
        . "$.post('".site_url('widgetmaster/widgetmaster-ajax/widgetmaster-file-get')."', {start: mulai, id_m_widget: id_m_widget}, function(data){"
          . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid2, "hasil.data[ind]")
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
          . "title : '',"
          . "link : '',"
          . "note : '',"
          . "id_m_widget: '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var kirim = {"
              . "title: this.title,"
              . "link: this.link,"
              . "note: this.note,"
              . "id_m_widget: this.id_m_widget,"
              . "title_file: this.title_file"
            . "};"
            . "$.post('".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "{$grid['variable']}.replace_items(hasil.data, kirim.id_m_widget);"
              . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
					# ---------- FUNGSI INSERT ------------
          . "add_new: function(){"
            . "var kirim = {"
              . "title: this.title,"
							. "link: this.link,"
              . "note: this.note,"
            . "};"
            . "$.post('".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "this.id_m_widget = hasil.id;"
              . $this->global_format->js_grid_add($grid, "hasil.data")
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
        . "$.post('".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.title = hasil.title;"
          . "formutama.link = hasil.link;"
          . "formutama.note = hasil.note;"
          . "formutama.id_m_widget = hasil.id_m_widget;"
          . "formutama.title_file = hasil.title_file;"
        . "})"
        . ".done(function(){"
          . "{$grid2['variable']}.clear();"
          . "ambil_data_file(id,0);"
					. "$('#tab_files').css('display', 'block');"
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
        . "$.post('".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-delete")."', {id: id}, function(data){"
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
			# ------------  DELETE FILE ---------
      . "$(document).on('click', '.delete-file', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-file-delete")."', {id: id}, function(data){"
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
			# ------------  UPLOAD FILE  ---------
			. "$('#tempat-upload').on('dragover',function(e) {"
          . "e.preventDefault();"
          . "e.stopPropagation();"
        . "});"
        . "$('#tempat-upload').on('dragenter',function(e) {"
          . "e.preventDefault();"
          . "e.stopPropagation();"
        . "});"
        . "$('#tempat-upload').on('drop',function(e){"
          . "if(e.originalEvent.dataTransfer){"
            . "if(e.originalEvent.dataTransfer.files.length) {"
              . "e.preventDefault();"
              . "e.stopPropagation();"
              . "upload(e.originalEvent.dataTransfer.files);"
            . "}"
          . "}"
        . "});"
				. "function upload(files){"
          . "var form_data = new FormData();"
          . "form_data.append('file', files[0]);"
          . "form_data.append('id_m_widget', $('#id-m-widget').val());"
          . "$('#loading-form-picture').show();"
              
          . "var upload = $.ajax({"
            . "url: '".site_url("widgetmaster/widgetmaster-ajax/widgetmaster-file-upload")."',"
            . "dataType: 'text',"
            . "cache: false,"
            . "contentType: false,"
            . "processData: false,"
            . "data: form_data,"
            . "type: 'post',"
            . "async: false,"
            . "success: function(data){"
              . "return 'nbs';"
            . "}"
          . "}).responseText;"
        
          . "$('#loading-form-picture').hide();"
              
          . "var gambar = 'nbs';"
          . "if(upload){"
            . "var gambar = $.parseJSON(upload);"
          . "}"

          . "if(gambar != 'nbs'){"
          // . "console.log(gambar.data);"
						. $this->global_format->js_grid_add($grid2, "gambar.data")
          . "}"
          . "else{"
            . "alert('Fail');"
          . "}"
              
        . "}"
        
        . "$(document).on('click', '#tempat-upload', function(){"
          . "$('#file-manual').click();"
          . "$(document).on('change', '#file-manual', function(){ "
            . "var files = $('#file-manual').prop('files');"
            . "upload(files);"
          . "});"
        . "});"
				. ""
				// . "CKEDITOR.replace('note');"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Widget Master")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("Widget Master")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('Widgetmaster', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "Widgetmaster",
        'title'       => lang("Widget Master"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
        'outlet'      => $outlet,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("Widgetmaster");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */