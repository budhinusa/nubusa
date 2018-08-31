<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_ajax extends MX_Controller {
    
  function __construct() {      
    // $this->menu = $this->cek();
  }
  
	function gallery_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_gallery", array("id_cms_gallery" => $pst['id']));
    print "Done";die;
  }
  
  function gallery_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_gallery", array("id_cms_gallery" => $pst['id']));

    $hasil = array(
      "title"                       => $data[0]->title,
      "file"                        => $data[0]->file,
      "status"                      => $data[0]->status,
      "id_cms_gallery"     					=> $data[0]->id_cms_gallery,
      "id_cms_kategori"     					=> $data[0]->id_cms_kategori,
      "title_file"       						=> site_url("file/index/cms_gallery/" . $data[0]->id_cms_gallery),
    );
    print json_encode($hasil);
    die;
  }
  
  function gallery_set(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
		
		$config['upload_path'] = './files/cms/gallery/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $file = array('upload_data' => $this->upload->data());
      }
      else{
        $return = $this->upload->display_errors();
      }
    }
		
    if($pst['id_cms_gallery']){
			$kirim = array(
				"title"                       => $pst['title'],
				"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
				"status"                       => $pst['status'],
				"id_cms_kategori"                       => $pst['id_cms_kategori'],
				"update_by_users"             => $this->session->userdata("id"),
			);
			$this->global_models->update("cms_gallery", array("id_cms_gallery" => $pst['id_cms_gallery']), $kirim);
			$id_cms_gallery = $pst['id_cms_gallery'];
    }
    else{
			$this->global_models->generate_id($id_cms_gallery, "cms_gallery");
			$kirim = array(
				"id_cms_gallery"       => $id_cms_gallery,
				"title"                       => $pst['title'],
				"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
				"status"                       => $pst['status'],
				"id_cms_kategori"                       => $pst['id_cms_kategori'],
				"create_by_users"             => $this->session->userdata("id"),
				"create_date"                 => date("Y-m-d H:i:s")
			);
			$this->global_models->insert("cms_gallery", $kirim);
    }
		
		if(!empty($file['upload_data']['file_name']) || $pst['file']){
			$image = "file/index/cms_gallery/" . $id_cms_gallery;
		}else{
			$image = 'files/no-picture.png';
		}
		
		if($pst['status'] == 1){
			$status = '<label class="label label-danger">Draft</label>';
		}elseif($pst['status'] == 2){
			$status = '<label class="label label-primary">Aktif</label>';
		}
		
    $balik['id']    = $id_cms_gallery;
    $balik['data']  = array(
        "data"    => array(
					array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $pst['file']
          ),
          array(
            "view"    => $pst['title'],
            "value"   => $pst['title']
          ),
          array(
            "view"    => $status,
            "value"   => $pst['status']
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_cms_gallery}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_cms_gallery,
      );
    print json_encode($balik);
    die;
  }
  
	function gallery_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_gallery AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_cms_gallery}'><i class='fa fa-times'></i></button>";
			
			if(!empty($dt->file)){
				$image = "file/index/cms_gallery/" . $dt->id_cms_gallery;
			}else{
				$image = 'files/no-picture.png';
			}
			
			if($dt->status == 1){
				$status = '<label class="label label-danger">Draft</label>';
			}elseif($dt->status == 2){
				$status = '<label class="label label-primary">Aktif</label>';
			}
			
			
      $hasil['data'][] = array(
        "data"    => array(
					array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $dt->file
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $status,
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_gallery
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
  function page_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_page", array("id_cms_page" => $pst['id']));
    print "Done";die;
  }
  
  function page_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_page", array("id_cms_page" => $pst['id']));

    $hasil = array(
      "title"                       => $data[0]->title,
      "file"                        => $data[0]->file,
      "link"                        => $data[0]->link,
      "sort"                    	  => $data[0]->sort,
      "status"                      => $data[0]->status,
      "start_date"                  => $data[0]->start_date,
      "end_date"                    => $data[0]->end_date,
      "note"                    	  => $data[0]->note,
      "id_cms_page"     	=> $data[0]->id_cms_page,
      "title_file"       						=> site_url("file/index/cms_page/" . $data[0]->id_cms_page),
    );
    print json_encode($hasil);
    die;
  }
  
  function page_set(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
		
		$config['upload_path'] = './files/cms/page/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $file = array('upload_data' => $this->upload->data());
      }
      else{
        $return = $this->upload->display_errors();
      }
    }
		
    if($pst['id_cms_page']){
			# -- CHECK LINK AVAILABILITY --
			$this->db->where('link',$pst['link']);
			$check = $this->db->get('cms_page')->row();

			if(!empty($check)){
				$this->db->where('id_cms_page',$pst['id_cms_page']);
				$check1 = $this->db->get('cms_page')->row();
				if($check1->link <> $pst['link']){
					$balik['status']    = 0;
				}else{
					$kirim = array(
						"title"                       => $pst['title'],
						"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
						"link"                       => $pst['link'],
						"status"                       => $pst['status'],
						"note"                        => $pst['note'],
						"update_by_users"             => $this->session->userdata("id"),
					);
					$this->global_models->update("cms_page", array("id_cms_page" => $pst['id_cms_page']), $kirim);
					$id_cms_page = $pst['id_cms_page'];
					$balik['status']    = 2;
				}
			}else{
				$kirim = array(
					"title"                       => $pst['title'],
					"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
					"link"                       => $pst['link'],
					"status"                       => $pst['status'],
					"note"                        => $pst['note'],
					"update_by_users"             => $this->session->userdata("id"),
				);
				$this->global_models->update("cms_page", array("id_cms_page" => $pst['id_cms_page']), $kirim);
				$id_cms_page = $pst['id_cms_page'];
				$balik['status']    = 2;
			}
    }
    else{
			# -- CHECK LINK AVAILABILITY --
			$this->db->where('link',$pst['link']);
			$check = $this->db->get('cms_page')->row();
			
			if(empty($check)){
				$this->global_models->generate_id($id_cms_page, "cms_page");
				$kirim = array(
					"id_cms_page"       => $id_cms_page,
					"title"                       => $pst['title'],
					"file"                       => $file['upload_data']['file_name'],
					"link"                       => $pst['link'],
					"status"                       => $pst['status'],
					"note"                        => $pst['note'],
					"create_by_users"             => $this->session->userdata("id"),
					"create_date"                 => date("Y-m-d H:i:s")
				);
				$this->global_models->insert("cms_page", $kirim);
				$balik['status']    = 2;
			}else{
				$balik['status']    = 0;
			}
    }

    if(!empty($file['upload_data']['file_name']) || $pst['file']){
			$image = "file/index/cms_page/" . $id_cms_page;
		}else{
			$image = 'files/no-picture.png';
		}
		
		if($pst['status'] == 1){
			$status = '<label class="label label-danger">Draft</label>';
		}elseif($pst['status'] == 2){
			$status = '<label class="label label-primary">Aktif</label>';
		}
		
    $balik['id']    = $id_cms_page;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $pst['file']
          ),
          array(
            "view"    => $pst['title'],
            "value"   => $pst['title']
          ),
          array(
            "view"    => "<a href='".site_url('cms/gallery/' . $pst['link'])."' target='_blank'>".$pst['link']."</a>",
            "value"   => $pst['link']
          ),
          array(
            "view"    => $status,
            "value"   => $pst['status']
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_cms_page}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_cms_page,
      );
    print json_encode($balik);
    die;
  }
  
	function page_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_page AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_cms_page}'><i class='fa fa-times'></i></button>";
      
			if(!empty($dt->file)){
				$image = "file/index/cms_page/" . $dt->id_cms_page;
			}else{
				$image = 'files/no-picture.png';
			}
			
			if($dt->status == 1){
				$status = '<label class="label label-danger">Draft</label>';
			}elseif($dt->status == 2){
				$status = '<label class="label label-primary">Aktif</label>';
			}
			
			
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $dt->file
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => "<a href='".site_url('cms/page/' . $dt->link)."' target='_blank'>".$dt->link."</a>",
            "value"   => $dt->link
          ),
          array(
            "view"    => $status,
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_page
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function kategori_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_kategori", array("id_cms_kategori" => $pst['id']));
    print "Done";die;
  }
  
  function kategori_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_kategori", array("id_cms_kategori" => $pst['id']));

    $hasil = array(
      "title"                       => $data[0]->title,
      "id_cms_kategori"     	=> $data[0]->id_cms_kategori,
      "title_file"       						=> site_url("file/index/cms_kategori/" . $data[0]->id_cms_kategori),
    );
    print json_encode($hasil);
    die;
  }
  
  function kategori_set(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
		
    if($pst['id_cms_kategori']){
			$kirim = array(
				"title"                       => $pst['title'],
				"update_by_users"             => $this->session->userdata("id"),
			);
			$this->global_models->update("cms_kategori", array("id_cms_kategori" => $pst['id_cms_kategori']), $kirim);
			$id_cms_kategori = $pst['id_cms_kategori'];
			$balik['status']    = 2;
    }
    else{
			$this->global_models->generate_id($id_cms_kategori, "cms_kategori");
			$kirim = array(
				"id_cms_kategori"       => $id_cms_kategori,
				"title"                       => $pst['title'],
				"create_by_users"             => $this->session->userdata("id"),
				"create_date"                 => date("Y-m-d H:i:s")
			);
			$this->global_models->insert("cms_kategori", $kirim);
			$balik['status']    = 2;
    }
		
    $balik['id']    = $id_cms_kategori;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $pst['title'],
            "value"   => $pst['title']
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_cms_kategori}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_cms_kategori,
      );
    print json_encode($balik);
    die;
  }
  
	function kategori_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_kategori AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_cms_kategori}'><i class='fa fa-times'></i></button>";
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_kategori
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function article_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_article", array("id_cms_article" => $pst['id']));
    print "Done";die;
  }
  
  function article_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_article", array("id_cms_article" => $pst['id']));

    $hasil = array(
      "title"                       => $data[0]->title,
      "file"                        => $data[0]->file,
      "link"                        => $data[0]->link,
      "sort"                    	  => $data[0]->sort,
      "status"                      => $data[0]->status,
      "start_date"                  => $data[0]->start_date,
      "end_date"                    => $data[0]->end_date,
      "note"                    	  => $data[0]->note,
      "id_cms_article"    				 	=> $data[0]->id_cms_article,
      "id_cms_kategori"     				=> $data[0]->id_cms_kategori,
      "type"     				=> $data[0]->type,
      "title_file"       						=> site_url("file/index/cms_article/" . $data[0]->id_cms_article),
    );
    print json_encode($hasil);
    die;
  }
  
  function article_set(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
		
		$config['upload_path'] = './files/cms/article/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $file = array('upload_data' => $this->upload->data());
      }
      else{
        $return = $this->upload->display_errors();
      }
    }
		
    if($pst['id_cms_article']){
			# -- CHECK LINK AVAILABILITY --
			$this->db->where('link',$pst['link']);
			$check = $this->db->get('cms_article')->row();

			if(!empty($check)){
				$this->db->where('id_cms_article',$pst['id_cms_article']);
				$check1 = $this->db->get('cms_article')->row();
				if($check1->link <> $pst['link']){
					$balik['status']    = 0;
				}else{
					$kirim = array(
						"title"                       => $pst['title'],
						"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
						"link"                       => $pst['link'],
						"status"                       => $pst['status'],
						"id_cms_kategori"                       => $pst['id_cms_kategori'],
						"type"                       => $pst['type'],
						"note"                        => $pst['note'],
						"update_by_users"             => $this->session->userdata("id"),
					);
					$this->global_models->update("cms_article", array("id_cms_article" => $pst['id_cms_article']), $kirim);
					$id_cms_article = $pst['id_cms_article'];
					$balik['status']    = 2;
				}
			}else{
				$kirim = array(
					"title"                       => $pst['title'],
					"file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
					"link"                       => $pst['link'],
					"status"                       => $pst['status'],
					"id_cms_kategori"                       => $pst['id_cms_kategori'],
					"type"                       => $pst['type'],
					"note"                        => $pst['note'],
					"update_by_users"             => $this->session->userdata("id"),
				);
				$this->global_models->update("cms_article", array("id_cms_article" => $pst['id_cms_article']), $kirim);
				$id_cms_article = $pst['id_cms_article'];
				$balik['status']    = 2;
			}
    }
    else{
			# -- CHECK LINK AVAILABILITY --
			$this->db->where('link',$pst['link']);
			$check = $this->db->get('cms_article')->row();
			
			if(empty($check)){
				$this->global_models->generate_id($id_cms_article, "cms_article");
				$kirim = array(
					"id_cms_article"       => $id_cms_article,
					"title"                       => $pst['title'],
					"file"                       => $file['upload_data']['file_name'],
					"link"                       => $pst['link'],
					"status"                       => $pst['status'],
					"id_cms_kategori"             => $pst['id_cms_kategori'],
					"type"                       => $pst['type'],
					"note"                        => $pst['note'],
					"create_by_users"             => $this->session->userdata("id"),
					"create_date"                 => date("Y-m-d H:i:s")
				);
				$this->global_models->insert("cms_article", $kirim);
				$balik['status']    = 2;
			}else{
				$balik['status']    = 0;
			}
    }

    if(!empty($file['upload_data']['file_name']) || $pst['file']){
			$image = "file/index/cms_article/" . $id_cms_article;;
		}else{
			$image = 'files/no-picture.png';
		}
		
		if($pst['status'] == 1){
			$status = '<label class="label label-danger">Draft</label>';
		}elseif($pst['status'] == 2){
			$status = '<label class="label label-primary">Aktif</label>';
		}
		
		$type = $this->global_variable->cms_article_type(1);
		
		$this->db->where('id_cms_kategori', $pst['id_cms_kategori']);
		$kategori = $this->db->get('cms_kategori')->row();
		
		
    $balik['id']    = $id_cms_article;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $pst['file']
          ),
          array(
            "view"    => $pst['title'],
            "value"   => $pst['title']
          ),
          array(
            "view"    => "<a href='".site_url('cms/article/' . $pst['link'])."' target='_blank'>".$pst['link']."</a>",
            "value"   => $pst['link']
          ),
          array(
            "view"    => $status,
            "value"   => $pst['status']
          ),
					array(
            "view"    => $kategori->title,
            "value"   => $kategori->title
          ),
					array(
            "view"    => $type[$pst['type']],
            "value"   => $pst['type']
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_cms_article}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_cms_article,
      );
    print json_encode($balik);
    die;
  }
  
	function article_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*, B.title kategori"
      . " FROM cms_article AS A"
      . " LEFT JOIN cms_kategori B ON B.id_cms_kategori = A.id_cms_kategori"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_cms_article}'><i class='fa fa-times'></i></button>";
      
			if(!empty($dt->file)){
				$image = "file/index/cms_article/" . $dt->id_cms_article;
			}else{
				$image = 'files/no-picture.png';
			}
			
			if($dt->status == 1){
				$status = '<label class="label label-danger">Draft</label>';
			}elseif($dt->status == 2){
				$status = '<label class="label label-primary">Aktif</label>';
			}
			
			$type = $this->global_variable->cms_article_type(1);
			
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $dt->file
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => "<a href='".site_url('cms/article/' . $dt->link)."' target='_blank'>".$dt->link."</a>",
            "value"   => $dt->link
          ),
          array(
            "view"    => $status,
            "value"   => $dt->status
          ),
					array(
            "view"    => $dt->kategori,
            "value"   => $dt->kategori
          ),
					array(
            "view"    => $type[$dt->type],
            "value"   => $dt->type
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_article
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function comment_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_comment", array("id_cms_comment" => $pst['id']));
    print "Done";die;
  }
	
	function comment_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();

    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_comment AS A"
      . " WHERE A.id_cms_article = '{$pst['id']}'"
      . " ORDER BY A.create_date DESC"
      // . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete_comment' isi='{$dt->id_cms_comment}'><i class='fa fa-times'></i></button>";
			
			if($dt->status == 1){
				$status = '<label class="label label-danger">Draft</label>';
			}elseif($dt->status == 2){
				$status = '<label class="label label-primary">Aktif</label>';
			}
			
			
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
					array(
            "view"    => $dt->note,
            "value"   => $dt->note
          ),
          array(
            "view"    => $status,
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_comment
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	function service_delete(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $this->global_models->delete("cms_service", array("id_cms_service" => $pst['id']));
    print "Done";die;
  }
  
  function service_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_service", array("id_cms_service" => $pst['id']));

    $hasil = array(
      "title"                       => $data[0]->title,
      "file"                        => $data[0]->file,
      "link"                        => $data[0]->link,
      "sort"                    	  => $data[0]->sort,
      "status"                      => $data[0]->status,
      "start_date"                  => $data[0]->start_date,
      "end_date"                    => $data[0]->end_date,
      "note"                    	  => $data[0]->note,
      "id_cms_service"     	=> $data[0]->id_cms_service,
      "title_file"       						=> site_url("file/index/cms_service/" . $data[0]->id_cms_service),
    );
    print json_encode($hasil);
    die;
  }
  
  function service_set(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
		
		$config['upload_path'] = './files/cms/service/';
    $config['allowed_types'] = 'png|jpg|jpeg';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $file = array('upload_data' => $this->upload->data());
      }
      else{
        $return = $this->upload->display_errors();
      }
    }
		
    if($pst['id_cms_service']){
      $kirim = array(
        "title"                       => $pst['title'],
        "file"                       => isset($file['upload_data']['file_name']) ? $file['upload_data']['file_name'] : $pst['file'],
        "link"                       => $pst['link'],
        "sort"                       => $pst['sort'],
        "status"                       => $pst['status'],
        "note"                        => $pst['note'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("cms_service", array("id_cms_service" => $pst['id_cms_service']), $kirim);
      $id_cms_service = $pst['id_cms_service'];
    }
    else{
			$this->global_models->generate_id($id_cms_service, "cms_service");
      $kirim = array(
        "id_cms_service"       => $id_cms_service,
        "title"                       => $pst['title'],
        "file"                       => $file['upload_data']['file_name'],
        "link"                       => $pst['link'],
        "sort"                       => $pst['sort'],
        "status"                       => $pst['status'],
        "note"                        => $pst['note'],
        "create_by_users"             => $this->session->userdata("id"),
        "create_date"                 => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("cms_service", $kirim);
    }

    if(!empty($file['upload_data']['file_name'])){
			$image = "file/index/cms_service/" . $id_cms_service;;
		}else{
			$image = 'files/no-picture.png';
		}
		
		if($pst['status'] == 1){
			$status = '<label class="label label-primary">Aktif</label>';
		}elseif($pst['status'] == 2){
			$status = '<label class="label label-info">Promo</label>';
		}elseif($pst['status'] == 3){
			$status = '<label class="label label-danger">Draft</label>';
		}
		
    $balik['id']    = $id_cms_service;
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $pst['file']
          ),
          array(
            "view"    => $pst['title'],
            "value"   => $pst['title']
          ),
          array(
            "view"    => $pst['link'],
            "value"   => $pst['link']
          ),
					array(
            "view"    => $pst['sort'],
            "value"   => $pst['sort']
          ),
          array(
            "view"    => $status,
            "value"   => $pst['status']
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_cms_service}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_cms_service,
      );
    print json_encode($balik);
    die;
  }
  
	function service_get(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_service AS A"
      . " ORDER BY A.sort ASC, A.status ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_cms_service}'><i class='fa fa-times'></i></button>";
      
			if(!empty($dt->file)){
				$image = "file/index/cms_service/" . $dt->id_cms_service;
			}else{
				$image = 'files/no-picture.png';
			}
			
			if($dt->status == 1){
				$status = '<label class="label label-primary">Aktif</label>';
			}elseif($dt->status == 2){
				$status = '<label class="label label-info">Promo</label>';
			}elseif($dt->status == 3){
				$status = '<label class="label label-danger">Draft</label>';
			}
			
			
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => "<img width='60px' height='40px' src='".site_url("{$image}")."'></img>",
            "value"   => $dt->file
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
            "view"    => $dt->sort,
            "value"   => $dt->sort
          ),
          array(
            "view"    => $status,
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_cms_service
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
	
	# -- PUBLIC FUNCTION --
	function comment_set(){
    $pst = $this->input->post();

		if(!empty($this->session->userdata("id")))
		{		
			$this->global_models->generate_id($id_cms_comment, "cms_comment");
			$kirim = array(
				"id_cms_comment"    		   => $id_cms_comment,
				"id_cms_article"            => $pst['id_cms_article'],
				"status"                       => 2,
				"note"                        => $pst['comment'],
				"create_by_users"             => $this->session->userdata("id"),
				"create_date"                 => date("Y-m-d H:i:s")
			);
			$this->global_models->insert("cms_comment", $kirim);
			
			$balik['id']    		= $id_cms_comment;
			$balik['status']    = 2;
		}else{
			$balik['status']    = 1;
		}
		
    print json_encode($balik);
    die;
  }
	
	function artikel_public_get(){
		$pst = $this->input->post();
		
		$where = '';
		if(!empty($pst['type'])){
			$where .= "AND A.type = {$pst['type']}";
		}
		$data_array = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.name FROM m_users AS B WHERE B.id_users = A.create_by_users) AS users"
      . " ,(SELECT C.title FROM cms_kategori AS C WHERE C.id_cms_kategori = A.id_cms_kategori) AS kategori"
      . " FROM cms_article AS A"
      . " WHERE A.status = 2"
      . " {$where}"
      // . " ORDER BY {$sort}"
      . " LIMIT {$pst['start']}, 10");
		
		$url = base_url()."themes/antavaya/";
		
		foreach($data_array AS $ky => $data){
			$id = $data->id_cms_article;			
			# --- ADITIONAL DATA --
			
			if($data->file){
				$gambar = base_url()."file/index/cms-article/{$id}";
			}
			else{
				$gambar = base_url()."files/no-picture.png";
			}
			$link = site_url("cms/article/" . $data->link);
			$content = $this->read_more(str_replace("&nbsp;"," ", $data->note), 250);

			$view = <<<EOD
          <div class="list">
							<div class="col-md-6 col-sm-6 col-xs-12">
									<img src="{$gambar}" alt="" />
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
									<h3>{$data->title}</h3>
									<h5><span class="post_author">Author: {$data->users}</span><span class="post_date">Date: {$data->create_date}</span></h5>
									<p>{$content}</p>
									<a href="{$link}" class="link-btn">Read more</a>
							</div>
					</div>
EOD;
			
			$view .= "
					<style>
						/*-------------------------------------------------------*/
						/* PAGE: BLOG POSTS
						/*-------------------------------------------------------*/

						.list {
								position: relative;
								overflow: hidden;
								width: 100%;
								margin-bottom: 50px;
						}
						.list img {
								width: 100%;
						}
						.list h3 {
								color: #212627;
								margin-top: 0px;
								padding-bottom: 5px;
								text-transform: capitalize;
						}
						.list h5 {
								font-family: 'Lato', sans-serif;
								font-style: italic;
								font-weight: 600;
								font-size: 16px;
								margin-bottom: 25px;
						}
						.list p {
								text-align: left;
								color: #868686;
								line-height: 25px;
								margin-bottom: 25px;
						}
						.list a {} .post_author {} .post_date {
								color: #8a8a8a;
								padding-left: 8px;
								font-weight: 500;
						}
						.link-btn {
								background: #ffc107;
								color: #000;
								font-weight: 600;
								border-radius: 2px;
								padding: 2px 8px;
								text-decoration: none;
								display: inline-block;
								cursor: pointer;
								color: #000;
								/* font-family: Arial; */
								
								font-size: 14px;
								text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.62);
								transition: all 0.5s ease;
								-webkit-transition: all 0.5s ease;
								-moz-transition: all 0.5s ease;
								-ms-transition: all 0.5s ease;
								-o-transition: all 0.5s ease;
						}
						.link-btn:hover {
								background-color: #00bcd4;
								transition: all 0.5s ease;
								-webkit-transition: all 0.5s ease;
								-moz-transition: all 0.5s ease;
								-ms-transition: all 0.5s ease;
								-o-transition: all 0.5s ease;
								color: #000;
								text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.62);
								box-shadow: 0px 1px 0px 0px #048d9e;
								-webkit-box-shadow: 0px 1px 0px 0px #048d9e;
								-moz-box-shadow: 0px 1px 0px 0px #048d9e;
						}
					</style>
			";
			
			$hasil['data'][] = array(
				"data"    => array(
					array(
						"view"    => $view,
						"value"   => 1
					),
					array(
						"view"    => "",
						"value"   => $data->create_date
					),
					array(
						"view"    => "",
						"value"   => $data->users
					),
					array(
						"view"    => "",
						"value"   => ""
					),
					array(
						"view"    => "",
						"value"   => ""
					),
				),
				"select"  => false,
				"id"      => $id
			);
			$hasil['isi'][] = array(
				"harga"             => $data->total_harga,
				"flight"            => $flight_info,
			);
		}
		
		$hasil['status']  = 2;
    print json_encode($hasil);
    die;
	}
	
	private function read_more($string, $num){
    $string = str_replace(",", ", ", $string);
    $string = strip_tags($string);
    if (strlen($string) > $num) {
      $stringCut = substr($string, 0, $num);
      $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
    }
    return $string;
  }
  
  function banner_promo_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_banner_promo AS A"
      . " ORDER BY A.sort DESC LIMIT {$pst['start']}, 20");
      
    $status = $this->global_variable->status(1);
    $type = $this->global_variable->cms_banner_promo_type(1);
    foreach ($data AS $da){
      $button = ($da->status == 1 ? "<button class='btn btn-danger btn-sm banner-delete' isi='{$da->id_cms_banner_promo}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm banner-active' isi='{$da->id_cms_banner_promo}'><i class='fa fa-check'></i></button>");
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => "<img src='".site_url("file/index/cms-banner-promo/{$da->id_cms_banner_promo}")."' class='online' width='70' /img>",
            "value"   => ''
          ),
          array(
            "view"    => $da->title,
            "value"   => $da->title
          ),
          array(
            "view"    => $da->code,
            "value"   => $da->code
          ),
          array(
            "view"    => $da->startdate,
            "value"   => strtotime($da->startdate)
          ),
          array(
            "view"    => $da->enddate,
            "value"   => strtotime($da->enddate)
          ),
          array(
            "view"    => $status[$da->status]."<br /> {$type[$da->type]}",
            "value"   => $da->status,
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_cms_banner_promo
      );
      
    }
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function banner_promo_file_upload(){
    $pst = $this->input->post();
    $config['upload_path'] = './files/cms/banner-promo/';
    $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc';
    $this->load->library('upload', $config);

    if($_FILES['file']['name']){
      if (  $this->upload->do_upload('file')){
        $avatar = array('upload_data' => $this->upload->data());
      }
      else{
        $status = 1;
        $link = '';
        $note = $this->upload->display_errors();
      }
    }
    if($avatar['upload_data']['file_name']){
      $status = 2;
      $return = $avatar['upload_data']['file_name'];
      
      print json_encode(array(
        "status"      => $status,
        "data"        => $return,
        "note"        => $note,
      ));
    }
    else{
      print json_encode(array(
        "status"      => 3,
        "note"        => "Upload Fail",
      ));
    }
    die;
  }
  
  function banner_promo_set(){
    $pst = $this->input->post();
    $true = array(
      "true"  => 1,
      "false" => 2,
    );
    if($pst['id_cms_banner_promo']){
      $kirim = array(
       "title"               => $pst['title'],
       "code"                => $pst['code'],
       "link"                => $pst['link'],
       "note"                => $pst['note'],
       "startdate"           => $pst['startdate'],
       "enddate"             => $pst['enddate'],
       "sort"                => $pst['sort'],
       "type"                => $true[$pst['type']],
       "update_by_users"     => $this->session->userdata("id"),
     );
      if($pst['file'])
        $kirim['file'] = $pst['file'];
      $id_cms_banner_promo = $pst['id_cms_banner_promo'];
      $this->global_models->update("cms_banner_promo", array("id_cms_banner_promo" => $pst['id_cms_banner_promo']), $kirim);
      $balik['data'] = $this->_banner_promo_format_single_record($id_cms_banner_promo);
      $balik['status'] = 2;
    }
    else {
     $this->global_models->generate_id($id_cms_banner_promo, "cms_banner_promo");
     $kirim = array(
       "id_cms_banner_promo" => $id_cms_banner_promo,
       "title"               => $pst['title'],
       "code"                => $pst['code'],
       "link"                => $pst['link'],
       "note"                => $pst['note'],
       "startdate"           => $pst['startdate'],
       "enddate"             => $pst['enddate'],
       "sort"                => $pst['sort'],
       "status"              => 1,
       "type"                => $true[$pst['type']],
       "file"                => $pst['file'],
       "create_by_users"     => $this->session->userdata("id"),
       "create_date"         => date("Y-m-d H:i:s")
     );
     $this->global_models->insert("cms_banner_promo", $kirim);
     $balik['data'] = $this->_banner_promo_format_single_record($id_cms_banner_promo);
     $balik['status'] = 2;
    }
    print json_encode($balik);
    die;
  }
  
  private function _banner_promo_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_banner_promo AS A"
      . " WHERE A.id_cms_banner_promo = '{$id}'");
    
    $da = $data[0];
    $type = $this->global_variable->cms_banner_promo_type(1);
    $status = $this->global_variable->status(1);
    $button = ($da->status == 1 ? "<button class='btn btn-danger btn-sm banner-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm banner-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    $balik  = array(
      "data"    => array(
        array(
          "view"    => "<img src='".site_url("file/index/cms-banner-promo/{$id}")."' class='online' width='70' /img>",
          "value"   => ''
        ),
        array(
          "view"    => $da->title,
          "value"   => $da->title
        ),
        array(
          "view"    => $da->code,
          "value"   => $da->code
        ),
        array(
          "view"    => $da->startdate,
          "value"   => strtotime($da->startdate)
        ),
        array(
          "view"    => $da->enddate,
          "value"   => strtotime($da->enddate)
        ),
        array(
          "view"    => $status[$da->status]."<br />{$type[$da->type]}",
          "value"   => $da->status,
        ),
        array(
          "view"    => $button,
          "value"   => 0
        ),
      ),
      "select"  => true,
      "id"      => $id,
    );
    return $balik;
  }
  
  function banner_promo_get_detail(){
		$this->menu = $this->cek();
		
    $pst = $this->input->post();
    $data = $this->global_models->get("cms_banner_promo", array("id_cms_banner_promo" => $pst['id']));

    $detail = array(
      "link"                => $data[0]->link,
      "title"               => $data[0]->title,
      "id_cms_banner_promo" => $data[0]->id_cms_banner_promo,
      "code"                => $data[0]->code,
      "type"                => ($data[0]->type == 1 ? true : false),
      "sort"                => $data[0]->sort,
      "startdate"           => ($data[0]->startdate != '0000-00-00 00:00:00' ? $data[0]->startdate : date("Y-m-d H:i:s")),
      "enddate"             => ($data[0]->enddate != '0000-00-00 00:00:00' ? $data[0]->enddate : date("Y-m-d H:i:s")),
      "note"                => $data[0]->note,
      "gambar"              => "<img src='".site_url("file/index/cms-banner-promo/{$data[0]->id_cms_banner_promo}")."' class='online' width='70' /img>",
    );
    $hasil = array(
      "status"    => 2,
      "data"      => $detail
    );
    print json_encode($hasil);
    die;
  }
  
  function banner_promo_delete(){
    $pst = $this->input->post();
    $this->global_models->update("cms_banner_promo", array("id_cms_banner_promo" => $pst['id_cms_banner_promo']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $balik['data'] = $this->_banner_promo_format_single_record($pst['id_cms_banner_promo']);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function banner_promo_active(){
    $pst = $this->input->post();
    $this->global_models->update("cms_banner_promo", array("id_cms_banner_promo" => $pst['id_cms_banner_promo']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
    $balik['data'] = $this->_banner_promo_format_single_record($pst['id_cms_banner_promo']);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */