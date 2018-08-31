<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Haji extends MX_Controller {
    
  function __construct() {      
    
  }
  
  function ajax_book_haji(){
    $pst = $this->input->post();
    if($pst['email'] AND $pst['id_website_haji']){
      $haji = $this->global_models->get("website_haji", array("id_website_haji" => $pst['id_website_haji']));
      $kirim = array(
        "id_website_haji"           => $pst['id_website_haji'],
        "name"                      => $pst['name'],
        "email"                     => $pst['email'],
        "telp"                      => $pst['telp'],
        "note"                      => $pst['note'],
        "status"                    => 1,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $id_website_haji_book = $this->global_models->insert("website_haji_book", $kirim);

      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('info@antaumroh.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Product Umrah {$haji[0]->title} ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Dear Umrah Admin <br />"
        . "Mohon informasi lebih detail untuk product Umrah <a href='".site_url("haji/detail/{$haji[0]->nicename}")."'>{$haji[0]->title}</a><br />"
        . "Kepada <br />"
        . "Nama : {$pst['name']}<br />"
        . "Email : {$pst['email']}<br />"
        . "Telp : {$pst['telp']}<br />"
        . "Desc <br />"
        . "{$pst['note']} <br />"
        . "Terima Kasih"
        . "");  
  //die;
      $this->email->send();
      print 'ok';
    }
    else{
      print 'ko';
    }
    die;
  }

	public function book_detail($id,$id_sc){
		$foot = "<script>"
				. "$(document).on('click', '#change-schedule', function(evt){"
					. "var tr = $(this).val();"
					. "if(tr != '2'){"
						. "window.location = '".site_url("haji/detail")."/'+tr;"
					. "}"
				. "});"
			. "</script>";
		

		
		$this->template->build("detail-book", 
			array(
				'url'             => base_url()."themes/holiday/",
				'files'           => base_url()."files/",
				'theme2nd'        => 'holiday',
				'title'           => "Umroh",
				'foot'            => $foot,
				'id'            => $id,
				'id_sc'            => $id_sc,
			));
		$this->template
			->set_layout('default')
			->build("detail-book");
	}
	
	public function book($id_website_haji, $id_sc){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('first_name', 'First Nama', 'required');
		$this->form_validation->set_rules('last_name', 'Last Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('no_telp', 'Telp', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');

		if ($this->form_validation->run() == TRUE){
			# --- GET DATA PRODUCT -
			$data_post = array(
				"users"               => USERSSERVER,
				"password"            => PASSSERVER,
				"code"                => $id_sc,
			);
			$data = $this->global_fungsi->curl_mentah($data_post, site_url()."crmumroh/api/get_master_umroh");
			$data_array = json_decode($data);
			$haji = $data_array->data;
			
			$pst = $this->input->post();
			$this->global_models->generate_id($id_site_umroh_book, "site_umroh_book");
			$this->global_models->generate_id($code, "site_umroh_book","code");
			$kirim = array(
				"id_site_umroh_book"       => $id_site_umroh_book,
				"id_site_umroh_products_schedules"   => $id_sc,
				"id_crm_customer"   => $pst['id_crm_customer'],
				"code"                     	 			  => $code,
				"first_name"                       => $pst['first_name'],
				"last_name"                       => $pst['last_name'],
				"email"                 		     => $pst['email'],
				"no_telp"                       => $pst['no_telp'],
				"address"                       => $pst['address'],
				"note"                       => $pst['note'],
				"status"                       => 1,
				"create_by_users"             => $this->session->userdata("id"),
				"create_date"                 => date("Y-m-d H:i:s")
			);
			$this->global_models->insert("site_umroh_book", $kirim);

			$this->load->library('email');
			$this->email->initialize($this->global_models->email_conf());

			$this->email->from($pst['email'], $pst['name']);
			$this->email->to('info@antaumroh.com'); 
			$this->email->cc('nugroho.budi@antavaya.com');

			$this->email->subject("Inquiry Product Umrah {$haji[0]->title} ".date("Y-m-d H:i:s"));
			$this->email->message(""
				. "Dear Umrah Admin <br />"
				. "Mohon informasi lebih detail untuk product Umrah <a href='".site_url("haji/detail/{$id_sc}")."'>{$haji[0]->title}</a><br />"
				. "Kepada <br />"
				. "Nama : {$pst['first_name']} {$pst['last_name']}<br />"
				. "Email : {$pst['email']}<br />"
				. "Telp : {$pst['no_telp']}<br />"
				. "Desc <br />"
				. "{$pst['note']} <br />"
				. "Terima Kasih"
				. "");  
	//die;
			if($this->email->send()){
				$this->session->set_flashdata('success', 'Terima Kasih. Permintaan anda akan di proses melalui email');
			}
			else{
				$this->session->set_flashdata('notice', 'Maaf. Permintaan anda sukses, hanya email tidak terkirim ke mail anda.');
				// show_error($this->email->print_debugger());
			}
			redirect("haji/detail/{$id_sc}");
		}else{
			$this->book_detail($id_website_haji, $id_sc);
		}
	}
	
  public function detail($nicename){
		$foot = "<script>"
				. "$(document).on('click', '#change-schedule', function(evt){"
					. "var tr = $(this).val();"
					. "if(tr != '2'){"
						. "window.location = '".site_url("haji/detail")."/'+tr;"
					. "}"
				. "});"
				. ""
				. "
						// GALLERY CAROUSEL
						$('#myCarousel').carousel({
                interval: 5000
							});
			 
							$('[id^=carousel-selector-]').click(function () {
							var id_selector = $(this).attr('id');
							try {
									var id = /-(\d+)$/.exec(id_selector)[1];
									console.log(id_selector, id);
									jQuery('#myCarousel').carousel(parseInt(id));
							} catch (e) {
									console.log('Regex failed!', e);
							}
					});
							$('#myCarousel').on('slid.bs.carousel', function (e) {
											 var id = $('.item.active').data('slide-number');
											$('#carousel-text').html($('#slide-content-'+id).html());
							});"
        . ""
				. ""
			. "</script>";
		
		# --- GET DATA PRODUCT -
		$data_post = array(
			"users"               => USERSSERVER,
			"password"            => PASSSERVER,
			"code"                => $nicename,
		);
		$data = $this->global_fungsi->curl_mentah($data_post, site_url()."crmumroh/api/get_master_umroh");
		$data_array = json_decode($data);
		
		# --- GET DATA PRODUCT SCHEDULES -
		$other_post = array(
			"users"               => USERSSERVER,
			"password"            => PASSSERVER,
			"id_site_umroh_products"     => $data_array->data[0]->id_site_umroh_products,
			"limit"               => 3,
			"start"               => 0,
			"where"               => "AND A.tanggal > '{$data_array->data[0]->tanggal}'"
		);
		$other = $this->global_fungsi->curl_mentah($other_post, site_url()."crmumroh/api/get_master_umroh_schedule");
		$other_array = json_decode($other);
		
		$tanggal[2] = "- Pilih -";
		foreach($other_array->schedule AS $sch){
			$tanggal[$sch->id_site_umroh_products_schedules] = date("d F Y", strtotime($sch->tanggal));
		}
		
		# --- GET DATA PRODUCT PICTURES -
		$picture_post = array(
			"users"               => USERSSERVER,
			"password"            => PASSSERVER,
			"id_site_umroh_products"  => $data_array->data[0]->id_site_umroh_products,
			"limit"               => 10,
			"start"               => 0,
		);
		$picture = $this->global_fungsi->curl_mentah($picture_post, site_url()."crmumroh/api/get_master_umroh_pictures");
		$picture_array = json_decode($picture);
		
		$this->template->build("detail", 
			array(
				'url'             => base_url()."themes/holiday/",
				'files'           => base_url()."files/",
				'theme2nd'        => 'holiday',
				'title'           => "Umroh",
				'haji'            => $data_array->data,
				'schedule'        => $other_array->data,
				'pictures'        => $picture_array->data,
				'tanggal'         => $tanggal,
				'foot'            => $foot,
				'id'            => $data_array->data[0]->id_site_umroh_products,
				'id_sc'            => $nicename,
			));
		$this->template
			->set_layout('default')
			->build("detail");
  }
	
	public function detail2($nicename){
    $this->load->library('form_validation');

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('telp', 'Telp', 'required');

		if ($this->form_validation->run() == FALSE){
      $foot = "<script>"
          . "$(document).on('click', '#change-schedule', function(evt){"
            . "var tr = $(this).val();"
            . "if(tr != '2'){"
              . "window.location = '".site_url("haji/detail")."/'+tr;"
            . "}"
          . "});"
        . "</script>";
      
			$data_post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "code"                => $nicename,
      );
      $data = $this->global_fungsi->curl_mentah($data_post, URLSERVER."json/json-umroh/get-master-umroh-web");
      $data_array = json_decode($data);
      
			$other_post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_umroh_master"     => $data_array->data[0]->id_umroh_master,
        "limit"               => 3,
        "start"               => 0,
        "where"               => "AND A.depart > '{$data_array->data[0]->depart}'"
      );
      $other = $this->global_fungsi->curl_mentah($other_post, URLSERVER."json/json-umroh/get-master-umroh-schedule");
      $other_array = json_decode($other);
      
//      $this->debug($other_array);
//      $this->debug($data_array, true);
      
      $tanggal[2] = "- Pilih -";
      foreach($other_array->schedule AS $sch){
        $tanggal[$sch->kode] = date("d F Y", strtotime($sch->depart));
      }
      
      $this->template->build("detail_", 
        array(
          'url'             => base_url()."themes/travelia/",
          'files'           => base_url()."files/",
          'theme2nd'        => 'travelia',
          'title'           => "Umroh",
          'haji'            => $data_array->data,
          'schedule'        => $other_array->data,
          'tanggal'         => $tanggal,
          'foot'            => $foot,
        ));
      $this->template
        ->set_layout('default')
        ->build("detail_");
		}
		else{
			$haji = $this->global_models->get("website_haji", array("nicename" => $nicename));
			
//      $this->debug($haji, true);
      $pst = $this->input->post();
      $kirim = array(
        "id_website_haji"           => $haji[0]->id_website_haji,
        "name"                      => $pst['nama'],
        "email"                     => $pst['email'],
        "telp"                      => $pst['telp'],
        "note"                      => $pst['note'],
        "status"                    => 1,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $id_website_haji_book = $this->global_models->insert("website_haji_book", $kirim);

      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('info@antaumroh.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Product Umrah {$haji[0]->title} ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Dear Umrah Admin <br />"
        . "Mohon informasi lebih detail untuk product Umrah <a href='".site_url("haji/detail/{$haji[0]->nicename}")."'>{$haji[0]->title}</a><br />"
        . "Kepada <br />"
        . "Nama : {$pst['name']}<br />"
        . "Email : {$pst['email']}<br />"
        . "Telp : {$pst['telp']}<br />"
        . "Desc <br />"
        . "{$pst['note']} <br />"
        . "Terima Kasih"
        . "");  
  //die;
      if($this->email->send()){
        $this->session->set_flashdata('success', 'Terima Kasih. Permintaan anda akan di proses melalui email');
      }
      else{
        $this->session->set_flashdata('notice', 'Maaf. Permintaan anda gagal');
      }
      redirect("haji/detail/{$nicename}");
		}
  }
  
  function load_more(){
    $pst = $this->input->post();
    $data_post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "limit"               => 4,
      "kategori"            => $pst['kategori'],
    );
    $data = $this->global_fungsi->curl_mentah($data_post, URLSERVER."json/json-umroh/get-master-umroh-web");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    foreach ($data_array->data AS $ky => $umr){
      $key = $ky + $pst['start'];
      $tanggal = array();
      $harga = "";
      foreach($data_array->schedule[$ky] AS $r => $sh){
        $tanggal[$sh->kode] = date("d F Y", strtotime($sh->depart));
        $style = ($r == 0 ? "style='display: block'": "style='display: none'");
        $harga .= "<p {$style} id='harga-{$key}-{$sh->kode}' class='view-harga-{$key}'><i>Start From </i>IDR ".number_format($sh->double)."</p>";
      }
      print ""
        . "<div class='col-md-12'>"
          . "<div class='img-hover'>"
            . "<img src='{$umr->thumb}' alt='' class='img-responsive' style='max-width: 308px; max-height: 196px'>"
            . "<div class='overlay'>"
              . "<a href='".site_url("haji/detail/{$umr->kode}")."' class='fancybox'>"
                . "<i class='fa fa-plus-circle'></i>"
              . "</a>"
            . "</div>"
          . "</div>"
          . "<div class='info-gallery'>"
            . "<h3>{$umr->title} <small>{$umr->sub_title}</small></h3>"
            . "<hr class='separator'>"
            . "{$harga}"
            . "<p>Departure: ".$this->form_eksternal->form_dropdown("sch", $tanggal, array(), "isi='{$key}' id='change-schedule-{$key}' class='input schedule'")."</p>"
            . "<div class='content-btn'>"
              . "<a href='javascript:void(0)' isi='{$key}' class='btn btn-primary details'>View Details</a>"
            . "</div>"
          . "</div>"
        . "</div>";
    }
    die;
  }
	
	
	public function index(){
    $pst = $this->input->get();
    
//    $this->debug(json_encode($data), true);
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
        "title"       => lang(""),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      )
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
          . "umroh_get(akhir);"
        . "});"
      . "function umroh_get(start){"
        . "$.post('".site_url('siteumroh/umroh-ajax/umroh-get')."', {start:start, category:'UMR,UMP'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                . "{$grid['variable']}.sort_data_always_asc(0);"
              . "}"
              . "{$grid['variable']}.page.ga = hasil.isi;"
              . "$('#akhir-data').val((hasil.start + 0));"
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

     . "umroh_get(0);"
      . "$(document).on('click', '#urutharga', function(evt){"
        . "{$grid['variable']}.sort_data(1);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutdurasi', function(evt){"
        . "{$grid['variable']}.sort_data(2);"
        . "{$grid['variable']}.select(1);"
      . "});"
			. "$(document).on('change', '.schedule', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $(this).val();"
          . "$('.view-harga-'+isi).hide();"
          . "$('#harga-'+isi+'-'+kode).show();"
					. "$('.view-maskapai-'+isi).hide();"
          . "$('#maskapai-'+isi+'-'+kode).show();"
					. "$('.view-ustad-'+isi).hide();"
          . "$('#ustad-'+isi+'-'+kode).show();"
        . "});"
        . "$(document).on('click', '.details', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/detail")."/'+kode;"
        . "});"
				. "$(document).on('click', '.detail_books', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/book-detail")."/'+isi+'/'+kode;"
        . "});"
      . ""
      . ""
      . "";
      
    $foot .= "</script>";
			
		$this->template
      ->set_layout('default')
      ->build('main', array(
        'url'         => base_url()."themes/holiday/",
				'files'           => base_url()."files/",
        'theme2nd'    => 'holiday',
				'title'           => "Umroh",
        'foot'        => $foot,
        'css'         => $css,
        'rute'        => $rute,
        'region'      => $region,
        'tgl'         => $tgl,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
	
	public function index2(){
    $data_post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => 0,
      "limit"               => 4,
      "kategori"            => '1,2',
    );
    $data = $this->global_fungsi->curl_mentah($data_post, URLSERVER."json/json-umroh/get-master-umroh-web");
    $data_array = json_decode($data);
//    $this->debug($data_array->schedule, true);
    
    $foot = "<script>"
        . "$(document).on('change', '.schedule', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $(this).val();"
          . "$('.view-harga-'+isi).hide();"
          . "$('#harga-'+isi+'-'+kode).show();"
        . "});"
        . "$(document).on('click', '.details', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/detail")."/'+kode;"
        . "});"
        . "$(document).on('click', '#act-load-more', function(evt){"
          . "var batas = $('#batas-page').val() * 1;"
          . "$.post('".site_url("haji/load-more")."',{start: batas, kategori: '1,2'}, function(data){"
            . "$('#load-more').append(data);"
            . "$('#batas-page').val((batas + 4))"
          . "});"
        . "});"
      . "</script>";
    $this->template->build("main_", 
      array(
        'url'             => base_url()."themes/travelia/",
        'files'           => base_url()."files/",
        'theme2nd'        => 'travelia',
        'title'           => "Umroh",
        'umroh'           => $data_array->data,
        'sc'              => $data_array->schedule,
        'foot'            => $foot,
      ));
    $this->template
      ->set_layout('default')
      ->build("main_");
  }
 
	public function wisata(){
    $pst = $this->input->get();
    
//    $this->debug(json_encode($data), true);
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
        "title"       => lang(""),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      )
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
          . "umroh_get(akhir);"
        . "});"
      . "function umroh_get(start){"
        . "$.post('".site_url('siteumroh/umroh-ajax/umroh-get')."', {start:start,category:'WHK'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
            // . "console.log(hasil);"
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                . "{$grid['variable']}.sort_data_always_asc(0);"
              . "}"
              . "{$grid['variable']}.page.ga = hasil.isi;"
              . "$('#akhir-data').val((hasil.start + 4));"
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

     . "umroh_get(0);"
      . "$(document).on('click', '#urutharga', function(evt){"
        . "{$grid['variable']}.sort_data(1);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutdurasi', function(evt){"
        . "{$grid['variable']}.sort_data(2);"
        . "{$grid['variable']}.select(1);"
      . "});"
			. "$(document).on('change', '.schedule', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $(this).val();"
          . "$('.view-harga-'+isi).hide();"
          . "$('#harga-'+isi+'-'+kode).show();"
        . "});"
        . "$(document).on('click', '.details', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/detail")."/'+kode;"
        . "});"
				. "$(document).on('click', '.detail_books', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/book-detail")."/'+isi+'/'+kode;"
        . "});"
      . ""
      . ""
      . "";
      
    $foot .= "</script>";
			
		$this->template
      ->set_layout('default')
      ->build('wisata', array(
        'url'         => base_url()."themes/holiday/",
				'files'           => base_url()."files/",
        'theme2nd'    => 'holiday',
				'title'           => "Umroh",
        'foot'        => $foot,
        'css'         => $css,
        'rute'        => $rute,
        'region'      => $region,
        'tgl'         => $tgl,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->build("wisata");
  }
	
  public function wisata2(){
    $data_post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => 0,
      "limit"               => 4,
      "kategori"            => '3',
    );
    $data = $this->global_fungsi->curl_mentah($data_post, URLSERVER."json/json-umroh/get-master-umroh-web");
    $data_array = json_decode($data);
//    $this->debug($data_array->schedule, true);
    
    $foot = "<script>"
        . "$(document).on('change', '.schedule', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $(this).val();"
          . "$('.view-harga-'+isi).hide();"
          . "$('#harga-'+isi+'-'+kode).show();"
        . "});"
        . "$(document).on('click', '.details', function(evt){"
          . "var isi = $(this).attr('isi');"
          . "var kode = $('#change-schedule-'+isi).val();"
          . "window.location = '".site_url("haji/detail")."/'+kode;"
        . "});"
        . "$(document).on('click', '#act-load-more', function(evt){"
          . "var batas = $('#batas-page').val() * 1;"
          . "$.post('".site_url("haji/load-more")."',{start: batas, kategori: 3}, function(data){"
            . "$('#load-more').append(data);"
            . "$('#batas-page').val((batas + 4))"
          . "});"
        . "});"
      . "</script>";
    $this->template->build("wisata", 
      array(
        'url'             => base_url()."themes/travelia/",
        'files'           => base_url()."files/",
        'theme2nd'        => 'travelia',
        'title'           => "Umroh",
        'umroh'           => $data_array->data,
        'sc'              => $data_array->schedule,
        'foot'            => $foot,
      ));
    $this->template
      ->set_layout('default')
      ->build("wisata");
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */