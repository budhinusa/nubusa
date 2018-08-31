<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends MX_Controller {
    
  function __construct() {
    $this->load->library("manimage");
  }
  
  /**
   * @author NBS, Wowo
   * @abstract penentuan gambar atau file
   * @param string $module Title dari global_variable->file_path
   * @param string|int $id ID record gambar
   */
  public function index($module, $id = NULL){
    $asal = $this->global_variable->file_path();
    $fix  = $asal[$module];
    if($fix['table'] AND $fix['field']){
      $table= $fix["table"];
      $file = $this->global_models->get_field($table, $fix['field'], array("id_".$table => $id));
    }
    else{
      $file = $id;
    }
		
		// check extension file
		$ext = pathinfo($fix['path'].$file, PATHINFO_EXTENSION);
    $ext = ($file ? $ext: 'png');
		$array_ext = array('jpg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
//    $this->debug($asal);
//    $this->debug($fix);
//    $this->debug($id, true);
    if(in_array($ext, $array_ext))
		{
			$this->get_image($file, $fix);
		}else{
			$this->get_file($file, $fix);
		}
	}
	
    //untuk m_user dan yang id fieldya beda
	//mj
	public function index1($module, $id = NULL){
    $asal = $this->global_variable->file_path();
    $fix  = $asal[$module];
    if($fix['table'] AND $fix['field']){
      $table= $fix["table"];
	  if ($fix['field_id']){ 
		$file = $this->global_models->get_field($table, $fix['field'], array($fix['field_id'] => $id));	  
	  }
	  else{
		  $file = $this->global_models->get_field($table, $fix['field'], array("id_".$table => $id));
	  }
	  
    }
    else{
      $file = $id;
    }
		
		// check extension file
		$ext = pathinfo($fix['path'].$file, PATHINFO_EXTENSION);
    $ext = ($file ? $ext: 'png');
		$array_ext = array('jpg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
    if(in_array($ext, $array_ext))
		{
			$this->get_image($file, $fix);
		}else{
			$this->get_file($file, $fix);
		}
	}
	
  public function gambar($module, $id = NULL){
    $asal = $this->global_variable->file_path();
    $fix  = $asal[$module];
    $table= $fix["table"];
    $file = $this->global_models->get_field($table, $fix['field'], array("id_".$table => $id));
		
		// check extension file
		$ext = pathinfo($file, PATHINFO_EXTENSION);
    $ext = ($file ? $ext: 'png');
		$array_ext = array('jpg', 'JPG', 'JPEG', 'png', 'PNG', 'gif', 'GIF');
		$ext = ($file ? $ext: 'png');
    if(in_array($ext, $array_ext))
		{
			$this->get_image($file, $fix);
		}else{
			$this->get_image_file();
		}
	}
	
  /**
   * @author Wowo
   * @abstract Konversi bentuk file
   * @param string $file File name
   * @param array $fix Path file dalam $fix['path']
   */
	public function get_file($file, $fix)
	{
		if(!file_exists("files/{$fix["path"]}{$file}") OR !$file)
		{
			$this->file_not_found();
		}else{
			$file_url = "files/{$fix["path"]}{$file}";
//      die($file_url);
      header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
			readfile($file_url);
      die;
		}
	}
	
  /**
   * @author Wowo
   * @abstract Konversi bentuk gambar
   * @param string $file File name
   * @param array $fix Path file dalam $fix['path']
   */
	public function get_image($file, $fix)
	{
    if(!file_exists("files/{$fix["path"]}/{$file}") OR !$file){
      print $this->manimage->load2("files/avatar.png");
    }
    else{
      print $this->manimage->load2("files/{$fix["path"]}/{$file}");
    }
    die;
	}
	public function get_image_file()
	{
    print $this->manimage->load2("files/pdf.png");
    
    die;
	}
	
	public function file_not_found()
	{
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/select2/select2.full.min.js'></script>"
      . '<script type="text/javascript">'
      . "";
		
		$this->template
      ->set_layout('default')
      ->build('file_not_found', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'foot'        => $foot,
        'css'         => $css
      ));
		
		$this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("file_not_found");
	}
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */