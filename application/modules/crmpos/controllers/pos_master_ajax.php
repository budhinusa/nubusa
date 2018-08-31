<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_master_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function products_specification_update(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_products", array("id_crm_pos_products" => $pst['id_crm_pos_products']), array("update_by_users" => $this->session->userdata("id"), "id_crm_pos_products_specification" => $pst['id_crm_pos_products_specification']));
    $this->global_models->delete("crm_pos_products_specification_data", array("id_crm_pos_products" => $pst['id_crm_pos_products']));
    $isi = json_decode($pst['isi']);
    foreach($isi AS $key => $is){
      $this->global_models->generate_id($id_crm_pos_products_specification_data, "crm_pos_products_specification_data", $key);
      $kirim[] = array(
        "id_crm_pos_products_specification_data"     => $id_crm_pos_products_specification_data,
        "id_crm_pos_products_specification_details"  => $is->id,
        "id_crm_pos_products"                        => $pst['id_crm_pos_products'],
        "isi"                                     => $is->isi,
        "create_by_users"                         => $this->session->userdata("id"),
        "create_date"                             => date("Y-m-d H:i:s")
      );
    }
    if($kirim){
      $this->global_models->insert_batch("crm_pos_products_specification_data", $kirim);
    }
    die;
  }
  
  function products_specification_use(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_specification_details AS A"
      . " WHERE A.id_crm_pos_products_specification = '{$pst['id_crm_pos_products_specification']}'"
      . " ORDER BY A.sort ASC");
    $html = "<div class='form-group'>";
    foreach ($data AS $dt){
      if($dt->type == 1)
        $form = $this->form_eksternal->form_input('isi[]', "", 'class="form-control input-sm isi" isi="'.$dt->id_crm_pos_products_specification_details.'"');
      else if($dt->type == 2)
        $form = "<input type='number' name='isi[]' value='' class='form-control input-sm isi' isi='{$dt->id_crm_pos_products_specification_details}'>";
      else
        $form = $this->form_eksternal->form_textarea('isi[]', '', 'class="form-control input-sm isi" isi="'.$dt->id_crm_pos_products_specification_details.'"');
      $html .= "<div class='row'>"
        . "<div class='col-xs-12'>"
          . "<label>{$dt->title}</label>"
          . "{$form}"
        . "</div>"
      . "</div>";
    }
    $html .= "</div>";
    print $html;
    die;
  }
  
  function products_specification_html(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.isi"
      . " ,B.title, B.type, A.id_crm_pos_products_specification_details"
      . " FROM crm_pos_products_specification_data AS A"
      . " LEFT JOIN crm_pos_products_specification_details AS B ON A.id_crm_pos_products_specification_details = B.id_crm_pos_products_specification_details"
      . " WHERE A.id_crm_pos_products = '{$pst['id_crm_pos_products']}'"
      . " ORDER BY B.sort ASC");
    $html = "<div class='form-group'>";
    foreach ($data AS $dt){
      if($dt->type == 1)
        $form = $this->form_eksternal->form_input('isi[]', $dt->isi, 'class="form-control input-sm isi" isi="'.$dt->id_crm_pos_products_specification_details.'"');
      else if($dt->type == 2)
        $form = "<input type='number' name='isi[]' value='{$dt->isi}' class='form-control input-sm isi' isi='{$dt->id_crm_pos_products_specification_details}'>";
      else
        $form = $this->form_eksternal->form_textarea('isi[]', $dt->isi, 'class="form-control input-sm isi" isi="'.$dt->id_crm_pos_products_specification_details.'"');
      $html .= "<div class='row'>"
        . "<div class='col-xs-12'>"
          . "<label>{$dt->title}</label>"
          . "{$form}"
        . "</div>"
      . "</div>";
    }
    $html .= "</div>";
    print $html;
    die;
  }
  
  function products_specification_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_specification AS A"
      . " ORDER BY A.title DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ""
          . "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_pos_products_specification}'><i class='fa fa-times'></i></button>"
        . "";
      
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
        "id"      => $dt->id_crm_pos_products_specification
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
  
  function products_categories_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_categories AS A"
      . " ORDER BY A.kode ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_pos_products_categories}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm active' isi='{$dt->id_crm_pos_products_categories}'><i class='fa fa-check'></i></button>");
      $status = $this->global_variable->status(1);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_products_categories
      );
    }
    
    if($hasil['data'])
      $hasil['status']  = 2;
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function products_specification_details_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_specification_details AS A"
      . " WHERE A.id_crm_pos_products_specification = '{$pst['id_crm_pos_products_specification']}'"
      . " ORDER BY A.sort ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $type = $this->global_variable->crm_pos_products_specification_type(1);
      
    foreach ($data AS $dt){
      $button = ""
          . "<button class='btn btn-danger btn-sm delete-details' isi='{$dt->id_crm_pos_products_specification_details}'><i class='fa fa-times'></i></button>"
        . "";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->sort,
            "value"   => $dt->sort
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
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
        "id"      => $dt->id_crm_pos_products_specification_details
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
  
  function products_categories_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $data = $this->global_models->get("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id']));
    $status = $this->global_variable->status(1);
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->kode,
            "value"   => $data[0]->kode
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $status[2],
            "value"   => 2
          ),
          array(
            "view"    => "<button class='btn btn-info btn-sm active' isi='{$pst['id']}'><i class='fa fa-check'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $pst['id'],
      );
    print json_encode($balik);
    die;
  }
  
  function products_categories_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
    $data = $this->global_models->get("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id']));
    $status = $this->global_variable->status(1);
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->kode,
            "value"   => $data[0]->kode
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $status[1],
            "value"   => 1
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$pst['id']}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $pst['id'],
      );
    print json_encode($balik);
    die;
  }
  
  function products_specification_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("crm_pos_products_specification", array("id_crm_pos_products_specification" => $pst['id']));
    $this->global_models->delete("crm_pos_products_specification_details", array("id_crm_pos_products_specification" => $pst['id']));
    print "Done";die;
  }
  
  function products_specification_details_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("crm_pos_products_specification_details", array("id_crm_pos_products_specification_details" => $pst['id']));
    print "Done";die;
  }
  
  function products_specification_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_pos_products_specification", array("id_crm_pos_products_specification" => $pst['id']));
    $hasil = array(
      "title"                           => $data[0]->title,
      "id_crm_pos_products_specification"  => $data[0]->id_crm_pos_products_specification,
    );
    print json_encode($hasil);
    die;
  }
  
  function products_categories_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id']));
    $hasil = array(
      "kode"                                => $data[0]->kode,
      "title"                               => $data[0]->title,
      "id_crm_pos_products_categories"      => $data[0]->id_crm_pos_products_categories,
    );
    print json_encode($hasil);
    die;
  }
  
  function products_specification_details_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_pos_products_specification_details", array("id_crm_pos_products_specification_details" => $pst['id_crm_pos_products_specification_details']));
    $hasil = array(
      "title"                                   => $data[0]->title,
      "code"                                    => $data[0]->code,
      "sort"                                    => $data[0]->sort,
      "type"                                    => $data[0]->type,
      "id_crm_pos_products_specification_details"  => $data[0]->id_crm_pos_products_specification_details,
    );
    print json_encode($hasil);
    die;
  }
  
  function products_specification_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_products_specification']){
      $kirim = array(
        "title"                       => $pst['title'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_products_specification", array("id_crm_pos_products_specification" => $pst['id_crm_pos_products_specification']), $kirim);
      $id_crm_pos_products_specification = $pst['id_crm_pos_products_specification'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_products_specification, "crm_pos_products_specification");
      $kirim = array(
        "id_crm_pos_products_specification"  => $id_crm_pos_products_specification,
        "title"                           => $pst['title'],
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_products_specification", $kirim);
    }
    
    $data = $this->global_models->get("crm_pos_products_specification", array("id_crm_pos_products_specification" => $id_crm_pos_products_specification));
    
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_crm_pos_products_specification}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_pos_products_specification,
      );
    print json_encode($balik);
    die;
  }
  
  function products_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_products']){
      $kirim = array(
        "title"                           => $pst['title'],
        "sku"                             => $pst['sku'],
        "note"                            => $pst['note'],
        "id_crm_pos_products_categories"  => $pst['id_crm_pos_products_categories'],
        "update_by_users"                 => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_products", array("id_crm_pos_products" => $pst['id_crm_pos_products']), $kirim);
      $id_crm_pos_products = $pst['id_crm_pos_products'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_products, "crm_pos_products");
      $kirim = array(
        "id_crm_pos_products"             => $id_crm_pos_products,
        "id_crm_pos_products_categories"  => $pst['id_crm_pos_products_categories'],
        "title"                           => $pst['title'],
        "sku"                             => $pst['sku'],
        "note"                            => $pst['note'],
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_products", $kirim);
    }
    
    $data = $this->global_models->get("crm_pos_products", array("id_crm_pos_products" => $id_crm_pos_products));
    
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->sku,
            "value"   => $data[0]->sku
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->categories,
            "value"   => $data[0]->id_crm_pos_
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_crm_pos_products_specification}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_pos_products_specification,
      );
    print json_encode($balik);
    die;
  }
  
  function products_categories_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_products_categories']){
      $kirim = array(
        "title"                       => $pst['title'],
        "kode"                        => $pst['kode'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_products_categories", array("id_crm_pos_products_categories" => $pst['id_crm_pos_products_categories']), $kirim);
      $id_crm_pos_products_categories = $pst['id_crm_pos_products_categories'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_products_categories, "crm_pos_products_categories");
      $kirim = array(
        "id_crm_pos_products_categories"  => $id_crm_pos_products_categories,
        "title"                           => $pst['title'],
        "kode"                            => $pst['kode'],
        "status"                          => 1,
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_products_categories", $kirim);
    }
    
    $data = $this->global_models->get("crm_pos_products_categories", array("id_crm_pos_products_categories" => $id_crm_pos_products_categories));
    $status = $this->global_variable->status(1);
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->kode,
            "value"   => $data[0]->kode
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $status[1],
            "value"   => 1
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete' isi='{$id_crm_pos_products_categories}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_pos_products_categories,
      );
    print json_encode($balik);
    die;
  }
  
  function products_specification_details_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_products_specification_details']){
      $kirim = array(
        "title"                       => $pst['title'],
        "code"                        => $pst['code'],
        "sort"                        => $pst['sort'],
        "type"                        => $pst['type'],
        "update_by_users"             => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_products_specification_details", array("id_crm_pos_products_specification_details" => $pst['id_crm_pos_products_specification_details']), $kirim);
      $id_crm_pos_products_specification_details = $pst['id_crm_pos_products_specification_details'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_products_specification_details, "crm_pos_products_specification_details");
      $kirim = array(
        "id_crm_pos_products_specification_details"  => $id_crm_pos_products_specification_details,
        "id_crm_pos_products_specification"          => $pst['id_crm_pos_products_specification'],
        "title"                                   => $pst['title'],
        "code"                        => $pst['code'],
        "sort"                                    => $pst['sort'],
        "type"                                    => $pst['type'],
        "create_by_users"                         => $this->session->userdata("id"),
        "create_date"                             => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_products_specification_details", $kirim);
    }
    
    $data = $this->global_models->get("crm_pos_products_specification_details", array("id_crm_pos_products_specification_details" => $id_crm_pos_products_specification_details));
    
    $type = $this->global_variable->crm_pos_products_specification_type(1);
    
    $balik['data']  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->sort,
            "value"   => $data[0]->sort
          ),
          array(
            "view"    => $data[0]->code,
            "value"   => $data[0]->code
          ),
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $type[$data[0]->type],
            "value"   => $data[0]->type
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm delete-details' isi='{$id_crm_pos_products_specification_details}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_pos_products_specification_details,
      );
    print json_encode($balik);
    die;
  }
  
  function inventory_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.title FROM crm_pos_products_categories AS C WHERE C.id_crm_pos_products_categories = A.id_crm_pos_products_categories) AS category"
      . " FROM crm_pos_products AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$dt->id_crm_pos_products}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm form-active' isi='{$dt->id_crm_pos_products}'><i class='fa fa-check'></i></button>");
      $status = $this->global_variable->status(1);
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->category,
            "value"   => $dt->category
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_products
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
  
  function locations_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location AS A"
      . " ORDER BY A.urut ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm location-delete' isi='{$dt->id_crm_pos_location}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm location-active' isi='{$dt->id_crm_pos_location}'><i class='fa fa-check'></i></button>");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->urut,
            "value"   => $dt->urut
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_location
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
  
  function locations_dc_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location_dc AS A"
      . " WHERE A.id_crm_pos_location = '{$pst['id_crm_pos_location']}'"
      . " ORDER BY A.urut ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm dc-delete' isi='{$dt->id_crm_pos_location_dc}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm dc-active' isi='{$dt->id_crm_pos_location_dc}'><i class='fa fa-check'></i></button>");
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->urut,
            "value"   => $dt->urut
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_location_dc
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
  
  function inventory_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products AS A"
      . " WHERE A.id_crm_pos_products = '{$pst['id']}'"
      . "");
    $hasil = array(
      "title"                               => $data[0]->title,
      "description"                         => $data[0]->description,
      "id_crm_pos_products_categories"      => $data[0]->id_crm_pos_products_categories,
      "id_crm_pos_products"                 => $data[0]->id_crm_pos_products,
      "id_crm_pos_products_specification"   => $data[0]->id_crm_pos_products_specification,
    );
    print json_encode($hasil);
    die;
  }
  
  function locations_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location AS A"
      . " WHERE A.id_crm_pos_location = '{$pst['id_crm_pos_location']}'"
      . "");
    $hasil = array(
      "title"                => $data[0]->title,
      "code"                 => $data[0]->code,
      "id_crm_pos_location"  => $data[0]->id_crm_pos_location,
      "urut"                 => $data[0]->urut,
    );
    $return = array(
      "status"    => 2,
      "data"      => $hasil
    );
    print json_encode($return);
    die;
  }
  
  function locations_dc_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location_dc AS A"
      . " WHERE A.id_crm_pos_location_dc = '{$pst['id_crm_pos_location_dc']}'"
      . "");
    $hasil = array(
      "title"                => $data[0]->title,
      "code"                 => $data[0]->code,
      "id_crm_pos_location_dc" => $data[0]->id_crm_pos_location_dc,
      "urut"                 => $data[0]->urut,
    );
    $return = array(
      "status"    => 2,
      "data"      => $hasil
    );
    print json_encode($return);
    die;
  }
  
  function inventory_set(){
    $pst = $this->input->post();
    $this->load->model("crmpos/m_crmpos");
    if($pst['id_crm_pos_products']){
      $kirim_products = array(
        "title"                               => $pst['title'],
        "description"                         => $pst['description'],
      );
      $id_crm_pos_products = $this->m_crmpos->products_update($kirim_products, $pst['id_crm_pos_products']);
    }
    else{
      $this->global_models->generate_id($id_crm_pos_products, "crm_pos_products");
      $kirim_products = array(
        "id_crm_pos_products_categories"      => $pst['id_crm_pos_products_categories'],
        "title"                               => $pst['title'],
        "description"                         => $pst['description'],
        "status"                              => 1,
      );
      $id_crm_pos_products = $this->m_crmpos->products_set($kirim_products);
    }
    
    $balik['data'] = $this->_inventory_format_single_record($id_crm_pos_products);
    print json_encode($balik);
    die;
  }
  
  function locations_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_location']){
      $kirim = array(
        "title"                        => $pst['title'],
        "code"                         => $pst['code'],
        "urut"                         => $pst['urut'],
      );
      $this->global_models->update("crm_pos_location", array("id_crm_pos_location" => $pst['id_crm_pos_location']), $kirim);
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_format_single_record($pst['id_crm_pos_location']);
    }
    else{
      $this->global_models->generate_id($id_crm_pos_location, "crm_pos_location");
      $kirim = array(
        "id_crm_pos_location"      => $id_crm_pos_location,
        "title"                    => $pst['title'],
        "code"                     => $pst['code'],
        "urut"                     => $pst['urut'],
        "status"                   => 1,
      );
      $this->global_models->insert("crm_pos_location", $kirim);
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_format_single_record($id_crm_pos_location);
    }
    print json_encode($balik);
    die;
  }
  
  function locations_dc_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_location_dc']){
      $kirim = array(
        "title"                        => $pst['title'],
        "code"                         => $pst['code'],
        "urut"                         => $pst['urut'],
      );
      $this->global_models->update("crm_pos_location_dc", array("id_crm_pos_location_dc" => $pst['id_crm_pos_location_dc']), $kirim);
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_dc_format_single_record($pst['id_crm_pos_location_dc']);
    }
    else{
      $this->global_models->generate_id($id_crm_pos_location_dc, "crm_pos_location_dc");
      $kirim = array(
        "id_crm_pos_location_dc"   => $id_crm_pos_location_dc,
        "id_crm_pos_location"      => $pst['id_crm_pos_location'],
        "title"                    => $pst['title'],
        "code"                     => $pst['code'],
        "urut"                     => $pst['urut'],
        "status"                   => 1,
      );
      $this->global_models->insert("crm_pos_location_dc", $kirim);
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_dc_format_single_record($id_crm_pos_location_dc);
    }
    print json_encode($balik);
    die;
  }
  
  function locations_delete(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_location']){
      $this->global_models->update("crm_pos_location", array("id_crm_pos_location" => $pst['id_crm_pos_location']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_format_single_record($pst['id_crm_pos_location']);
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Fail");
    }
    print json_encode($balik);
    die;
  }
  
  function locations_active(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_location']){
      $this->global_models->update("crm_pos_location", array("id_crm_pos_location" => $pst['id_crm_pos_location']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
      $balik['status'] = 2;
      $balik['data'] = $this->_locations_format_single_record($pst['id_crm_pos_location']);
    }
    else{
      $balik['status'] = 3;
      $balik['note'] = lang("Fail");
    }
    print json_encode($balik);
    die;
  }
  
  function _inventory_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.title FROM crm_pos_products_categories AS C WHERE C.id_crm_pos_products_categories = A.id_crm_pos_products_categories) AS category"
      . " FROM crm_pos_products AS A"
      . " WHERE A.id_crm_pos_products = '{$id}'");
    $type = $this->global_variable->crmtrans_products_type(1);
    $status = $this->global_variable->status(1);
    
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm form-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->category,
            "value"   => $data[0]->category
          ),
          array(
            "view"    => $status[$data[0]->status],
            "value"   => $data[0]->status
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
  
  function _locations_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location AS A"
      . " WHERE A.id_crm_pos_location = '{$id}'");
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm location-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm location-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->urut,
            "value"   => $dt->urut
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
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
  
  function _locations_dc_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_location_dc AS A"
      . " WHERE A.id_crm_pos_location_dc = '{$id}'");
    $status = $this->global_variable->status(1);
    $dt = $data[0];
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm dc-delete' isi='{$id}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm dc-active' isi='{$id}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $dt->urut,
            "value"   => $dt->urut
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
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
  
  function inventory_merchandise_set(){
    $pst = $this->input->post();
    $this->load->model("crmpos/m_crmpos");
//    $this->debug($pst, true);
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    
    if($pst['id_crm_pos_products_merchandise']){
      $kirim_merchandise = array(
        "title"                         => $pst['title'],
        "harga"                         => $pst['harga'],
        "tambahan"                      => $truefalse[$pst['tambahan']],
        "editable"                      => $truefalse[$pst['editable']],
        "qty"                           => $pst['qty'],
        "type"                          => $truefalse[$pst['type']],
        "note"                          => $pst['note'],
      );
      $id_crm_pos_products_merchandise = $this->m_crmpos->products_merchandise_update($kirim_merchandise, $pst['id_crm_pos_products_merchandise']);
    }
    else{
      $kirim_merchandise = array(
        "title"                         => $pst['title'],
        "harga"                         => $pst['harga'],
        "tambahan"                      => $truefalse[$pst['tambahan']],
        "editable"                      => $truefalse[$pst['editable']],
        "type"                          => $truefalse[$pst['type']],
        "qty"                           => $pst['qty'],
        "qty_out"                       => 0,
        "id_crm_pos_products"           => $pst['id_crm_pos_products'],
        "status"                        => 1,
        "note"                          => $pst['note'],
      );
      $id_crm_pos_products_merchandise = $this->m_crmpos->products_merchandise_set($kirim_merchandise);
    }
    
    $balik['data'] = $this->_inventory_merchandise_format_single_record($id_crm_pos_products_merchandise);
    print json_encode($balik);
    die;
  }
  
  function _inventory_merchandise_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_merchandise AS A"
      . " WHERE A.id_crm_pos_products_merchandise = '{$id}'");
    
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm merchandise-delete' isi='{$id_crm_pos_products_merchandise}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm merchandise-active' isi='{$id_crm_pos_products_merchandise}'><i class='fa fa-check'></i></button>");
    
    $type = $this->global_variable->crmpos_products_merchandise_type(1);
    $status = $this->global_variable->status(1);
    
    $limit = ($data[0]->batas == 2 ? $type[$data[0]->batas] : $data[0]->qty." ".$type[$data[0]->batas]);
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => number_format($data[0]->harga),
            "value"   => $data[0]->harga,
            "class"   => "kanan"
          ),
          array(
            "view"    => $status[$data[0]->editable],
            "value"   => $data[0]->status
          ),
          array(
            "view"    => $limit,
            "value"   => $limit
          ),
          array(
            "view"    => $status[$data[0]->status],
            "value"   => $data[0]->status
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
  
  function inventory_merchandise_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_merchandise AS A"
      . " WHERE A.id_crm_pos_products = '{$pst['id_crm_pos_products']}'"
      . " ORDER BY A.title ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm merchandise-delete' isi='{$dt->id_crm_pos_products_merchandise}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm merchandise-active' isi='{$dt->id_crm_pos_products_merchandise}'><i class='fa fa-check'></i></button>");
    
    $type = $this->global_variable->crmpos_products_merchandise_type(1);
    $status = $this->global_variable->status(1);
    
    $limit = ($dt->batas == 2 ? $type[$dt->batas] : $dt->qty." ".$type[$dt->batas]);
    
    $hasil['data'][]  = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => number_format($dt->harga),
            "value"   => $dt->harga,
            "class"   => "kanan"
          ),
          array(
            "view"    => $status[$dt->editable],
            "value"   => $dt->editable
          ),
          array(
            "view"    => $limit,
            "value"   => $limit
          ),
          array(
            "view"    => $status[$dt->status],
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_products_merchandise,
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
  
  function inventory_merchandise_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_products_merchandise AS A"
      . " WHERE A.id_crm_pos_products_merchandise = '{$pst['id']}'"
      . "");
    $hasil = array(
      "title"                                   => $data[0]->title,
      "harga"                                   => $data[0]->harga,
      "note"                                    => $data[0]->note,
      "tambahan"                                => ($data[0]->tambahan == 1 ? TRUE : FALSE),
      "editable"                                => ($data[0]->editable == 1 ? TRUE : FALSE),
      "qty"                                     => $data[0]->qty,
      "type"                                    => ($data[0]->type == 1 ? TRUE : FALSE),
      "id_crm_pos_products_merchandise"  => $data[0]->id_crm_pos_products_merchandise,
    );
    print json_encode($hasil);
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */