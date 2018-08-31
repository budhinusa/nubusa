<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scm_master extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function outlet(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
//      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "var table_storage = "
        . "$('#tableboxy-storage').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('scm/scm-master-ajax/outlet-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . '}'
              . '}'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "function ambil_data_storage(table_storage, id_scm_outlet, mulai){"
          . "$.post('".site_url('scm/scm-master-ajax/outlet-storage-get')."', {start: mulai, id_scm_outlet: id_scm_outlet}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table_storage.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . '}'
              . '}'
              . 'ambil_data_storage(table_storage, id_scm_outlet, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "$(document).on('click', '#simpan', function(evt){"
          . "$('#form-loading').show();"
          . "var id = $('#id-scm-outlet').val();"
          . "var kirim = {title: $('#title').val(), id_scm_outlet: id, alamat: $('#alamat').val()};"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-set")."', kirim, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(id){"
              . "table.row($('[isi|='+id+']')).remove().draw();"
            . "}"
            . "if(hasil.status == 2){"
              . "var rowNode = table.row.add(hasil.data).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding);"
              . "$( rowNode ).addClass('selected');"
              . "$('#id-scm-outlet').val(hasil.banding);"
              . "$('#view-storage').show();"
            . "}"
            . "$('#form-loading').hide();"
          . "});"
        . "});"
            
        . "$(document).on('click', '#simpan-storage', function(evt){"
          . "$('#form-loading-storage').show();"
          . "var id = $('#id-scm-outlet-storage').val();"
          . "var kirim = {title: $('#storage-title').val(), id_scm_outlet_storage: id, id_scm_outlet: $('#id-scm-outlet').val(), note: $('#storage-note').val(), type: $('#storage-type').val()};"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-storage-set")."', kirim, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(id){"
              . "table_storage.row($('[isi|='+id+']')).remove().draw();"
            . "}"
            . "if(hasil.status == 2){"
              . "var rowNode = table_storage.row.add(hasil.data).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding);"
              . "$( rowNode ).addClass('selected');"
              . "$('#id-scm-outlet-storage').val(hasil.banding);"
            . "}"
            . "$('#form-loading-storage').hide();"
          . "});"
        . "});"
            
        . "$(document).on('click', '.delete', function(evt){"
          . "var id = $(this).attr('isi');"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-delete")."', {id: id}, function(data){"
            . "table.row($('[isi|='+id+']')).remove().draw();"
            . "$('#id-scm-outlet').val('');"
            . "$('#title').val('');"
            . "$('#alamat').val('');"
          . "});"
        . "});"
            
        . "$(document).on('click', '.delete-storage', function(evt){"
          . "var id = $(this).attr('isi');"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-storage-delete")."', {id: id}, function(data){"
            . "table_storage.row($('[isi|='+id+']')).remove().draw();"
            . "$('#id-scm-outlet-storage').val('');"
            . "$('#storage-title').val('');"
            . "$('#storage-note').val('');"
          . "});"
        . "});"
            
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-get-detail")."',{id:id},function(data){"
            . "var hasil = $.parseJSON(data);"
            . "$('#id-scm-outlet').val(hasil.id_scm_outlet);"
            . "$('#title').val(hasil.title);"
            . "$('#alamat').val(hasil.alamat);"
        
            . "table_storage.clear().draw();"
            . "ambil_data_storage(table_storage, id, 0);"
        
            . "$('#view-storage').show();"
        
          . "});"
        . "});"
          
        . "$('#tableboxy-storage tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table_storage.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-master-ajax/outlet-storage-get-detail")."',{id:id},function(data){"
            . "var hasil = $.parseJSON(data);"
            . "$('#id-scm-outlet-storage').val(hasil.id_scm_outlet_storage);"
            . "$('#storage-title').val(hasil.title);"
            . "$('#storage-note').val(hasil.note);"
            . "$('#storage-type').val(hasil.type);"
          . "});"
        . "});"
          
        . "$(document).on('click', '#new', function(evt){"
          . "table.$('tr.selected').removeClass('selected');"
          . "$('#id-scm-outlet').val('');"
          . "$('#title').val('');"
          . "$('#alamat').val('');"
        . "});"
          
        . "$(document).on('click', '#new-storage', function(evt){"
          . "table_storage.$('tr.selected').removeClass('selected');"
          . "$('#id-scm-outlet-storage').val('');"
          . "$('#storage-title').val('');"
          . "$('#storage-note').val('');"
        . "});"
          
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Outlet")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-home'></i> ".lang("Outlet")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/outlet', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-master/outlet",
        'title'       => lang("Outlet"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/outlet");
    
	}
  
  public function satuan(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
//      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "var table_satuan = "
        . "$('#tableboxy-satuan').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "$('.harga').priceFormat({"
          . "prefix: '',"
          . "centsLimit: 0"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('scm/scm-master-ajax/satuan-group-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . '}'
              . '}'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "function ambil_data_satuan(table_satuan, id_scm_satuan_group, mulai){"
          . "$.post('".site_url('scm/scm-master-ajax/satuan-get')."', {start: mulai, id_scm_satuan_group: id_scm_satuan_group}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table_satuan.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . '}'
              . '}'
              . 'ambil_data_satuan(table_satuan, id_scm_satuan_group, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "$(document).on('click', '#simpan', function(evt){"
          . "$('#form-loading').show();"
          . "var id = $('#id-scm-satuan-group').val();"
          . "var kirim = {title: $('#title').val(), id_scm_satuan_group: id, note: $('#note').val()};"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-group-set")."', kirim, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(id){"
              . "table.row($('[isi|='+id+']')).remove().draw();"
            . "}"
            . "if(hasil.status == 2){"
              . "var rowNode = table.row.add(hasil.data).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding);"
              . "$( rowNode ).addClass('selected');"
              . "$('#id-scm-satuan-group').val(hasil.banding);"
              . "$('#view-satuan').show();"
            . "}"
            . "$('#form-loading').hide();"
          . "});"
        . "});"
            
        . "$(document).on('click', '#simpan-satuan', function(evt){"
          . "$('#form-loading-satuan').show();"
          . "var id = $('#id-scm-satuan').val();"
          . "var kirim = {title: $('#satuan-title').val(), id_scm_satuan: id, id_scm_satuan_group: $('#id-scm-satuan-group').val(), note: $('#storage-note').val(), level: $('#satuan-level').val(), nilai: $('#satuan-nilai').val()};"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-set")."', kirim, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(id){"
              . "table_satuan.row($('[isi|='+id+']')).remove().draw();"
            . "}"
            . "if(hasil.status == 2){"
              . "var rowNode = table_satuan.row.add(hasil.data).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding);"
              . "$( rowNode ).addClass('selected');"
              . "$('#id-scm-satuan').val(hasil.banding);"
            . "}"
            . "$('#form-loading-satuan').hide();"
          . "});"
        . "});"
            
        . "$(document).on('click', '.delete', function(evt){"
          . "var id = $(this).attr('isi');"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-group-delete")."', {id: id}, function(data){"
            . "table.row($('[isi|='+id+']')).remove().draw();"
            . "$('#id-scm-satuan-group').val('');"
            . "$('#title').val('');"
            . "$('#note').val('');"
          . "});"
        . "});"
            
        . "$(document).on('click', '.delete-satuan', function(evt){"
          . "var id = $(this).attr('isi');"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-delete")."', {id: id}, function(data){"
            . "table_satuan.row($('[isi|='+id+']')).remove().draw();"
            . "$('#id-scm-satuan').val('');"
            . "$('#satuan-title').val('');"
            . "$('#satuan-note').val('');"
            . "$('#satuan-level').val('');"
            . "$('#satuan-nilai').val('');"
          . "});"
        . "});"
            
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-group-get-detail")."',{id:id},function(data){"
            . "var hasil = $.parseJSON(data);"
            . "$('#id-scm-satuan-group').val(hasil.id_scm_satuan_group);"
            . "$('#title').val(hasil.title);"
            . "$('#note').val(hasil.note);"
        
            . "table_satuan.clear().draw();"
            . "ambil_data_satuan(table_satuan, id, 0);"
        
            . "$('#view-satuan').show();"
        
          . "});"
        . "});"
          
        . "$('#tableboxy-satuan tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table_satuan.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-master-ajax/satuan-get-detail")."',{id:id},function(data){"
            . "var hasil = $.parseJSON(data);"
            . "$('#id-scm-satuan').val(hasil.id_scm_satuan);"
            . "$('#satuan-title').val(hasil.title);"
            . "$('#satuan-note').val(hasil.note);"
            . "$('#satuan-level').val(hasil.level);"
            . "$('#satuan-nilai').val(hasil.nilai);"
          . "});"
        . "});"
          
        . "$(document).on('click', '#new', function(evt){"
          . "table.$('tr.selected').removeClass('selected');"
          . "$('#id-scm-satuan-group').val('');"
          . "$('#title').val('');"
          . "$('#note').val('');"
        . "});"
          
        . "$(document).on('click', '#new-satuan', function(evt){"
          . "table_satuan.$('tr.selected').removeClass('selected');"
          . "$('#id-scm-satuan').val('');"
          . "$('#satuan-title').val('');"
          . "$('#satuan-note').val('');"
          . "$('#satuan-level').val('');"
          . "$('#satuan-nilai').val('');"
        . "});"
          
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Satuan")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-balance-scale'></i> ".lang("Satuan")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('master/satuan', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-master/satuan",
        'title'       => lang("Satuan"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("master/satuan");
    
	}
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */