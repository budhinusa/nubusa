<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetmaster_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function widgetmaster_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("m_widget", array("id_m_widget" => $pst['id']));
    print "Done";die;
  }
  
  function widgetmaster_file_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("m_widget_file", array("id_m_widget_file" => $pst['id']));
    print "Done";die;
  }
  
  function widgetmaster_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("m_widget", array("id_m_widget" => $pst['id']));
		$data_file = $this->global_models->get_query("SELECT A.*"
      . " FROM m_widget_file AS A"
      . " WHERE id_m_widget = '{$data[0]->id_m_widget}'"
      . " ORDER BY A.create_date DESC"
      . "");
    $hasil = array(
      "title"                       => $data[0]->title,
      "link"                        => $data[0]->link,
      "note"                    	  => $data[0]->note,
      "id_m_widget"       					=> $data[0]->id_m_widget,
      "id_m_widget_file"       			=> $data_file[0]->id_m_widget_file,
      "title_file"       						=> $data_file[0]->title,
    );
    print json_encode($hasil);
    die;
  }
  
  function widgetmaster_set(){
    $pst = $this->input->post();
    if($pst['id_m_widget']){
      $kirim = array(
        "title"                       => $pst['title'],
        "link"                       => $pst['link'],
        "note"                        => $pst['note'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("m_widget", array("id_m_widget" => $pst['id_m_widget']), $kirim);
      $id_m_widget = $pst['id_m_widget'];
    }
    else{
      $this->global_models->generate_id($id_m_widget, "m_widget");
      $kirim = array(
        "id_m_widget"       					=> $id_m_widget,
        "title"                       => $pst['title'],
        "link"                       => $pst['link'],
        "note"                        => $pst['note'],
        "status"                      => 2,
        "create_by_users"             => $this->session->userdata("id"),
        "create_date"                 => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("m_widget", $kirim);
    }
    
    $data = $this->global_models->get("m_widget", array("id_m_widget" => $id_m_widget));

    if(!empty($pst['title_file'])){
			$image = $pst['title_file'];
		}else{
			$image = 'no_image.jpg';
		}
    $balik['id']    = $id_m_widget;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("files/widget/{$image}")."'></img>",
            "value"   => $data_file[0]->title
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->link,
            "value"   => $data[0]->link
          ),
          array(
            "view"    => $data[0]->status,
            "value"   => $data[0]->status
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_m_widget}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_m_widget,
      );
    print json_encode($balik);
    die;
  }
  
	function widgetmaster_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_widget AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
			$data_file = $this->global_models->get_query("SELECT A.*"
      . " FROM m_widget_file AS A"
      . " WHERE id_m_widget = '{$dt->id_m_widget}'"
      . " ORDER BY A.create_date DESC"
      . "");
      $button = ($dt->status == 2 ? ""
          . "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_m_widget}'><i class='fa fa-times'></i></button>"
        . "": "");
      
			if(!empty($data_file[0]->title)){
				$image = $data_file[0]->title;
			}else{
				$image = 'no_image.jpg';
			}
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("files/widget/{$image}")."'></img>",
            "value"   => $data_file[0]->title
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->link,
            "value"   => $dt->link
          ),
          array(
            "view"    => $dt->status,
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_m_widget
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function widgetmaster_file_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_widget_file AS A"
      . " WHERE A.id_m_widget = '{$pst['id_m_widget']}'"
      . " ORDER BY A.create_date DESC LIMIT {$pst['start']}, 20");
    
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->create_date,
            "value"   => $dt->create_date
          ),
          array(
            "view"    => "<a href='".site_url("file/index/widget/{$dt->id_m_widget_file}")."' target='_blank'>{$dt->title}</a>",
            "value"   => $dt->title
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete-file' isi='{$dt->id_m_widget_file}'><i class='fa fa-times'></i></button>",
            "value"   => $dt->id_m_widget_file,
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_m_widget_file
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function widgetmaster_file_upload(){
    $pst = $this->input->post();
		
    $config['upload_path'] = './files/widget/';
    $config['allowed_types'] = 'png|jpg|jpeg|doc|docx|pdf|xls|xlsx';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $avatar = array('upload_data' => $this->upload->data());
      }
      else{
        $status = 1;
        $link = '';
        $return = $this->upload->display_errors();
      }
    }
    if($avatar['upload_data']['file_name']){
      $status = 2;
      $return = $avatar['upload_data']['file_name'];
    }
    
    $this->global_models->generate_id($id_m_widget_file, "m_widget_file");
    $kirim = array(
      "id_m_widget_file"        => $id_m_widget_file,
      "id_m_widget"             => $pst['id_m_widget'],
      "title"                           => $return,
      "tanggal"                         => date("Y-m-d H:i:s"),
      "create_by_users"                 => $this->session->userdata("id"),
      "create_date"                     => date("Y-m-d H:i:s"),
    );
    
		# -- Bug "cek semua tempat upload file" --
		$link =  "<a href='".site_url("file/index/widget/{$id_m_widget_file}")."' target='_blank'>{$return}</a>";
    # -----------------------------
    $this->global_models->insert("m_widget_file", $kirim);
    
    $balik['id']    	= $id_m_widget_file;
    $balik['id_m_widget']    	= $id_m_widget;
    $balik['status']  = $status;
    $balik['link']    = $link;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $kirim['tanggal'],
            "value"   => $kirim['tanggal']
          ),
          array(
            "view"    => $link,
            "value"   => $link
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_m_widget_file}'><i class='fa fa-times'></i></button>",
            "value"   => $id_m_widget_file
          ),
        ),
        "select"  => true,
        "id"      => $id_m_widget_file,
      );
    print json_encode($balik);
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */