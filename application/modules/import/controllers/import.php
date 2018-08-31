<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends MX_Controller {
    
  function __construct() {
    $this->load->library("manimage");
  }
  
  /**
   * @author NBS, Andi Wibowo
   * @abstract penentuan gambar atau file
   * @param string $module Title dari global_variable->file_path
   * @param string|int $id ID record gambar
   */
  public function index(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/plugins/jQueryUI/jquery-ui.min.css' rel='stylesheet' type='text/css' />"
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
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/jquery.dataTables.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/datatables/dataTables.bootstrap.min.js'></script>"
			. "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/ckeditor/ckeditor.js'></script>"
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("import")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-truck'></i> ".lang("import")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('import', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "import",
        'title'       => lang("Monitor Bus"),
        'foot'        => $foot,
        'css'         => $css,
        
        'map'        => $map,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("import");
	}
	
	public function import_excel(){
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$pst = $this->input->post();
		
		$config['upload_path'] = './files/import/';
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $media = array('upload_data' => $this->upload->data());
      }
      else{
        $return = $this->upload->display_errors();
      }
    }
		$inputFileName = './files/import/'.$media['upload_data']['file_name'];
		
		try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		
		for ($row = $pst['first_row']; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
				
				echo "<pre>";
					var_dump($rowData);
				echo "</pre>";
				// die();
				//Sesuaikan sama nama kolom tabel di database                                
				 // $data = array(
						// "idimport"=> $rowData[0][0],
						// "nama"=> $rowData[0][1],
						// "alamat"=> $rowData[0][2],
						// "kontak"=> $rowData[0][3]
				// );
				 
				//sesuaikan nama dengan nama tabel
				// $insert = $this->db->insert("eimport",$data);
				$this->deleteFiles($media['upload_data']['file_path']);
		}
		die();
	}
	
	function deleteFiles($path){
    $files = glob($path.'*'); // get all file names
    foreach($files as $file){ // iterate files
      if(is_file($file))
        unlink($file); // delete file
        //echo $file.'file deleted';
    }   
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */