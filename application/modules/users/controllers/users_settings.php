<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function approval_users(){
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title", "Status", "Option"));
    $header_approval_employee = $this->global_format->standart_head(array("Email", "Name", "Privilege", "Option"));
    
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
    
    $grid_approval_employee = array(
      "limit"         => 10,
      "id"            => "table-approval-employee",
      "search"        => "",
      "variable"      => "vm_approval_employee",
      "cari"          => "searchApprovalEmployee",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_approval = array(
      "limit"         => 10,
      "id"            => "table-approval",
      "search"        => "",
      "variable"      => "vm_approval",
      "cari"          => "searchApproval",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_teams_employee = array(
      "limit"         => 10,
      "id"            => "table-teams-employee",
      "search"        => "",
      "variable"      => "vm_teams_employee",
      "cari"          => "searchTeamsEmployee",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $grid_teams = array(
      "limit"         => 10,
      "id"            => "table-teams",
      "search"        => "",
      "variable"      => "vm_teams",
      "cari"          => "searchTeams",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->js_grid_table(array(), $header_approval_employee, $grid_approval_employee)
      . $this->global_format->js_grid_table(array(), $header_approval_employee, $grid_approval)
      . $this->global_format->js_grid_table(array(), $header_approval_employee, $grid_teams_employee)
      . $this->global_format->js_grid_table(array(), $header_approval_employee, $grid_teams)
      . $this->global_format->standart_get("ambil_data", site_url('users/users-settings-ajax/group-get'), "{start: mulai}", $grid)
      . $this->global_format->standart_get("ambil_biodata_approval", site_url('users/users-settings-ajax/group-users-approval-get'), "{start: mulai, employee: 'approval', id_m_users_group: formutama.id_m_users_group}", $grid_approval_employee)
      . $this->global_format->standart_get("ambil_biodata_team", site_url('users/users-settings-ajax/group-users-team-get'), "{start: mulai, employee: 'teams', id_m_users_group: formutama.id_m_users_group}", $grid_teams_employee)
      . $this->global_format->standart_get("ambil_approval", site_url('users/users-settings-ajax/group-approval-get'), "{start: mulai, id_m_users_group: formutama.id_m_users_group}", $grid_approval)
      . $this->global_format->standart_get("ambil_teams", site_url('users/users-settings-ajax/group-teams-get'), "{start: mulai, id_m_users_group: formutama.id_m_users_group}", $grid_teams)
      . "ambil_data(0);"
      . "";
    
    $form = array(
      "variable"    => "formutama",
      "id"          => "form-utama",
      "loading"     => "page-loading-post"
    );
    $param = array(
      "title"             => "",
      "code"              => "",
      "id_m_users_group"  => "",
    );
    $kirim = array(
      "update"    => "{title: this.title, id_m_users_group: this.id_m_users_group, code: this.code}",
      "insert"    => "{title: this.title, code: this.code}",
    );
    
    $form_watch = ""
      . "id_m_users_group: function(val){"
        . "vm_approval_employee.clear();"
        . "vm_approval.clear();"
        . "vm_teams_employee.clear();"
        . "vm_teams.clear();"
        . "ambil_biodata_approval(0);"
        . "ambil_biodata_team(0);"
        . "ambil_approval(0);"
        . "ambil_teams(0);"
      . "}"
      . "";
     
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("users/users-settings-ajax/group-set"), $grid, $form_watch)
      . "";
    
    $this->load->model("users/js/j_users_settings");
    
    $foot .= ""
      . $this->j_users_settings->group_select_utama()
      . $this->j_users_settings->group_approval_save($grid_approval)
      . $this->j_users_settings->group_teams_save($grid_teams)
      . $this->j_users_settings->group_approval_delete()
      . $this->j_users_settings->group_teams_delete()
      
      . $this->global_format->standart_number_format()
      . $this->global_format->standart_str_replace()
//      . $this->j_hrmemployee->location_location_delete()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Approval Employee")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-sitemap'></i> ".lang("Approval Employee")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/approval-employee/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "users/users-settings/approval-users",
        'title'       => lang("Approval Employee"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'                  => $grid,
        'grid_approval_employee'=> $grid_approval_employee,
        'grid_approval'         => $grid_approval,
        'grid_teams_employee'   => $grid_teams_employee,
        'grid_teams'            => $grid_teams,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/approval-employee/main");
  }
  
  public function session_users(){
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Name", "Email", "Privilege"));
    
//    $this->debug($this->session->userdata("id_hrm_employee"), true);
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
      . $this->global_format->standart_get("ambil_data", site_url('users/users-settings-ajax/session-users-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . $this->global_format->standart_component()
      . "";
    
    $this->load->model("users/js/j_users_settings");
    
    $foot .= ""
      . $this->j_users_settings->session_users_select_utama()
      
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Session Users")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'> ".lang("Session Users")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/session-employee/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "users/users-settings/session-users",
        'title'       => lang("Session Employee"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'                  => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/session-employee/main");
  }
  
  public function session_group(){
    $css = ""
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/nubusa/price/jquery.price_format.1.8.min.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Code", "Title"));
    
//    $this->debug($this->session->userdata("id_hrm_employee"), true);
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
      . $this->global_format->standart_get("ambil_data", site_url('users/users-settings-ajax/session-group-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $foot .= ""
      . $this->global_format->standart_component()
      . "";
    
    $this->load->model("users/js/j_users_settings");
    
    $foot .= ""
      . $this->j_users_settings->session_group_select_utama()
      
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Session Group")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'> ".lang("Session Group")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('settings/session-group/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "users/users-settings/session-group",
        'title'       => lang("Session Group"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'                  => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("settings/session-group/main");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */