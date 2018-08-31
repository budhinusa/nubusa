<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
	public function index(){
    $this->template->build("main", 
      array(
            'title_table' => "Settings",
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings',
          ));
    $this->template
      ->set_layout('default')
      ->build("main");
	} 
	public function get_module(){
    $dir = "application/modules";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          if($file != "."  AND $file != ".."){
            $cek = $this->global_models->get_field("m_module", "id_module", array("name" => $file));
            if($cek < 1){
              $id = $this->global_models->insert("m_module", array(
                "name"            => $file,
                "desc"            => ucfirst($file),
                "status"          => 1,
                "create_by_users" => $this->session->userdata("id"),
                "create_date"     => date("Y-m-d H:i:s")
              ));
              $data_json = $this->nbscache->get("module_status");
              $data_banding = json_decode($data_json);
              $data_banding[$file] = array(
                "title"       => $file,
                "status"      => 1,
                "versi"       => 0
              );
              $data_kirim = json_encode($data_banding);
              $this->nbscache->put_all("module_status", $data_kirim);
            }
          }
        }
//        closedir($dh);
      }
    }
//    die;
    redirect("settings/module");
  }
  
	public function get_controller($id_module){
    $s_module = $this->global_models->get_field("m_module", "name", array("id_module" => $id_module));
    $dir = "application/modules/{$s_module}/controllers";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          $info = pathinfo("application/modules/{$s_module}/controllers/".$file);
          if($info['extension'] == "php"){
            $cek = $this->global_models->get_field("m_controller", "id_controller", array("link" => $info['filename']));
            if($cek < 1){
              $kirim = array(
                "id_module"           => $id_module,
                "name"                => ucfirst($info['filename']),
                "link"                => $info['filename'],
                "create_by_users"     => $this->session->userdata("id"),
                "create_date"         => date("Y-m-d H:i:s")
              );
              $this->global_models->insert("m_controller", $kirim);
            }
          }
        }
        closedir($dh);
      }
    }
    redirect("settings/control/{$id_module}");
  }
  
	public function module(){
    $module = $this->global_models->get("m_module");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-module")."'><i class='icon-plus'></i> Add New</a></li>"
      . "<li><a href='".site_url("settings/get-module")."'><i class='icon-plus'></i> Get Module</a></li>";
    $this->template->build("module", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/module',
            'title'       => "Setting Module",
            'data'        => $module,
            'foot'        => $foot,
            'css'         => $css,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("module");
	}
	public function form(){
    $form = $this->global_models->get("m_form");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-form")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build("form", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/form',
            'title'       => "Setting Form",
            'data'        => $form,
            'css'         => $css,
            'foot'        => $foot,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("form");
	}
	public function control($id_module){
    $control = $this->global_models->get_query("
      SELECT A.*, B.desc AS module
      FROM m_controller AS A
      LEFT JOIN m_module AS B ON A.id_module = B.id_module
      WHERE A.id_module = '{$id_module}'
      ");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-control")."'><i class='icon-plus'></i> Add New</a></li>";
    
    $head = ""
    . "<h1>".lang("Master Controller")."</h1>"
    . "<ol class='breadcrumb'>"
      . "<li><a href='".site_url("settings/module")."'><i class='fa fa-dashboard'></i> ".lang("Master Module")."</a></li>"
      . "<li class='active'>".lang("Master Module")."</li>"
    . "</ol>";
    
    $this->template->build("control", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/module',
            'title'       => "Setting Controller",
            'data'        => $control,
            'css'         => $css,
            'foot'        => $foot,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->set_heads($head)
      ->build("control");
	} 
	public function add_new_module($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_module", array("id_module" => $id_detail));
      $this->template->build("add-new-module", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/module',
              'title'       => "Create Module",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Modules"  => "settings/module"
                ),
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-module");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "desc"            => $pst['desc'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_module = $this->global_models->update("m_module", array("id_module" => $pst['id_detail']),$kirim);
        $id_module = $pst['id_detail'];
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "desc"            => $pst['desc'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_module = $this->global_models->insert("m_module", $kirim);
      }
      if($id_module){
        if($pst['status'] == 1){
//          $this->nbscache->clear_free("module", "view", $pst['name'], $pst['name']);
        }
        else{
          $this->nbscache->clear_free("module", "view", $pst['name'], $pst['name']);
          $this->nbscache->put("module", "view", $pst['name'], $pst['name']);
        }
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      
      $data_json = $this->nbscache->get("module_status");
      $data_banding = json_decode($data_json);
      if(property_exists($data_banding, $pst['name'])){
        $data_banding->{$pst['name']} = array(
          "title"       => $pst['name'],
          "status"      => $pst['status'],
          "versi"       => $this->global_models->get_field("m_module", "versi", array("id_module" => $id_module)),
        );
      }
      else{
//        $this->debug($data_banding, true);
        $data_banding->{$pst['name']} = array(
          "title"       => $pst['name'],
          "status"      => $pst['status'],
          "versi"       => $this->global_models->get_field("m_module", "versi", array("id_module" => $id_module)),
        );
      }

      $data_kirim = json_encode($data_banding);
      $this->nbscache->put_all("module_status", $data_kirim);
      
      redirect("settings/module");
    }
	}
	public function add_new_form($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_form", array("id_form" => $id_detail));
      $this->template->build("add-new-form", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/form',
              'title' => "Create Form",
              'detail' => $detail,
              'foot'        => ""
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-form");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"            => $pst['nicename'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_form = $this->global_models->update("m_form", array("id_form" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"            => $pst['nicename'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_form = $this->global_models->insert("m_form", $kirim);
      }
      if($id_form){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("settings/form");
    }
	}
	public function add_new_control($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_controller", array("id_controller" => $id_detail));
      $this->template->build("add-new-control", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/control',
              'title'   => "Create Controller",
              'detail' => $detail,
              'module'  => $this->global_models->get_dropdown("m_module", "id_module", "desc", FALSE),
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-control");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "link"            => $pst['link'],
            "id_module"       => $pst['id_module'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_controller = $this->global_models->update("m_controller", array("id_controller" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "link"            => $pst['link'],
            "id_module"       => $pst['id_module'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_controller = $this->global_models->insert("m_controller", $kirim);
      }
      if($id_controller){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("settings/control/{$pst['id_module']}");
    }
	}
  
  
  public function addrow_page(){
    $key = $this->input->post('no');
    $in = $this->form_eksternal->form_input("page[]");
    print <<<EOD
    <tr id='tr_{$key}'>
      <td>{$in}</td>
      <td><a href='#' class='remove-element' onclick='del_row_tambahan("tr_{$key}")' title='Remove' >Remove</a></td>
    </tr>
EOD;
    die;
  }
  public function page($id){
    $data_detail = $this->global_models->get("m_controller", array("id_controller" => $id));
    $module = $this->global_models->get("m_module", array("id_module" => $data_detail[0]->id_module));
    require_once 'application/modules/'.$module[0]->name.'/controllers/'.$data_detail[0]->link.'.php';
    $list_page = get_class_methods($data_detail[0]->link);  
//    $this->debug($list_page, true);
    foreach ($list_page as $value) {
      if($value[0] != "_" AND !in_array($value, array("cek", "privilege_page", "privilege", "debug"))){
        if($this->global_models->get_field("m_page", "link", array("link" => $value, "id_controller" => $id)) === false){
          $this->global_models->insert("m_page", array("id_controller" => $id, "link" => $value));
        }
      }
    }
    redirect("settings/control/{$data_detail[0]->id_module}");
  }
  
  function notifications(){
    $css = ""
      . "<link rel='stylesheet' href='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-bs3.css'>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.min.css' rel='stylesheet' type='text/css' />"
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/daterangepicker/daterangepicker-old.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("Date","Users", "Link", "Title", "Option"));
       
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
//      "on_unselect"   => "unselect_utama();",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $form = array(
      "variable"    => "formutama",
      "id"          => "form-utama",
      "loading"     => "page-loading-post"
    );
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('settings/settings-ajax/notifications-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
    
    $users = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users AS A"
      . " WHERE A.status = 1");
    
    foreach ($users as $value) {
      $options_users[] = array(
        "id"    => $value->id_users,
        "text"  => $value->name,
      );
    }
    
    $param = array(
      "tanggal"                   => "",
      "id_users"                  => "",
      "options_users"             => $options_users,
      "link"                      => "",
      "title"                     => "",
      "note"                      => "",
      "code"                      => "",
      "id_settings_notifications" => "",
    );
    $kirim = array(
      "update"    => "{tanggal: this.tanggal, id_users: this.id_users, link: this.link, title: this.title, note: this.note, id_settings_notifications: this.id_settings_notifications, code: this.code}",
      "insert"    => "{tanggal: this.tanggal, id_users: this.id_users, link: this.link, title: this.title, note: this.note, code: this.code}",
    );
    
    $form_watch = ""
      . "";
        
    $foot .= ""
      . $this->global_format->standart_component()
      . $this->global_format->standart_form($form, $param, $kirim, site_url("settings/settings-ajax/notifications-set"), $grid, $form_watch)
      . "";
    
    $this->load->model("settings/js/j_settings");
    
    $foot .= ""
      . $this->j_settings->notifications_select_utama()
      . $this->j_settings->notifications_not_delete()
      . $this->global_format->standart_str_replace()
      . $this->global_format->standart_number_format()
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Notifications")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-commenting-o'></i> ".lang("Notifications")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('notifications/main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "settings/notifications",
        'title'       => lang("Notifications"),
        'foot'        => $foot,
        'css'         => $css,
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("notifications/main");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */