<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_siklus extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->library('frm/lokal_variable');
  }
  
  function transaksi($id_frm_journal_period){
    if($id_frm_journal_period){
      $this->session->set_userdata(array(
        "frm_journal_period" => $id_frm_journal_period
      ));
    }
    else{
      if(!$this->session->userdata("frm_journal_period")){
        redirect("frm/frm-master/period");
      }
      else{
        $id_frm_journal_period = $this->session->userdata("frm_journal_period");
      }
    }
    
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css'>"
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".journal{"
          . "background-color: #c0c0c0 !important;"
          . "font-weight: bold;"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
      
    
    $header = $this->global_format->standart_head(array("Date", "Account", "Ref", "Debit", "Credit"));
    $header_detail = $this->global_format->standart_head(array("Date", "Account", "Ref", "Debit", "Credit", "Options"));
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_detail = array(
      "limit"         => 5,
      "id"            => "table-detail",
      "search"        => "",
      "variable"      => "vm_detail",
      "cari"          => "searchDetail",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_detail, $grid_detail)
      . $this->global_format->standart_get("ambil_data", site_url('frm/frm-siklus-ajax/transaksi-get'), "{start: mulai, id_frm_journal_period: '{$id_frm_journal_period}'}", $grid)
      . $this->global_format->standart_get("ambil_detail", site_url('frm/frm-siklus-ajax/transaksi-detail-get'), "{start: mulai, id_frm_journal: formutama.id_frm_journal}", $grid_detail)
      . "ambil_data(0);"
      . "";
      
    $form = array(
      "variable"    => "formutama",
      "id"          => "form-utama",
      "loading"     => "transaksi-form-loading",
      "id_set"      => "id_temp",
      "else"        => ""
        . "{$grid['variable']}.page.select = [];"
        . "{$grid['variable']}.page.select_value = '';"
        . "{$grid['variable']}.reselect();"

        . "this.id_temp = hasil.id;"
        . "{$grid_detail['variable']}.clear();"
        . "for(ind = 0; ind < hasil.data.data.length; ++ind){"
          . $this->global_format->js_grid_add($grid, "hasil.data.data[ind]")
        . "}"
          
      . "",
      "methods"     => ""
      . "tambah: function(){"
        . "$.post('".site_url("frm/frm-siklus-ajax/transaksi-detail-set")."', {id_frm_account: this.id_frm_account, pos: this.pos, nominal: str_replace(',','',this.nominal), id_frm_journal: this.id_frm_journal, title: this.title, note: $('#note1').val(), tanggal: this.tanggal}, function(data){"
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
            . "if(hasil.status == 2){"
              . "formutama.id_frm_journal = hasil.data.id_frm_journal;"
              . "{$grid_detail['variable']}.clear();"
              . "ambil_detail(0);"
            . "}"
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#account-loading').hide();"
        . "});"
      . "},"
      . "",
    );
    $options_users[] = array(
      "id"    => 0,
      "text"  => lang("- Pilih -")
    );
    $param = array(
      "id_frm_journal"            => "",
      "id_frm_account"            => "",
      "id_temp"                   => "",
      "pos"                       => true,
      "nominal"                   => 0,
      "title"                     => "",
      "tanggal"                   => date("Y-m-d H:i"),
      "note"                      => "",
      "options_account"           => $options_users,
    );
    $kirim = array(
      "update"        => "{}",
      "insert"        => "{id_frm_journal: id_frm_journal, title: this.title, note: $('#note1').val(), tanggal: this.tanggal}",
      "before_insert" => "var id_frm_journal = this.id_frm_journal;",
    );
    
    $form_watch = ""
      . "id_temp: function(val){"
        . "this.id_frm_journal = '';"
      . "}"
      . "";
        
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("frm/frm-siklus-ajax/transaksi-set"), $grid, $form_watch)
      
      . "function account_get(start){"
        . "$('#account-loading').show();"
        . "$.post('".site_url("frm/frm-siklus-ajax/account-dropdown-get")."', {start: start}, function(data){"
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
            . "if(hasil.status == 2){"
              . "formutama.options_account = formutama.options_account.concat(hasil.data);"
              . "account_get(hasil.start);"
            . "}"
            . "else if(hasil.status == 4){"
            . "}"
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#account-loading').hide();"
        . "});"
      . "}"
      . "account_get(0);"
      . $this->global_format->standart_str_replace()
      . ""
      . "$(document).on('click', '.detail-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("frm/frm-siklus-ajax/transaksi-detail-delete")."', {id_frm_journal_detail: id}, function(data){"
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
            . "{$grid_detail['variable']}.clear();"
            . "ambil_detail(0);"
          . "}"
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
      . "<h1>".lang("Transaction Journal")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-recycle'></i> <a href='javascript:void(0)'> ".lang("Accounting Cycle")."</a></li>"
        . "<li><i class='fa fa-object-group'></i> <a href='".site_url("frm/frm-master/period")."'> ".lang("Period")."</a></li>"
        . "<li class='active'><a href='".site_url("frm/frm-siklus/transaksi/{$id_frm_journal_period}")."'><i class='fa fa-tags'></i> ".lang("Transaction Journal")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('siklus/transaksi/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-siklus/transaksi",
        'title'       => lang("Transaction Journal"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
        'grid_detail' => $grid_detail,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("siklus/transaksi/main");
  }
  
  function buku_besar(){
    if(!$this->session->userdata("frm_journal_period")){
      redirect("frm/frm-master/period");
    }
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".journal{"
          . "background-color: #c0c0c0 !important;"
          . "font-weight: bold;"
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
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
      
    
    $header = $this->global_format->standart_head(array("Account", "Ref", "Debit", "Credit"));
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('frm/frm-siklus-ajax/buku-besar-get'), "{start: mulai, id_frm_journal_period: '{$this->session->userdata("frm_journal_period")}'}", $grid)
      . "ambil_data(0);"
      . "";
        
    $foot .= ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Ledger")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-recycle'></i> <a href='javascript:void(0)'> ".lang("Accounting Cycle")."</a></li>"
        . "<li><i class='fa fa-object-group'></i> <a href='".site_url("frm/frm-master/period")."'> ".lang("Period")."</a></li>"
        . "<li class='active'><a href='".site_url("frm/frm-siklus/buku-besar")."'><i class='fa fa-book'></i> ".lang("Ledger")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('siklus/buku-besar/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-siklus/buku-besar",
        'title'       => lang("Ledger"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("siklus/buku-besar/main");
  }
  
  function neraca_saldo(){
    if(!$this->session->userdata("frm_journal_period")){
      redirect("frm/frm-master/period");
    }
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".journal{"
          . "background-color: #c0c0c0 !important;"
          . "font-weight: bold;"
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
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
      
    
    $header = $this->global_format->standart_head(array("Account", "Ref", "Debit", "Credit"));
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('frm/frm-siklus-ajax/neraca-saldo-get'), "{start: mulai, id_frm_journal_period: '{$this->session->userdata("frm_journal_period")}'}", $grid)
      . "ambil_data(0);"
      . "";
        
    $foot .= ""
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Trial Balance")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-recycle'></i> <a href='javascript:void(0)'> ".lang("Accounting Cycle")."</a></li>"
        . "<li><i class='fa fa-object-group'></i> <a href='".site_url("frm/frm-master/period")."'> ".lang("Period")."</a></li>"
        . "<li class='active'><a href='".site_url("frm/frm-siklus/neraca-saldo")."'><i class='fa fa-fax'></i> ".lang("Trial Balance")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('siklus/neraca-saldo/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-siklus/neraca-saldo",
        'title'       => lang("Trial Balance"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("siklus/neraca-saldo/main");
  }
  
  function buku_besar_detail($id_frm_account){
    if(!$this->session->userdata("frm_journal_period")){
      redirect("frm/frm-master/period");
    }
    $id_frm_account = str_replace("_", " ", $id_frm_account);
    
    $account = $this->global_models->get("frm_account", array("id_frm_account" => $id_frm_account));
    
    $css = ""
      . "<style>"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".journal{"
          . "background-color: #c0c0c0 !important;"
          . "font-weight: bold;"
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
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
      
    
    $header = $this->global_format->standart_head(array("Date", "Note", "Debit", "Credit"));
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
      . "function hitung_summary(){"
        . "console.log(vm_utama.items);"
        . "var total = debit = credit = 0;"
        . "for(var t = 0 ; t < vm_utama.items.length ; t++){"
          . "total = total + vm_utama.items[t].data[3].value;"
          . "if(vm_utama.items[t].data[3].value < 0){"
            . "credit = credit + vm_utama.items[t].data[3].value;"
          . "}"
          . "else{"
            . "debit = debit + vm_utama.items[t].data[3].value;"
          . "}"
        . "}"
        . "$('#view-debit').html(number_format(debit));"
        . "$('#view-credit').html(number_format(credit));"
        . "$('#view-total').html(number_format(total));"
      . "}"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('frm/frm-siklus-ajax/buku-besar-detail-get'), "{start: mulai, id_frm_journal_period: '{$this->session->userdata("frm_journal_period")}', id_frm_account: '{$id_frm_account}'}", $grid, array("selesai" => "hitung_summary();"))
      . "ambil_data(0);"
      . $this->global_format->standart_number_format()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Ledger")." {$account[0]->title}</h1>"
      . "<ol class='breadcrumb'>"
        . "<li><i class='fa fa-money'></i> <a href='javascript:void(0)'> ".lang("FRM")."</a></li>"
        . "<li><i class='fa fa-recycle'></i> <a href='javascript:void(0)'> ".lang("Accounting Cycle")."</a></li>"
        . "<li><i class='fa fa-object-group'></i> <a href='".site_url("frm/frm-master/period")."'> ".lang("Period")."</a></li>"
        . "<li class='active'><a href='".site_url("frm/frm-siklus/buku-besar")."'><i class='fa fa-book'></i> ".lang("Ledger")."</a></li>"
        . "<li class='active'><a href='".site_url("frm/frm-siklus/buku-besar-detail/".str_replace(' ', '-', $id_frm_account))."'><i class='fa fa-book'></i> {$account[0]->title} - {$account[0]->ref}</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('siklus/buku-besar-detail/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "frm/frm-siklus/buku-besar",
        'title'       => lang("Ledger")." {$account[0]->ref}",
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("siklus/buku-besar-detail/main");
  }
  
}