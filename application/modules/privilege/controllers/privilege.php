<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege extends MX_Controller {
  function __construct() {
    $this->load->model('privilege/mprivilege');
    $this->menu = $this->cek();
  }
  
  public function session(){
    $css = ""
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
        . ".not-editable{"
          . "display: none;"
        . "}"
        . ".editable{"
          . "display: show;"
        . "}"
        . ".need-approve{"
          . "background-color: yellow;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = array(
      array(
        "title"       => lang("Title"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Dashboard"),
        "id"          => 1,
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
    
    $foot .= ""
      . $this->global_format->js_grid_table(array(), $header, $grid)
      
      . "function ambil_data(mulai){"
        . "$.post('".site_url('privilege/privilege-ajax/privilege-get')."', {start: mulai}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . 'ambil_data(hasil.start);'
          . '}'
          . 'else{'
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
      . "function select_utama(){"
        . "var id = {$grid['variable']}.page.select_value;"
        . "$.post('".site_url("privilege/privilege-ajax/privilege-set")."', {id: id}, function(data){"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
        
      . "";
        
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Session")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'>".lang("Session")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('session', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "privilege/session",
        'title'       => lang("Session"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("session");
  }
  
  
	public function add_new($id = 0){
    $this->template->title('Sistem', "Privilege Edit");
    if($id > 0){
      $data_detail = $this->mprivilege->get_detail($id);
//      $this->debug($data_detail, true);
    }
    else{
      $data_detail->id_privilege = "";
      $data_detail->name = "";
      $data_detail->dashbord = "";
    }
    if(!$this->input->post(NULL, TRUE)){
      $dropdown = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name", TRUE, array('parent <' => 1));
//      $this->debug($dropdown, true);
      $this->template->build('add-new', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'privilege',
              'title'   => 'Add Privilege',
              'title_form'   => 'Privilege Form',
              'detail'  => array($data_detail),
              'dropdown'  => array($dropdown),
              'breadcrumb'  => array(
                    "Privilege"  => "privilege"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build('add-new');
    }
    else{
      if($this->input->post("id_detail", TRUE)){
        $name_parent = $this->global_models->get_field("m_privilege", "name", array("id_privilege" => $this->input->post("parent", TRUE)));
        if($name_parent !== FALSE){
          $name_with_parent = $name_parent ." - ". $this->input->post("name", TRUE);
        }
        else{
          $name_with_parent = $this->input->post("name", TRUE);
        }
        $kirim = array(
            'name'            =>  $name_with_parent,
            'dashbord'            =>  $this->input->post("dashbord", TRUE),
            'level'            =>  $this->input->post("level", TRUE),
            'parent'            =>  $this->input->post("parent", TRUE),
            'type'            =>  $this->input->post("type", TRUE),
        );
        if($this->input->post("id_hrm_department", TRUE))
              $kirim['id_hrm_department'] = $this->input->post("id_hrm_department", TRUE);
        $hasil_in = $this->mprivilege->update($this->input->post("id_detail", TRUE), $kirim);
      }
      else{
        $pst = $this->input->post(NULL, TRUE);
//        $pst = $pst['addressform']['addressform'][0];
//        $this->debug($pst, true);
//        if(is_array($pst['name'])){
//          foreach($pst['name'] as $key => $pst_name){
            $name_parent = $this->global_models->get_field("m_privilege", "name", array("id_privilege" => $pst['parent']));
            if($name_parent !== FALSE){
              $name_with_parent = $name_parent ." - ". $pst['name'];
            }
            else{
              $name_with_parent = $pst['name'];
            }
            $kirim = array(
                'name'            =>  $name_with_parent,
                'dashbord'            =>  $pst['dashbord'],
                'level'            =>  $this->input->post("level", TRUE),
                'parent'            =>  $pst['parent'],
                'type'            =>  $this->input->post("type", TRUE),
            );
            if($this->input->post("id_hrm_department", TRUE))
              $kirim['id_hrm_department'] = $this->input->post("id_hrm_department", TRUE);
//            $this->debug($kirim, true);
            $hasil_in = $this->mprivilege->insert($kirim);
//            if($hasil_in){
//              if($pst['parent'][$key] > 0){
/**
 * privilege auto module
 */
//              $priv_module = $this->global_models->get("m_module");
//              foreach($priv_module as $pm){
//                if($pm->name == "juklak" OR $pm->name == "home"){
//                  $this->global_models->insert("d_privilege_module", array("id_privilege" => $hasil_in, "id_module" => $pm->id_module));
//                }
//              }
/**
 * privilege auto module
 */
/**
 * privilege auto menu
 */
//              $priv_menu = $this->global_models->get("m_menu");
//              foreach($priv_menu as $pme){
//                if($pme->name == "Kategori Juklak" OR $pme->name == "Subkategori Juklak"){
//                  $this->global_models->insert("d_privilege_menu", array("id_privilege" => $hasil_in, "id_menu" => $pme->id_menu));
//                }
//              }
/**
 * privilege auto menu
 */
/**
 * privilege auto page
 */
//              $priv_contr = $this->global_models->get("m_controller");
//              foreach($priv_contr as $pc){
//                if($pc->link == "juklak" OR $pc->link == "kategori" OR $pc->link == "subkategori" OR $pc->link == "home"){
//                  $priv_page = $this->global_models->get("m_page", array("id_controller" => $pc->id_controller));
//                  foreach($priv_page as $pp){
//                    $this->global_models->insert("d_privilege_page", array("id_privilege" => $hasil_in, "id_page" => $pp->id_page));
//                  }
//                }
//              }
/**
 * privilege auto page
 */
//              }
//              $res[] = 1;
//            }
//          }
      }
      if($hasil_in){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect ("privilege");
    }
  }
	public function delete($id){
    if($this->global_models->delete("m_privilege", array("id_privilege" => $id)))
      redirect("privilege/index/list/sukses");
    else
      redirect("privilege/index/list/filed");
  }
	public function status($id, $status){
    if($this->musers->change_status($id, $status))
      redirect("users/index/list/sukses");
    else
      redirect("users/index/list/filed");
  }
	public function export_xls(){
    $this->musers->export_xls("data-users");
  }
	public function user_set_module($id = 0, $pesan = "normal"){
    // 		-1 => unlimited memory_limit
//  ini_set('memory_limit', '-1');
    ini_set('memory_limit', '1024M');        
    $this->template->title('Sistem', "Privilege Module");
    $get_module = $this->global_models->get_query("SELECT * FROM m_module ORDER BY name ASC");
//    $get_menu = $this->global_models->get("m_menu");
    $get_menu = $this->global_models->get_query(
            "SELECT * FROM m_menu ORDER BY parent, id_menu ASC"
            );
    $get_controller = $this->global_models->get_query("SELECT * FROM m_controller ORDER BY name ASC");
    $get_all_page = $this->global_models->get_query("SELECT * FROM m_page ORDER BY link ASC");
    $get_form = $this->global_models->get_query("SELECT * FROM m_form ORDER BY name ASC");
//      $this->debug($get_module, true);
    if(!$this->input->post(NULL, TRUE)){
      $privilege_module = $this->global_models->get("d_privilege_module", array("id_privilege" => $id));
      if(is_array($get_module)){
        foreach($get_module as $ky => $gm){
            $privilege_module[$ky] = $this->global_models->get_field("d_privilege_module", "id_module", 
                    array("id_privilege" => $id, "id_module" => $gm->id_module));
        }
      }
      $privilege_menu = $this->global_models->get("d_privilege_menu", array("id_privilege" => $id));
      if(is_array($get_menu)){
        foreach($get_menu as $ky => $gm){
            $privilege_menu[$ky] = $this->global_models->get_field("d_privilege_menu", "id_menu", 
                    array("id_privilege" => $id, "id_menu" => $gm->id_menu));
        }
      }
      $privilege_form = $this->global_models->get("d_privilege_form", array("id_privilege" => $id, "status" => 1));
      $privilege_form_add = $this->global_models->get("d_privilege_form", array("id_privilege" => $id, "status" => 2));
      if(is_array($get_form)){
        foreach($get_form as $ky => $gf){
            $privilege_form[$ky] = $this->global_models->get_field("d_privilege_form", "id_form", 
                    array("id_privilege" => $id, "id_form" => $gf->id_form, "status" => 1));
            $privilege_form_add[$ky] = $this->global_models->get_field("d_privilege_form", "id_form", 
                    array("id_privilege" => $id, "id_form" => $gf->id_form, "status" => 2));
        }
      }
      if(is_array($get_controller)){
        foreach($get_controller as $ky => $gc){
          $get_page[$gc->id_controller] = $this->global_models->get_query("SELECT * FROM m_page WHERE id_controller = '{$gc->id_controller}' ORDER BY link ASC");
          $privilege_page[$gc->id_controller] = $this->global_models->get("d_privilege_page", array("id_privilege" => $id));
          if(is_array($get_page)){
            foreach($get_page[$gc->id_controller] as $ky2 => $pg){
                $privilege_page[$gc->id_controller][$ky2] = $this->global_models->get_field("d_privilege_page", "id_page", 
                        array("id_privilege" => $id, "id_page" => $pg->id_page));
            }
          }
        }
      }
//      $this->debug($get_page, true);
//      $this->debug($privilege_page, true);
      
      $foot = <<<EOD
<script>
function toggleChecked(status, id) {
  $("."+id+"_input").each( function() {
    $(this).attr("checked",status);
  })
}
</script>
EOD;
      
      $this->template->build('module-privilege', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'privilege',
              'title'   => 'Privilege '.$this->global_models->get_field("m_privilege", "name", array("id_privilege" => $id)),
              'title_form'   => $this->global_models->get_field("m_privilege", "name", array("id_privilege" => $id)),
              'detail'  => array($get_module),
              'detail_menu'  => array($get_menu),
              'detail_controller'  => array($get_controller),
              'detail_page'  => $get_page,
              'detail_form'  => array($get_form),
              'id'  => $id,
              'privilege_module'  => $privilege_module,
              'privilege_menu'  => $privilege_menu,
              'privilege_page'  => $privilege_page,
              'privilege_form'  => $privilege_form,
              'privilege_form_add'  => $privilege_form_add,
              'foot'            => $foot,
              'breadcrumb'  => array(
                    "Privilege"  => "privilege"
                ),
            ));
      $this->template
        ->set_layout('default')
        ->build('module-privilege');
    }
    else{
      $pst = $this->input->post(NULL, TRUE);
//      $this->debug($pst, true);
      if(is_array($get_module)){
        foreach($get_module as $kpst => $ps){
          $ck = 0;
          if (array_key_exists($ps->name, $pst)) {
            $ck = $this->global_models->get_field("d_privilege_module", "id_privilege_module", 
                    array("id_privilege" => $pst['id_detail'], "id_module" => $ps->id_module));
            if($ck === false){
              $this->global_models->insert("d_privilege_module", 
                      array("id_privilege" => $pst['id_detail'], 
                          "id_module" => $ps->id_module,
                          "create_by_users" => $this->session->userdata('id'),
                          "create_date" =>  date("Y-m-d H:i:s"),
                          "update_by_users" => $this->session->userdata('id')));
            }
          }
          else{
            $ck = $this->global_models->get_field("d_privilege_module", "id_privilege_module", 
                    array("id_privilege" => $pst['id_detail'], "id_module" => $ps->id_module));
            if($ck !== false)
              $this->global_models->delete("d_privilege_module", array("id_privilege" => $pst['id_detail'], "id_module" => $ps->id_module));
          }
        }
      }
      if(is_array($get_form)){
        foreach($get_form as $kgf => $gf){
          $ck = 0;
          if (array_key_exists($gf->name, $pst)) {
            $ck = $this->global_models->get_field("d_privilege_form", "id_privilege_form", 
                    array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 1));
            if($ck === false){
              $this->global_models->insert("d_privilege_form", 
                      array("id_privilege" => $pst['id_detail'], 
                          "id_form" => $gf->id_form,
                          "status" => 1,
                          "create_by_users" => $this->session->userdata('id'),
                          "create_date" =>  date("Y-m-d H:i:s"),
                          "update_by_users" => $this->session->userdata('id')));
            }
          }
          else{
            $ck = $this->global_models->get_field("d_privilege_form", "id_privilege_form", 
                    array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 1));
            if($ck !== false)
              $this->global_models->delete("d_privilege_form", array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 1));
          }
          $ck = 0;
          if (array_key_exists($gf->name."_add", $pst)) {
            $ck = $this->global_models->get_field("d_privilege_form", "id_privilege_form", 
                    array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 2));
            if($ck === false){
              $this->global_models->insert("d_privilege_form", 
                      array("id_privilege" => $pst['id_detail'], 
                          "id_form" => $gf->id_form,
                          "status" => 2,
                          "create_by_users" => $this->session->userdata('id'),
                          "create_date" =>  date("Y-m-d H:i:s"),
                          "update_by_users" => $this->session->userdata('id')));
            }
          }
          else{
            $ck = $this->global_models->get_field("d_privilege_form", "id_privilege_form", 
                    array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 2));
            if($ck !== false)
              $this->global_models->delete("d_privilege_form", array("id_privilege" => $pst['id_detail'], "id_form" => $gf->id_form, "status" => 2));
          }
        }
        $this->flush_permission_form();
      }
      if(is_array($get_menu)){
        $data_menu = $pst["menu_pv"];
//        $this->debug($data_menu);
//        $this->debug($get_menu, true);
        foreach($get_menu as $kpst => $ps){
          $ck = 0;
          if (in_array($ps->id_menu, $data_menu)) {
            $ck = $this->global_models->get_field("d_privilege_menu", "id_privilege_menu", 
                    array("id_privilege" => $pst['id_detail'], "id_menu" => $ps->id_menu));
            if($ck === false){
              $this->global_models->insert("d_privilege_menu", 
                      array("id_privilege" => $pst['id_detail'], 
                          "id_menu" => $ps->id_menu,
                          "create_by_users" => $this->session->userdata('id'),
                          "create_date" =>  date("Y-m-d H:i:s"),
                          "update_by_users" => $this->session->userdata('id')
                          ));
            }
          }
          else{
            $ck = $this->global_models->get_field("d_privilege_menu", "id_privilege_menu", 
                    array("id_privilege" => $pst['id_detail'], "id_menu" => $ps->id_menu));
            if($ck !== false)
              $this->global_models->delete("d_privilege_menu", array("id_privilege" => $pst['id_detail'], "id_menu" => $ps->id_menu));
          }
        }
      }
      if(is_array($get_all_page)){
        $data_page = $pst["page_pv"];
//        $this->debug($data_menu);
//        $this->debug($get_menu, true);
        foreach($get_all_page as $kpst => $ps){
          $ck = 0;
          if (in_array($ps->id_page, $data_page)) {
            $ck = $this->global_models->get_field("d_privilege_page", "id_privilege_page", 
                    array("id_privilege" => $pst['id_detail'], "id_page" => $ps->id_page));
            if($ck === false){
              $this->global_models->insert("d_privilege_page", 
                      array("id_privilege" => $pst['id_detail'], 
                          "id_page" => $ps->id_page,
                          "create_by_users" => $this->session->userdata('id'),
                          "create_date" =>  date("Y-m-d H:i:s"),
                          "update_by_users" => $this->session->userdata('id')
                          ));
            }
          }
          else{
            $ck = $this->global_models->get_field("d_privilege_page", "id_privilege_page", 
                    array("id_privilege" => $pst['id_detail'], "id_page" => $ps->id_page));
            if($ck !== false)
              $this->global_models->delete("d_privilege_page", array("id_privilege" => $pst['id_detail'], "id_page" => $ps->id_page));
          }
        }
      }
//      if(is_array($res))
      $this->session->set_flashdata('success', 'Data tersimpan');
      
      $list_parent = $this->get_child(0);
      $this->nbscache->put_tunggal("menu", 0, serialize($list_parent));

      $privilege = $this->global_models->get("m_privilege");
      foreach($privilege as $pvl){
        $list_per = $this->get_child(0, $pvl->id_privilege);
        $this->nbscache->put_tunggal("menu", $pvl->id_privilege, serialize($list_per));
      }
      
        redirect ("privilege/index");
//      else
//        redirect ("privilege/index/list/filed");
    }
  }
	public function flush_permission_form(){
    $data_edit = $this->global_models->get("d_privilege_form", array("status" => 1));
//    $this->debug($data_edit, true);
    $this->nbscache->clear("permission", "edit");
    foreach($data_edit as $de){
//      $this->debug($de->id_privilege);
//      $this->debug($this->global_models->get_field("m_form", "name", array("id_form" => $de->id_form)));
      $this->nbscache->put("permission", "edit", $de->id_privilege, $this->global_models->get_field("m_form", "name", array("id_form" => $de->id_form)));
    }
//    die;
    $data_add = $this->global_models->get("d_privilege_form", array("status" => 2));
    $this->nbscache->clear("permission", "add");
    foreach($data_add as $da){
      $this->nbscache->put("permission", "add", $da->id_privilege, $this->global_models->get_field("m_form", "name", array("id_form" => $da->id_form)));
    }
    return true;
  }
	public function index($action = "list", $pesan = "hal", $hal = 0){
    $list = $this->mprivilege->get();
    
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
    $menutable = "<li><a href='".site_url("privilege/add-new")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build('main', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'privilege',
            'data'    => $list,
            'title'    => "Privilege",
            'foot'        => $foot,
            'css'         => $css,
            'menutable'   => $menutable
          ));
    $this->template
      ->set_layout('datatables')
      ->build('main');
	}
  
  private function get_child($id_parent, $privilege = 0){
    if($id_parent <= 0){
      $where_parent = "parent IS NULL";
    }
    else{
      $where_parent = "parent = '{$id_parent}'";
    }
    if($privilege == 0){
      $data = $this->global_models->get_query("
        SELECT *
        FROM m_menu
        WHERE {$where_parent}
        ORDER BY sort ASC
        ");
    }
    else{
      $data = $this->global_models->get_query("
        SELECT A.*
        FROM m_menu AS A
        JOIN d_privilege_menu AS B ON A.id_menu = B.id_menu
        WHERE
        {$where_parent}
        AND B.id_privilege = {$privilege}
        GROUP BY A.id_menu
        ORDER BY A.sort ASC
        ");
    }
    
    foreach($data as $lp){
      $menu[] = array(
          "name"    =>  $lp->name,
          "icon"    =>  $lp->icon,
          "link"    =>  $lp->link,
          "child"   =>  $this->get_child($lp->id_menu, $privilege)
      );
    }
    
    return $menu;
  }
  
  public function copy($id){
    $this->template->title('Sistem', "Privilege Edit");
    if($id > 0){
      $data_detail = $this->mprivilege->get_detail($id);
//      $this->debug($data_detail, true);
    }
    else{
      $data_detail->id_privilege = "";
      $data_detail->name = "";
      $data_detail->dashbord = "";
    }
    if(!$this->input->post(NULL, TRUE)){
      $dropdown = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name", TRUE, array('parent <' => 1));
//      $this->debug($dropdown, true);
      $this->template->build('add-new', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'privilege',
              'title'   => 'Add Privilege',
              'title_form'   => 'Privilege Form',
              'detail'  => array($data_detail),
              'dropdown'  => array($dropdown),
              'breadcrumb'  => array(
                    "Privilege"  => "privilege"
                ),
            ));
      $this->template
        ->set_layout('default')
        ->build('add-new');
    }
    else{
      $pst = $this->input->post(NULL, TRUE);
      $name_parent = $this->global_models->get_field("m_privilege", "name", array("id_privilege" => $pst['parent']));
      if($name_parent !== FALSE){
        $name_with_parent = $name_parent ." - ". $pst['name'];
      }
      else{
        $name_with_parent = $pst['name'];
      }
      $kirim = array(
          'name'            =>  $name_with_parent,
          'dashbord'        =>  $pst['dashbord'],
          'parent'          =>  $pst['parent'],
      );
      $hasil_in = $this->mprivilege->insert($kirim);
      
//      batas
      $get_menu = $this->global_models->get_query(
              "SELECT * FROM m_menu ORDER BY parent, id_menu ASC"
              );
      $get_controller = $this->global_models->get("m_controller");
      $get_all_page = $this->global_models->get("m_page");
      $get_form = $this->global_models->get("m_form");
      
//      module
      $awal['module'] = $this->global_models->get("d_privilege_module", array("id_privilege" => $id));
      foreach ($awal['module'] AS $module){
        $kirim['module'][] = array(
          "id_privilege"    => $hasil_in,
          "id_module"       => $module->id_module,
          "create_by_users" => $this->session->userdata('id'),
          "create_date"     =>  date("Y-m-d H:i:s"),
        );
      }
      if($kirim['module']){
        $this->global_models->insert_batch("d_privilege_module", $kirim['module']);
      }
      
//      form
      $awal['form'] = $this->global_models->get("d_privilege_form", array("id_privilege" => $id));
      foreach ($awal['form'] AS $module){
        $kirim['form'][] = array(
          "id_privilege"    => $hasil_in,
          "id_form"         => $module->id_form,
          "status"          => 1,
          "create_by_users" => $this->session->userdata('id'),
          "create_date"     =>  date("Y-m-d H:i:s"),
        );
      }
      if($kirim['form']){
        $this->global_models->insert_batch("d_privilege_form", $kirim['form']);
      }
//      menu
      $awal['menu'] = $this->global_models->get("d_privilege_menu", array("id_privilege" => $id));
      foreach ($awal['menu'] AS $module){
        $kirim['menu'][] = array(
          "id_privilege"    => $hasil_in,
          "id_menu"         => $module->id_menu,
          "create_by_users" => $this->session->userdata('id'),
          "create_date"     =>  date("Y-m-d H:i:s"),
        );
      }
      if($kirim['menu']){
        $this->global_models->insert_batch("d_privilege_menu", $kirim['menu']);
      }
//      page
      $awal['page'] = $this->global_models->get("d_privilege_page", array("id_privilege" => $id));
      foreach ($awal['page'] AS $module){
        $kirim['page'][] = array(
          "id_privilege"    => $hasil_in,
          "id_page"         => $module->id_page,
          "create_by_users" => $this->session->userdata('id'),
          "create_date"     =>  date("Y-m-d H:i:s"),
        );
      }
      if($kirim['page']){
        $this->global_models->insert_batch("d_privilege_page", $kirim['page']);
      }
//      if(is_array($res))
      $this->session->set_flashdata('success', 'Data tersimpan');
      
      $list_parent = $this->get_child(0);
      $this->nbscache->put_tunggal("menu", 0, serialize($list_parent));

      $privilege = $this->global_models->get("m_privilege");
      foreach($privilege as $pvl){
        $list_per = $this->get_child(0, $pvl->id_privilege);
        $this->nbscache->put_tunggal("menu", $pvl->id_privilege, serialize($list_per));
      }
//      akhir
      
      if($hasil_in){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect ("privilege");
    }
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */