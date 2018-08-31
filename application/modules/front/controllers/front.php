<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
	public function banner(){
    $list = $this->global_models->get("front_banner");
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= '<script type="text/javascript">
                $(function() {
                    $("#tableboxy").dataTable();
                });
            </script>';
    $menutable = '
      <li><a href="'.site_url("front/add-banner").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    
    $this->template
      ->set_layout('datatables')
      ->build('banner', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "front/banner",
        'data'        => $list,
        'title'       => lang("Banner"),
        'foot'        => $foot,
        'css'         => $css,
        'menutable'   => $menutable,
      ));
    $this->template
      ->set_layout('datatables')
      ->build("banner");
	}
  
	public function banner_promosi(){
    $list = $this->global_models->get("front_banner_promosi");
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= '<script type="text/javascript">
                $(function() {
                    $("#tableboxy").dataTable();
                });
            </script>';
    $menutable = '
      <li><a href="'.site_url("front/add-banner-promosi").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    
    $this->template
      ->set_layout('datatables')
      ->build('banner-promosi', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "front/banner",
        'data'        => $list,
        'title'       => lang("Banner Promosi"),
        'foot'        => $foot,
        'css'         => $css,
        'menutable'   => $menutable,
      ));
    $this->template
      ->set_layout('datatables')
      ->build("banner-promosi");
	}
  
  function add_banner($id_front_banner = 0){
    $pst = $this->input->post();
    if($pst){
      $config['upload_path'] = './files/umroh/banner/';
      $config['allowed_types'] = 'png|jpg';
      $config['max_width']  = '2000';
      $config['max_height']  = '2000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("front/add-banner/".$id_front_banner)."'>Back</a>";
          die;
        }
      }
      if($pst['id_detail']){
        $kirim = array(
          "title"           => $pst['title'],
          "url"             => $pst['url'],
          "note1"           => $pst['note1'],
          "note2"           => $pst['note2'],
          "note3"           => $pst['note3'],
          "mulai"           => $pst['mulai'],
          "akhir"           => $pst['akhir'],
          "status"          => $pst['status'],
          "sort"            => $pst['sort'],
          "update_by_users" => $this->session->userdata("id")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_front_banner = $this->global_models->update("front_banner", array("id_front_banner" => $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
          "title"           => $pst['title'],
          "url"             => $pst['url'],
          "note1"           => $pst['note1'],
          "note2"           => $pst['note2'],
          "note3"           => $pst['note3'],
          "mulai"           => $pst['mulai'],
          "akhir"           => $pst['akhir'],
          "status"          => $pst['status'],
          "sort"            => $pst['sort'],
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_front_banner = $this->global_models->insert("front_banner", $kirim);
      }
      if($id_front_banner){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("front/banner");
    }
    $detail = $this->global_models->get("front_banner", array("id_front_banner" => $id_front_banner));
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
      . "<script type='text/javascript'>"
        . "$(function() { "
          . "$( '.tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
      . "</script> ";
    
    $this->template
      ->build('add-banner', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "front/banner",
        'detail'      => $detail,
        'title'       => lang("Form Banner"),
        'foot'        => $foot,
        'css'         => $css,
        'menutable'   => $menutable,
      ));
    $this->template
      ->set_layout('form')
      ->build("add-banner");
  }
  
  function add_banner_promosi($id_front_banner_promosi){
    $pst = $this->input->post();
    if($pst){
      $config['upload_path'] = './files/umroh/slide2/';
      $config['allowed_types'] = 'png|jpg';
      $config['max_width']  = '2000';
      $config['max_height']  = '2000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("front/add-banner-promosi/".$id_front_banner_promosi)."'>Back</a>";
          die;
        }
      }
      if($pst['id_detail']){
        $kirim = array(
          "title"           => $pst['title'],
          "sub_title"       => $pst['sub_title'],
          "url"             => $pst['url'],
          "mulai"           => $pst['mulai'],
          "akhir"           => $pst['akhir'],
          "status"          => $pst['status'],
          "sort"            => $pst['sort'],
          "note"            => $pst['note'],
          "update_by_users" => $this->session->userdata("id")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_front_banner_promosi = $this->global_models->update("front_banner_promosi", array("id_front_banner_promosi" => $pst['id_detail']), $kirim);
      }
      else{
        $kirim = array(
          "title"           => $pst['title'],
          "sub_title"       => $pst['sub_title'],
          "url"             => $pst['url'],
          "mulai"           => $pst['mulai'],
          "akhir"           => $pst['akhir'],
          "status"          => $pst['status'],
          "sort"            => $pst['sort'],
          "note"            => $pst['note'],
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_front_banner_promosi = $this->global_models->insert("front_banner_promosi", $kirim);
      }
      if($id_front_banner_promosi){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("front/banner-promosi");
    }
    
    $list = $this->global_models->get("front_banner_promosi", array("id_front_banner_promosi" => $id_front_banner_promosi));
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
      . "<script type='text/javascript'>"
        . "$(function() {"
          . "CKEDITOR.replace('editor2');"
          . "$( '.tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
      . "</script> ";
    
    $this->template
      ->build('add-banner-promosi', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "front/banner",
        'detail'      => $list,
        'title'       => lang("Form Banner Promosi"),
        'foot'        => $foot,
        'css'         => $css,
        'menutable'   => $menutable,
      ));
    $this->template
      ->set_layout('form')
      ->build("add-banner-promosi");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */