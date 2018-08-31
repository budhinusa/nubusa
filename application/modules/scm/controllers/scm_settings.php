<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scm_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function users_suppliers(){
    
    $this->load->library('form_validation');
    $config = array(
      array(
        'field'   => 'first_name', 
        'label'   => lang("First Name"), 
        'rules'   => 'required'
       ),
      array(
        'field'   => 'last_name', 
        'label'   => lang("Last Name"), 
        'rules'   => 'required'
       ),
      array(
        'field'   => 'id_scm_procurement_suppliers', 
        'label'   => lang("Suppliers"), 
        'rules'   => 'required'
       ),   
      array(
        'field'   => 'user_name', 
        'label'   => lang("User Name"), 
        'rules'   => 'required'
       ),
      array(
        'field'   => 'user_email',
        'label'   => lang("User Email"), 
        'rules'   => 'required|valid_email'
       ),
      array(
        'field'   => 'user_pass',
        'label'   => lang("Agama"),
        'rules'   => 'required|matches[user_repass]'
       ),
      array(
        'field'   => 'user_repass',
        'label'   => lang("Jenis Kelamin"), 
        'rules'   => 'required'
       ),
   );

    $this->form_validation->set_rules($config);
    
    if ($this->form_validation->run() == FALSE){
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
        . "<style>"
          . ".selected{"
            . "background-color: aquamarine !important;"
          . "}"
        . "</style>";

      $foot .= ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/slimScroll/jquery.slimscroll.min.js'></script>"
        . '<script type="text/javascript">'
        . "";

        $foot .= ""
          . "var table = "
          . "$('#tableboxy').DataTable({"
            . "'order': [[ 1, 'asc' ]]"
          . "});"

          . "$('.select2').select2();"

          . "ambil_data(table, 0);"

          . "function ambil_data(table, mulai){"
            . "$.post('".site_url('scm/scm-settings-ajax/biodata-suppliers-get')."', {start: mulai}, function(data){"
              . "var hasil = $.parseJSON(data);"
  //            . '$("#page-loading").show();'
              . "if(hasil.status == 2){"
                . "if(hasil.hasil){"
                  . "for(ind = 0; ind < hasil.hasil.length; ++ind){"
                    . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                    . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "}"
                . "}"
                . "ambil_data(table, hasil.start);"
              . "}"
              . "else{"
              . "}"
            . "});"
          . "}"

          . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
            . "var id = $(this).attr('isi');"
            . "if ( $(this).hasClass('selected') ) {"
            . "}"
            . "else {"
              . "table.$('tr.selected').removeClass('selected');"
              . "$(this).addClass('selected');"
            . "}"
            . "$.post('".site_url("scm/scm-settings-ajax/biodata-suppliers-get-detail")."',{id:id},function(data){"
              . "var hasil = $.parseJSON(data);"
              . "$('#field-avatar').html(hasil.avatar);"
              . "$('#first-name').val(hasil.first_name);"
              . "$('#last-name').val(hasil.last_name);"
              . "$('#telp').val(hasil.telp);"
              . "$('#email').val(hasil.email);"
              . "$('#note').val(hasil.note);"
              . "$('#id-scm-suppliers-biodata').val(hasil.id_scm_suppliers_biodata);"
              
              . "$('#id-users').val(hasil.users.id_users);"
              . "$('#user-name').val(hasil.users.name);"
              . "$('#user-email').val(hasil.users.email);"
              . "$('#user-status').val(hasil.users.status);"

            . "});"
          . "});"

          . "$(document).on( 'click', '#update', function () {"
            . "$('#biodata-loading').show();"
            . "var kirim = {"
              . "first_name: $('#first-name').val(),"
              . "last_name: $('#last-name').val(),"
              . "id_scm_procurement_suppliers: $('#id-scm-procurement-suppliers').select2('val'),"
              . "id_scm_suppliers_biodata: $('#id-scm-suppliers-biodata').val(),"
              . "id_users: $('#id-users').val(),"
              . "telp: $('#telp').val(),"
              . "email: $('#email').val(),"
              . "note: $('#note').val()"
            . "};"

            . "var file_data = $('#avatar').prop('files')[0];"
            . "var form_data = new FormData();"
            . "form_data.append('avatar', file_data);"

            . "if(file_data != undefined){"
              . "var upload = $.ajax({"
                . "url: '".site_url("scm/scm-settings-ajax/biodata-upload")."',"
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
            . "}"
            . "var gambar = 'nbs';"
  //        . "console.log(upload);"
            . "if(upload){"
              . "var gambar = $.parseJSON(upload);"
            . "}"

            . "if(gambar != 'nbs'){"
              . "if(gambar.status == 2){"
                . "kirim.avatar = gambar.data;"
                . "$('#field-avatar').html(gambar.link);"
              . "}"
            . "}"
  //        . "console.log(kirim);"

            . "$.post('".site_url("scm/scm-settings-ajax/biodata-suppliers-set")."',kirim,function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 2){"
                . "if(hasil.hasil){"
                  . "table.row($('tr.selected')).remove().draw();"
                  . "var rowNode = table.row.add(hasil.hasil).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding);"
                  . "$( rowNode ).addClass('selected');"
                  . "$('#id-scm-suppliers-biodata').val(hasil.banding);"
                . "}"
              . "}"
            . "});"
            . "$('#biodata-loading').hide();"
          . "});"

          . "";
      $foot .= "</script>";
      $head = ""
        . "<h1>".lang("Biodata")."</h1>"
        . "<ol class='breadcrumb'>"
          . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-user'></i> ".lang("Biodata")."</a></li>"
        . "</ol>";

      $this->template
        ->set_layout('default')
        ->build('settings/users-suppliers', array(
          'url'         => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'        => "scm/scm-settings/users-suppliers",
          'title'       => lang("Biodata"),
          'foot'        => $foot,
          'css'         => $css,
        ));
      $this->template
        ->set_layout('default')
        ->set_heads($head)
        ->build("settings/users-suppliers");
    }
    else{
      $pst = $this->input->post();
      
      $config['upload_path'] = './files/scm/settings/biodata/';
      $config['allowed_types'] = 'png|jpg|jpeg';

      $this->load->library('upload', $config);

      if($_FILES['avatar']['name']){
        if (  $this->upload->do_upload('avatar')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("scm/scm-settings/users-suppliers")."'>Back</a>";
          die;
        }
      }
      
      $scm_json = $this->nbscache->get("scm");
      $scm = json_decode($scm_json);
      
      $kirim_users = array(
        "name"                  => $pst['user_name'],
        "pass"                  => $this->encrypt->encode($pst['pass']),
        "email"                 => $pst['user_email'],
        "id_privilege"          => $scm->scm_users_suppliers_privilege->id,
        "status"                => 1,
        "create_by_users"       => $this->session->userdata("id"),
        "create_date"           => date("Y-m-d H:i:s")
      );
      $id_users = $this->global_models->insert("m_users", $kirim_users);
      if($id_users){
        $this->global_models->generate_id($id_scm_suppliers_biodata, "scm_suppliers_biodata");
        $kirim_biodata = array(
          "id_scm_suppliers_biodata"        => $id_scm_suppliers_biodata,
          "id_users"                        => $id_users,
          "id_scm_procurement_suppliers"    => $pst['id_scm_procurement_suppliers'],
          "first_name"                      => $pst['first_name'],
          "last_name"                       => $pst['last_name'],
          "telp"                            => $pst['telp'],
          "email"                           => $pst['email'],
          "note"                            => $pst['note'],
          "create_by_users"                 => $this->session->userdata("id"),
          "create_date"                     => date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim_biodata['avatar'] = $data['upload_data']['file_name'];
        }
        $this->global_models->insert("scm_suppliers_biodata", $kirim_biodata);
      }
      
      if($id_users){
        $this->session->set_flashdata('success', lang('Data tersimpan'));
      }
      else{
        $this->session->set_flashdata('notice', lang("Gagal Menyimpan"));
      }
      redirect("scm/scm-settings/users-suppliers");
    }
	}
  
  public function session_outlet(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('scm/scm-settings-ajax/outlet-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "if(hasil.banding[ind] == '{$this->session->userdata("scm_outlet")}'){"
                    . "$( rowNode ).addClass('selected');"
                  . "}"
                . "}"
              . '}'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-settings-ajax/outlet-set")."',{id:id},function(data){"
          . "});"
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
      ->build('settings/outlet', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-settings/session-outlet",
        'title'       => lang("Outlet"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/outlet");
    
	}
  
  public function session_suppliers(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
     
      $foot .= ""
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('scm/scm-settings-ajax/suppliers-get')."', {start: mulai}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "if(hasil.banding[ind] == '{$this->session->userdata("scm_procurement_suppliers")}'){"
                    . "$( rowNode ).addClass('selected');"
                  . "}"
                . "}"
              . '}'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "});"
        . "}"
        
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "$.post('".site_url("scm/scm-settings-ajax/suppliers-session-set")."',{id:id},function(data){"
          . "});"
        . "});"
          
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Suppliers")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-home'></i> ".lang("Suppliers")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/suppliers', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'title'       => lang("Suppliers"),
        'foot'        => $foot,
        'css'         => $css,
        'menu'        => "scm/scm-settings/session-suppliers",
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/suppliers");
    
	}
  
  public function scm_variable(){
    $pst = $this->input->post();
    $data_json = $this->nbscache->get("scm");
    $data = json_decode($data_json);
    
    if($pst){
      
      $code = $pst['code'];
      $data->{$code} = array(
        "id"        => $pst['id'],
        "name"      => $this->global_models->get_field($pst['table'], $pst['title'], array($pst['label_id'] => $pst['id'])),
        "label_id"  => $pst['label_id'],
        "title"     => $pst['title'],
        "table"     => $pst['table'],
      );
      $data_json = json_encode($data);
        
      $this->nbscache->put_all("scm", $data_json);
      redirect("scm/scm-settings/scm-variable");
    }
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
//      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
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
            
        . "$('#tableboxy tbody').on( 'click', 'tr', function () {"
          . "var id = $(this).attr('isi');"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "table.$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
          . "var hasil = $.parseJSON('{$data_json}');"
          . ""
          . "$('#code').val(id);"
          . "$('#id').val(hasil[id].id);"
          . "$('#label-id').val(hasil[id].label_id);"
          . "$('#title').val(hasil[id].title);"
          . "$('#table').val(hasil[id].table);"
        . "});"
        
        . "$(document).on('click', '#new', function(evt){"
          . "table.$('tr.selected').removeClass('selected');"
          . "$('#code').val('');"
          . "$('#id').val('');"
          . "$('#label-id').val('');"
          . "$('#title').val('');"
          . "$('#table').val('');"
        . "});"
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Variable")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-bars'></i> ".lang("Variable")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/scm-variable', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-settings/scm-variable",
        'title'       => lang("Variable"),
        'foot'        => $foot,
        'css'         => $css,
        'data'        => $data,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/scm-variable");
    
	}
  
  public function users_outlet(){
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
        
        . "var table_users = "
        . "$('#tableboxy-users').DataTable({"
          . "'order': [[ 0, 'asc' ]]"
        . "});"
        
        . "$('#users').autocomplete({"
          . "source: function( request, response ) {"
            . " $.ajax( {"
              . "type: 'POST',"
              . "url: '".site_url("scm/scm-settings-ajax/users-outlet-auto")."',"
              . "dataType: 'json',"
              . "data: {"
                . "term: request.term,"
                . "id_scm_outlet: $('#id-scm-outlet').val()"
              . "},"
              . "success: response,"
            . "}"
          . ");},"
          . "minLength: 1,"
          . "select: function( event, ui ) {"
            . "if($('#id-scm-outlet').val()){"
              . '$("#form-loading").show();'
              . "$.post('".site_url("scm/scm-settings-ajax/users-outlet-set")."', {id_scm_outlet: $('#id-scm-outlet').val(), id_users: ui.item.id}, function(data){"
                . "var hasil = $.parseJSON(data);"
                . "if(hasil.hasil){"
                  . "var rowNode = table_users.row.add(hasil.hasil).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding);"
                . "}"
              . "})"
              . ".fail(function(){"
                . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
              . "})"
              . ".always(function(){"
                . "$('#form-loading').hide();"
              . "});"
            . "}"
          . "}"
        . "});"
        
        . "ambil_data(table, 0);"
        
        . "function ambil_data(table, mulai){"
          . "$.post('".site_url('scm/scm-settings-ajax/outlet-get')."', {start: mulai}, function(data){"
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
          . "})"
          . ".fail(function(){"
            . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
          . "});"
        . "}"
        
        . "function ambil_data_users(table_users, id_scm_outlet, mulai){"
          . "$.post('".site_url('scm/scm-settings-ajax/users-outlet-get')."', {start: mulai, id_scm_outlet: id_scm_outlet}, function(data){"
            . 'var hasil = $.parseJSON(data);'
//            . '$("#page-loading").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table_users.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . '}'
              . '}'
              . 'ambil_data_users(table_users, id_scm_outlet, hasil.start);'
            . '}'
            . 'else{'
//              . '$("#page-loading").hide();'
            . '}'
          . "})"
          . ".fail(function(){"
            . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
          . "});"
        . "}"
        
        . "$(document).on('click', '.delete', function(evt){"
          . "var id = $(this).attr('isi');"
          . "$('#form-loading').show();"
          . "$.post('".site_url("scm/scm-settings-ajax/users-outlet-delete")."', {id: id}, function(data){"
            . "table_users.row($('[isi|='+id+']')).remove().draw();"
          . "})"
          . ".fail(function(){"
            . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
          . "})"
          . ".always(function(){"
            . "$('#form-loading').hide();"
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
        
          . "$('#id-scm-outlet').val(id);"
          
          . "table_users.clear().draw();"
          . "ambil_data_users(table_users, id, 0);"
        
        . "});"
        . "";
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Users Outlet")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-users'></i> ".lang("Users Outlet")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/users-outlet', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-settings/users-outlet",
        'title'       => lang("Users Outlet"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/users-outlet");
    
	}
  
  public function variable(){
    $css = ""
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
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $data_satuan = $this->global_models->get_query("SELECT A.id_scm_satuan, A.title"
      . " FROM scm_satuan AS A"
      . " ORDER BY A.id_scm_satuan_group, level ASC");
    foreach ($data_satuan AS $ds){
      $satuan[] = array(
        "id"    => $ds->id_scm_satuan,
        "text"  => $ds->title,
      );
    }
    
    $data_json = $this->nbscache->get("scm");
    $data_banding = json_decode($data_json);
    
    $data_account_json = $this->nbscache->get("scmtrans_account");
    $data_account = json_decode($data_account_json);
    
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
//          . '$(this.$el).val(this.value).select2({ data: this.options }).on("change", function () {'
//            . 'vm.$emit("input", this.value)'
//          . "})"
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).select2("val", value)'
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
          . "options_satuan: ".json_encode($satuan).","
          . "scm_alter_po_confirm: '{$data_banding->scm_default->scm_alter_po_confirm}',"
          . "site_transport_ap_po_account: '{$data_account->account_default->site_transport_ap_po_account}',"
          . "site_transport_ap_suppliers: '{$data_account->account_default->site_transport_ap_suppliers}',"
          . "id_scm_satuan_fuel: '{$data_banding->scm_default->id_scm_satuan_fuel}',"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "site_transport_ap_po_account: this.site_transport_ap_po_account,"
              . "scm_alter_po_confirm: this.scm_alter_po_confirm,"
              . "id_scm_satuan_fuel: this.id_scm_satuan_fuel,"
              . "site_transport_ap_suppliers: this.site_transport_ap_suppliers"
            . "};"
            . "$.post('".site_url("scm/scm-settings-ajax/variable-set")."', kirim, function(data){"
//              . "var hasil = $.parseJSON(data);"
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
      . "<h1>".lang("Variable")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-book'></i> ".lang("Variable")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/variable', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "scm/scm-settings/variable",
        'title'       => lang("Variable"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/variable");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */