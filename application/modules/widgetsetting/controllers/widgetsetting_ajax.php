<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widgetsetting_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
		$this->load->library('nbscache');
  }
  
  function widgetsetting_get_detail(){
    $pst = $this->input->post();
		$widgets_new = array();
		$widgets = $this->global_models->get_query("SELECT A.*,"
      . " (SELECT b.title from m_widget_file AS b where b.id_m_widget = A.id_m_widget LIMIT 0,1) AS title_file,"
      . " (SELECT b.id_m_widget_file from m_widget_file AS b where b.id_m_widget = A.id_m_widget LIMIT 0,1) AS title_file_link"
      . " FROM m_widget AS A"
			. " ORDER BY A.create_date DESC"
      . " ");
			
		foreach($widgets as $idx=>$val){
			$cache = $this->nbscache->get_explode("widgets",$val->id_m_widget.'|'.$pst['id']);	
			$data_cache = unserialize($cache[1]);
			
			$widgets_new[$idx]->id_m_widget = $val->id_m_widget;
			$widgets_new[$idx]->id_m_widget_val = $data_cache['id_m_widget'];
			$widgets_new[$idx]->title = strtoupper($val->title);
			$widgets_new[$idx]->link = $val->link;
			if(!empty($val->title_file))
					$image = $val->title_file;
			else
					$image = 'no-image.jpg';
			$widgets_new[$idx]->title_file_link = site_url('file/index/widget/'.$val->title_file_link);
			$widgets_new[$idx]->title_file = site_url('files/widget/'.$image);
			$widgets_new[$idx]->class = "id_m_widget_" . $idx;
			
			// GET DATA ID WIDGET VAL
			$id_widgets_val[] = $data_cache['id_m_widget'];
		}
		
    $hasil = array(
      "id_users"                    => $pst['id'],
      "id_widgets_val"              => $id_widgets_val,
      "widgets"                			=> $widgets_new
    );
    print json_encode($hasil);
    die;
  }
  
  function widgetsetting_set(){
    $pst = $this->input->post();
		
		# --- HAPUS DATA YANG SEBELUMNYA --
		$this->db->select('*');
		$this->db->from('m_widget');
		$this->db->where_not_in($pst['id_widgets']);
		$result = $this->db->get()->result();
		foreach($result as $idx=>$val){
			#-- BUAT HAPUS --
			$this->nbscache->clear("widgets", $val->id_m_widget ."|". $pst['id_users'],"", "");
		}
		
		# -- INSERT DATA BARU ---
		foreach($pst['id_widgets'] as $idx => $val){
			$data_widget = $this->global_models->get_query("SELECT A.*"
				. " FROM m_widget AS A"
				. " WHERE id_m_widget = '{$val}'"
				. " ORDER BY A.create_date DESC"
				. "");
			$this->global_models->generate_id($id_m_widget_setting, "m_widget_setting");
			$kirim = array(
				"id_m_widget_setting"       				=> $id_m_widget_setting,
				"id_m_widget"                       => $data_widget[0]->id_m_widget,
				"title"                    				  => $data_widget[0]->title,
				"link"                       				=> $data_widget[0]->link,
				"id_users"                      		=> $pst['id_users']
			);
			#-- BUAT INSERT --
			$this->nbscache->put_tunggal("widgets", $val ."|". $pst['id_users'], serialize($kirim));
		}
    
    // $data = $this->global_models->get("m_widget", array("id_m_widget" => $id_m_widget));

    // if(!empty($pst['title_file'])){
			// $image = $pst['title_file'];
		// }else{
			// $image = 'no_image.jpg';
		// }
    // $balik['id']    = $id_m_widget;
    // $balik['data']  = array(
        // "data"    => array(
          // array(
            // "view"    => "<img width='60px' height='40px' src='".site_url("files/widget/{$image}")."'></img>",
            // "value"   => $data_file[0]->title
          // ),
          // array(
            // "view"    => $data[0]->title,
            // "value"   => $data[0]->title
          // ),
          // array(
            // "view"    => $data[0]->link,
            // "value"   => $data[0]->link
          // ),
          // array(
            // "view"    => $data[0]->status,
            // "value"   => $data[0]->status
          // ),
          // array(
            // "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_m_widget}'><i class='fa fa-times'></i></button>",
            // "value"   => 0
          // ),
        // ),
        // "select"  => true,
        // "id"      => $id_m_widget,
      // );
    print json_encode($balik);
    die;
  }
  
	function users_get(){
    $pst = $this->input->post();
		
		$where = "";
		if($this->session->userdata('id') != 1)
			$where = "WHERE id_users = {$this->session->userdata('id')}";
		
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM m_users AS A"
      . " {$where}"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->name,
            "value"   => $dt->name
          ),
          array(
            "view"    => $dt->email,
            "value"   => $dt->email
          ),
          array(
            "view"    => $dt->status,
            "value"   => $dt->status
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_users
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */