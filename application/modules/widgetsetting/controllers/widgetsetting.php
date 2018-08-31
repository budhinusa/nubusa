<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetsetting extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    // $this->load->model('scmoutlet/m_scmoutlet');
  }
  
  public function index(){
    // $this->m_scmoutlet->cek_session_outlet();
    
    // $outlet = $this->global_models->get_dropdown("scm_outlet", "id_scm_outlet", "title", FALSE, array("id_scm_outlet <>" => $this->session->userdata("scm_outlet")));
		
		$widgets_new = array();
		$widgets = $this->global_models->get_query("SELECT A.*,"
      . " (SELECT b.title from m_widget_file AS b where b.id_m_widget = A.id_m_widget LIMIT 0,1) AS title_file"
      . " FROM m_widget AS A"
			. " ORDER BY A.create_date DESC"
      . " ");
		foreach($widgets as $idx=>$val){
			$widgets_new[$idx]->id_m_widget = $val->id_m_widget;
			$widgets_new[$idx]->title = $val->title;
			$widgets_new[$idx]->link = $val->link;
			if(!empty($val->title_file))
					$image = $val->title_file;
			else
					$image = 'no-image.jpg';
			$widgets_new[$idx]->title_file = site_url('files/widget/'.$image);
			$widgets_new[$idx]->class = "id_m_widget_" . $idx;
		}
		
		$j_widget = json_encode($widgets_new);
		
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
        . "input[type='checkbox'] {
						width:25px;
						height:25px;
						background:white;
						border-radius:5px;
						border:2px solid #555;
				}"
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
        "title"       => lang("Nama"),
        "id"          => 1,
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
        "title"       => lang("Status"),
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
    
//    $this->debug($this->global_format->js_grid_table(array(), $header2, $grid2), true);
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
			# ---------- FUNGSI AMBIL DATA AWAL ------------
      . "function ambil_data(mulai){"
        . "$.post('".site_url('widgetsetting/widgetsetting-ajax/users-get')."', {start: mulai}, function(data){"
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
      . "var formutama = new Vue({"
        . "el: '#tab_1',"
        . "data: {"
          . "widgets : {$j_widget},"
          . "id_widgets : [],"
					. "id_users : '',"
          . "link : '',"
          . "email : '',"
          . "title_file: ''"
        . "},"
        . "methods: {"
					# ---------- FUNGSI UPDATE ------------
          . "update: function(){"
            . "var kirim = {"
              . "id_widgets: this.id_widgets,"
              . "id_users: this.id_users,"
            . "};"
            . "console.log(kirim);"
            . "$.post('".site_url("widgetsetting/widgetsetting-ajax/widgetsetting-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              // . "{$grid['variable']}.replace_items(hasil.data, kirim.id_m_widget);"
              // . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
              // . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
							. "location.reload();"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
					. "merge: function(data){"
						. "if (!confirm('are you sure?')) {"
								. "event.preventDefault();"
							. "} else {"
								. "if(event.target.checked == true){"
									. "formutama.id_widgets.push(data);"
								. "}"
								. "if(event.target.checked == false){"
									. "removeA(formutama.id_widgets, data);"
								. "}"
							. "}"
							. "console.log(formutama.id_widgets);"
					. "}"
        . "}"
      . "});"
      . ""
			# ------------  SELECT ROW UTAMA ---------
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
				// . "console.log(id);"
        . "$.post('".site_url("widgetsetting/widgetsetting-ajax/widgetsetting-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          // . "console.log(hasil);"
          . "formutama.id_users = hasil.id_users;"
          . "formutama.widgets = hasil.widgets;"
          . "formutama.id_widgets = hasil.id_widgets_val;"
					. "$('#tab_files').css('display', 'block');"
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
				# --- FUNGSI REMOVE ARRAY ---
      . "function removeA(arr) {
						var what, a = arguments, L = a.length, ax;
						while (L > 1 && arr.length) {
								what = a[--L];
								while ((ax= arr.indexOf(what)) !== -1) {
										arr.splice(ax, 1);
								}
						}
						return arr;
				}"
      . ""
			# ------------  DELETE ---------
			. "$(document).on('click', '.delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("widgetsetting/widgetsetting-ajax/widgetsetting-delete")."', {id: id}, function(data){"
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
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Widget Setting")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("Widget Setting")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('Widgetsetting', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "Widgetsetting",
        'title'       => lang("Widget Setting"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
        'widgets'      => $widgets,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("Widgetsetting");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */