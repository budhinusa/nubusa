<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Discount_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
    $this->load->model("crmpos/m_crmpos");
  }
  
  function discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount AS A"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    $status = $this->global_variable->status(1);
    $type = $this->global_variable->crmpos_discount_type(2);
    $gradual = $this->global_variable->crmpos_discount_gradual(1);
    $editable = $this->global_variable->crmpos_discount_editable(1);
    $approve = $this->global_variable->crmpos_discount_approve(1);
      
    foreach ($data AS $dt){
      $button = ($dt->status == 1 ? "<button class='btn btn-danger btn-sm discount-delete' isi='{$dt->id_crm_pos_discount}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm discount-active' isi='{$dt->id_crm_pos_discount}'><i class='fa fa-check'></i></button>");
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->startdate,
            "value"   => $dt->startdate
          ),
          array(
            "view"    => $dt->enddate,
            "value"   => $dt->enddate
          ),
          array(
            "view"    => "{$dt->title}<br />{$dt->code}",
            "value"   => $dt->title
          ),
          array(
            "view"    => "{$gradual[$dt->bertingkat]}".($dt->bertingkat == 1 ? ": {$dt->sort}": "")."<br />"
                  . "{$approve[$dt->approve]}",
            "value"   => $dt->bertingkat
          ),
          array(
            "view"    => "{$editable[$dt->editable]}<br />"
                . "<label class='label label-{$type[$dt->type]['theme']}'>{$type[$dt->type]['before']} ".number_format($dt->nilai)." {$type[$dt->type]['after']}</label>",
            "value"   => $dt->type
          ),
          array(
            "view"    => "{$status[$dt->status]}",
            "value"   => $dt->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount
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
  
  function settings_discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.nilai, A.id_crm_pos_discount_set"
      . " ,(SELECT B.title FROM crm_pos_approval_settings AS B WHERE B.id_crm_pos_approval_settings = A.id_crm_pos_approval_settings) AS settings"
      . " FROM crm_pos_discount_set AS A"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm privilege-delete' isi='{$dt->id_crm_pos_discount_set}'><i class='fa fa-times'></i></button>";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->settings,
            "value"   => $dt->settings
          ),
          array(
            "view"    => number_format($dt->nilai),
            "value"   => $dt->nilai,
            "class"   => "kanan",
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_set
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
  
  function discount_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_discount", array("id_crm_pos_discount" => $pst['id']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $balik['data'] = $this->_discount_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function settings_discount_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("crm_pos_discount_set", array("id_crm_pos_discount_set" => $pst['id']));
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function discount_payment_channel_delete(){
    $pst = $this->input->post();
    $this->global_models->delete("crm_pos_discount_payment_channel", array("id_crm_pos_discount_payment_channel" => $pst['id_crm_pos_discount_payment_channel']));
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function discount_voucher_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_discount_voucher", array("id_crm_pos_discount_voucher" => $pst['id_crm_pos_discount_voucher']), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function discount_active(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_discount", array("id_crm_pos_discount" => $pst['id']), array("status" => 1, "update_by_users" => $this->session->userdata("id")));
    $balik['data']  = $this->_discount_format_single_record($pst['id']);
    print json_encode($balik);
    die;
  }
  
  function discount_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $pst['id']));
    $hasil = array(
      "title"                     => $data[0]->title,
      "bataswaktu"                => ($data[0]->bataswaktu == 1 ? TRUE : FALSE),
      "tanggal"                   => date("d/m/Y H:i", strtotime($data[0]->startdate))." - ".date("d/m/Y H:i", strtotime($data[0]->enddate)),
      "startdate"                 => date("d/m/Y H:i", strtotime($data[0]->startdate)),
      "enddate"                   => date("d/m/Y H:i", strtotime($data[0]->enddate)),
      "type"                      => ($data[0]->type == 1 ? TRUE : FALSE),
      "nilai"                     => $data[0]->nilai,
      "minimum"                   => $data[0]->minimum,
      "maximum"                   => $data[0]->maximum,
      "sort"                      => $data[0]->sort,
      "approve"                   => ($data[0]->approve== 1 ? TRUE : FALSE),
      "gradual"                   => ($data[0]->gradual == 1 ? TRUE : FALSE),
      "editable"                  => ($data[0]->editable == 1 ? TRUE : FALSE),
      "merchandise"               => ($data[0]->merchandise == 1 ? TRUE : FALSE),
      "cashback"                  => ($data[0]->cashback == 1 ? TRUE : FALSE),
      "code"                      => $data[0]->code,
	  "nameinprint"               => $data[0]->nameinprint,
      "is_company"                => ($data[0]->is_company == 1 ? TRUE : FALSE),  
      "is_payment_channel"        => ($data[0]->is_payment_channel == 1 ? TRUE : FALSE),  
      "is_voucher"                => ($data[0]->is_voucher == 1 ? TRUE : FALSE),  
      "note"                      => $data[0]->note,
      "id_crm_pos_discount"       => $data[0]->id_crm_pos_discount,
    );
    print json_encode($hasil);
    die;
  }
  
  function discount_set(){
    $pst = $this->input->post();
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    if($pst['id_crm_pos_discount']){
      $kirim = array(
        "nilai"                 => $pst['nilai'],
        "minimum"               => $pst['minimum'],
        "maximum"               => $pst['maximum'],
        "nilai"                 => $pst['nilai'],
        "title"                 => $pst['title'],
        "bataswaktu"            => $truefalse[$pst['bataswaktu']],
        "startdate"             => $pst['startdate'],
        "enddate"               => $pst['enddate'],
        "editable"              => $truefalse[$pst['editable']],
        "type"                  => $truefalse[$pst['type']],
        "bertingkat"            => $truefalse[$pst['gradual']],
        "sort"                  => $pst['sort'],
        "approve"               => $truefalse[$pst['approve']],
        "is_company"            => $truefalse[$pst['is_company']],  
        "is_payment_channel"    => $truefalse[$pst['is_payment_channel']],
        "is_voucher"            => $truefalse[$pst['is_voucher']],
        "cashback"              => ($pst['editable'] == 2 ? 1: $truefalse[$pst['cashback']]),
        "code"                  => $pst['code'],
		"nameinprint"           => $pst['nameinprint'],
        "merchandise"           => $truefalse[$pst['merchandise']],
        "note"                  => $pst['note'],
        "update_by_users"       => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_discount", array("id_crm_pos_discount" => $pst['id_crm_pos_discount']), $kirim);
      $id_crm_pos_discount = $pst['id_crm_pos_discount'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_discount, "crm_pos_discount");
      $kirim = array(
        "id_crm_pos_discount"   => $id_crm_pos_discount,
        "nilai"                 => $pst['nilai'],
        "minimum"               => $pst['minimum'],
        "maximum"               => $pst['maximum'],
        "title"                 => $pst['title'],
        "bataswaktu"            => $truefalse[$pst['bataswaktu']],
        "startdate"             => $pst['startdate'],
        "enddate"               => $pst['enddate'],
        "editable"              => $truefalse[$pst['editable']],
        "type"                  => $truefalse[$pst['type']],
        "status"                => 1,
        "bertingkat"            => $truefalse[$pst['gradual']],
        "sort"                  => $pst['sort'],
        "approve"               => $truefalse[$pst['approve']],
        "merchandise"           => $truefalse[$pst['merchandise']],
        "is_company"            => $truefalse[$pst['is_company']],
        "is_payment_channel"    => $truefalse[$pst['is_payment_channel']],
        "is_voucher"            => $truefalse[$pst['is_voucher']],
        "cashback"              => ($pst['editable'] == 2 ? 1: $truefalse[$pst['cashback']]),
        "code"                  => $pst['code'],
		"nameinprint"           => $pst['nameinprint'],
        "note"                  => $pst['note'],
        "create_by_users"       => $this->session->userdata("id"),
        "create_date"           => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_discount", $kirim);
    }
    
    $balik['data'] = $this->_discount_format_single_record($id_crm_pos_discount);
    print json_encode($balik);
    die;
  }
  
  function discount_block_date_set(){
    $pst = $this->input->post();
    $this->global_models->generate_id($id_crm_pos_discount_block_date, "crm_pos_discount_block_date");
    $kirim = array(
      "id_crm_pos_discount_block_date"  => $id_crm_pos_discount_block_date,
      "id_crm_pos_discount"             => $pst['id_crm_pos_discount'],
      "startdate"                       => $pst['startdate'],
      "enddate"                         => $pst['enddate'],
      "create_by_users"                 => $this->session->userdata("id"),
      "create_date"                     => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_discount_block_date", $kirim);
    
    $balik['data'] = $this->_discount_block_date_format_single_record($id_crm_pos_discount_block_date);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function discount_payment_channel_set(){
    $pst = $this->input->post();
    $this->global_models->generate_id($id_crm_pos_discount_payment_channel, "crm_pos_discount_payment_channel");
    $kirim = array(
      "id_crm_pos_discount_payment_channel" => $id_crm_pos_discount_payment_channel,
      "id_crm_payment_channel"              => $pst['id_crm_payment_channel'],
      "id_crm_pos_discount"                 => $pst['id_crm_pos_discount'],
      "create_by_users"                     => $this->session->userdata("id"),
      "create_date"                         => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_discount_payment_channel", $kirim);
    
    $balik['data'] = $this->_discount_payment_channel_format_single_record($id_crm_pos_discount_payment_channel);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function discount_voucher_set(){
    $pst = $this->input->post();
    $this->global_models->generate_id($id_crm_pos_discount_voucher, "crm_pos_discount_voucher");
    $kirim = array(
      "id_crm_pos_discount_voucher" => $id_crm_pos_discount_voucher,
      "id_crm_pos_discount"         => $pst['id_crm_pos_discount'],
      "title"                       => $pst['title'],
      "type"                        => $pst['type'],
      "batas"                       => $pst['batas'],
      "startdate"                   => $pst['startdate'],
      "enddate"                     => $pst['enddate'],
      "status"                      => 1,
      "create_by_users"             => $this->session->userdata("id"),
      "create_date"                 => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_discount_voucher", $kirim);
    
    $balik['data'] = $this->_discount_voucher_format_single_record($id_crm_pos_discount_voucher);
    $balik['status'] = 2;
    print json_encode($balik);
    die;
  }
  
  function settings_discount_set(){
    $pst = $this->input->post();
    if($pst['id_crm_pos_discount_set']){
      $kirim = array(
        "nilai"                                 => $pst['nilai'],
        "id_crm_pos_approval_settings"  => $pst['id_crm_pos_approval_settings'],
        "id_crm_pos_discount"                   => $pst['id_crm_pos_discount'],
        "update_by_users"       => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_discount_set", array("id_crm_pos_discount_set" => $pst['id_crm_pos_discount_set']), $kirim);
      $id_crm_pos_discount_set = $pst['id_crm_pos_discount_set'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_discount_set, "crm_pos_discount_set");
      $kirim = array(
        "id_crm_pos_discount_set"               => $id_crm_pos_discount_set,
        "nilai"                                 => $pst['nilai'],
        "id_crm_pos_approval_settings"  => $pst['id_crm_pos_approval_settings'],
        "id_crm_pos_discount"                   => $pst['id_crm_pos_discount'],
        "create_by_users"                       => $this->session->userdata("id"),
        "create_date"                           => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_discount_set", $kirim);
    }
    
    $balik['data'] = $this->_settings_discount_format_single_record($id_crm_pos_discount_set);
    print json_encode($balik);
    die;
  }
  
  function _discount_format_single_record($id_crm_pos_discount){
    $data = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $id_crm_pos_discount));
    $status = $this->global_variable->status(1);
    $type = $this->global_variable->crmpos_discount_type(2);
    $gradual = $this->global_variable->crmpos_discount_gradual(1);
    $editable = $this->global_variable->crmpos_discount_editable(1);
    $approve = $this->global_variable->crmpos_discount_approve(1);
    
    $button = ($data[0]->status == 1 ? "<button class='btn btn-danger btn-sm discount-delete' isi='{$id_crm_pos_discount}'><i class='fa fa-times'></i></button>" : "<button class='btn btn-info btn-sm discount-active' isi='{$id_crm_pos_discount}'><i class='fa fa-check'></i></button>");
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->startdate,
            "value"   => $data[0]->startdate
          ),
          array(
            "view"    => $data[0]->enddate,
            "value"   => $data[0]->enddate
          ),
          array(
            "view"    => "{$data[0]->title}<br />{$data[0]->code}",
            "value"   => $data[0]->title
          ),
          array(
            "view"    => "{$gradual[$data[0]->bertingkat]}".($data[0]->bertingkat == 1 ? ": {$data[0]->sort}": "")."<br />"
                  . "{$approve[$data[0]->approve]}",
            "value"   => $dt->bertingkat
          ),
          array(
            "view"    => "{$editable[$data[0]->editable]}<br />"
                . "<label class='label label-{$type[$data[0]->type]['theme']}'>{$type[$data[0]->type]['before']} ".number_format($data[0]->nilai)." {$type[$data[0]->type]['after']}</label>",
            "value"   => $data[0]->type
          ),
          array(
            "view"    => "{$status[$data[0]->status]}",
            "value"   => $data[0]->status
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => true,
        "id"      => $id_crm_pos_discount,
      );
    return $balik;
  }
  
  function _discount_block_date_format_single_record($id){
    $data = $this->global_models->get("crm_pos_discount_block_date", array("id_crm_pos_discount_block_date" => $id));
    $button = "<button class='btn btn-danger btn-sm block-date-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->startdate,
            "value"   => strtotime($data[0]->startdate)
          ),
          array(
            "view"    => $data[0]->enddate,
            "value"   => strtotime($data[0]->enddate)
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
  
  function _discount_payment_channel_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " , B.title, B.code"
      . " FROM crm_pos_discount_payment_channel AS A"
      . " LEFT JOIN crm_payment_channel AS B ON B.id_crm_payment_channel = A.id_crm_payment_channel"
      . " WHERE A.id_crm_pos_discount_payment_channel = '{$id}'"
      . " ");
    $button = "<button class='btn btn-danger btn-sm payment-channel-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->code,
            "value"   => $data[0]->code
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
  
  function _discount_voucher_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount_voucher AS A"
      . " WHERE A.id_crm_pos_discount_voucher = '{$id}'"
      . " ");
    $button = "<button class='btn btn-danger btn-sm voucher-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    $type = $this->global_variable->crm_discount_voucher_type(1);
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->startdate,
            "value"   => strtotime($data[0]->startdate)
          ),
          array(
            "view"    => $data[0]->enddate,
            "value"   => strtotime($data[0]->enddate)
          ),
          array(
            "view"    => $data[0]->batas."<br />".$type[$data[0]->type],
            "value"   => $data[0]->batas."<br />".$type[$data[0]->type]
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
  
  function _settings_discount_format_single_record($id){
    $data = $this->global_models->get_query("SELECT A.nilai, A.id_crm_pos_discount_set"
      . " ,(SELECT B.title FROM crm_pos_approval_settings AS B WHERE B.id_crm_pos_approval_settings = A.id_crm_pos_approval_settings) AS approval"
      . " FROM crm_pos_discount_set AS A"
      . " WHERE A.id_crm_pos_discount_set = '{$id}'");
    
    $button = "<button class='btn btn-danger btn-sm privilege-delete' isi='{$id}'><i class='fa fa-times'></i></button>";
    
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->approval,
            "value"   => $data[0]->approval
          ),
          array(
            "view"    => number_format($data[0]->nilai),
            "value"   => $data[0]->nilai,
            "class"   => "kanan"
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
  
  function merchandise_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = A.id_crm_pos_products) AS products"
      . " FROM crm_pos_products_merchandise AS A"
      . " WHERE A.id_crm_pos_products_merchandise NOT IN (SELECT B.id_crm_pos_products_merchandise FROM crm_pos_discount_merchandise AS B WHERE B.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}' AND B.status = 1)"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->products,
            "value"   => $dt->products
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_products_merchandise
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
  
  function merchandise_discount_set(){
    $pst = $this->input->post();
    $id_crm_pos_discount_merchandise = $this->global_models->get_field("crm_pos_discount_merchandise", "id_crm_pos_discount_merchandise", array("id_crm_pos_products_merchandise" => $pst['id_crm_pos_products_merchandise'], "id_crm_pos_discount" => $pst['id_crm_pos_discount']));
    if($id_crm_pos_discount_merchandise){
      $kirim = array(
        "status"                            => 1,
        "update_by_users"                   => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_discount_merchandise", array("id_crm_pos_discount_merchandise" => $id_crm_pos_discount_merchandise), $kirim);
    }
    else{
      $this->global_models->generate_id($id_crm_pos_discount_merchandise, "crm_pos_discount_merchandise");
      $kirim = array(
        "id_crm_pos_discount_merchandise"   => $id_crm_pos_discount_merchandise,
        "id_crm_pos_products_merchandise"   => $pst['id_crm_pos_products_merchandise'],
        "id_crm_pos_discount"               => $pst['id_crm_pos_discount'],
        "status"                            => 1,
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_discount_merchandise", $kirim);
    }
    
    $balik['data'] = $this->_merchandise_discount_format_single_record($id_crm_pos_discount_merchandise);
    print json_encode($balik);
    die;
  }
  
  function merchandise_discount_set_all(){
    $pst = $this->input->post();
	
	$data = $this->global_models->get_query("SELECT A.*"
		  . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = A.id_crm_pos_products) AS products"
		  . " FROM crm_pos_products_merchandise AS A"
		  . " WHERE A.id_crm_pos_products_merchandise NOT IN (SELECT B.id_crm_pos_products_merchandise FROM crm_pos_discount_merchandise AS B WHERE B.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}' AND B.status = 1)"
		  . " ORDER BY A.create_date DESC"
		  . "");
	   
      
    foreach ($data AS $dt){
		$id_crm_pos_discount_merchandise = $this->global_models->get_field("crm_pos_discount_merchandise", "id_crm_pos_discount_merchandise", array("id_crm_pos_products_merchandise" => $dt->id_crm_pos_products_merchandise, "id_crm_pos_discount" => $pst['id_crm_pos_discount']));
		if($id_crm_pos_discount_merchandise){
		  $kirim = array(
			"status"                            => 1,
			"update_by_users"                   => $this->session->userdata("id"),
		  );
		  $this->global_models->update("crm_pos_discount_merchandise", array("id_crm_pos_discount_merchandise" => $id_crm_pos_discount_merchandise), $kirim);
		}
		else{
		  $this->global_models->generate_id($id_crm_pos_discount_merchandise, "crm_pos_discount_merchandise");
		  $kirim = array(
			"id_crm_pos_discount_merchandise"   => $id_crm_pos_discount_merchandise,
			"id_crm_pos_products_merchandise"   => $dt->id_crm_pos_products_merchandise,
			"id_crm_pos_discount"               => $pst['id_crm_pos_discount'],
			"status"                            => 1,
			"create_by_users"                   => $this->session->userdata("id"),
			"create_date"                       => date("Y-m-d H:i:s")
		  );
		  $this->global_models->insert("crm_pos_discount_merchandise", $kirim);
		}
	}
	  
	
	$data1 = $this->global_models->get_query("SELECT A.id_crm_pos_discount_merchandise"
      . " ,B.title AS merchandise"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = B.id_crm_pos_products) AS products"
      . " FROM crm_pos_discount_merchandise AS A"
      . " LEFT JOIN crm_pos_products_merchandise AS B ON B.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " AND A.status = 1"
      . " ORDER BY A.create_date DESC"         
      . "");
      
    foreach ($data1 AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->products,
            "value"   => $dt->products
          ),
          array(
            "view"    => $dt->merchandise,
            "value"   => $dt->merchandise
          ),
		  array(
            "view"    => "<button class='btn btn-danger btn-sm merchandise-hasil-delete' isi='{$dt->id_crm_pos_discount_merchandise}'><i class='fa fa-times'></i></button>",
            "value"   => $dt->id_crm_pos_discount_merchandise
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_products_merchandise
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
   //   $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
	 
	
	print json_encode($hasil);
    die;
  }
  
  function merchandise_discount_delete(){
    $pst = $this->input->post();
    $this->global_models->update("crm_pos_discount_merchandise", array("id_crm_pos_discount_merchandise" => $pst['id']), array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id")
    ));
    
    $balik['data'] = $this->_merchandise_format_single_record($this->global_models->get_field("crm_pos_discount_merchandise", "id_crm_pos_products_merchandise"), array("id_crm_pos_discount_merchandise" => $pst['id']));
    print json_encode($balik);
    die;
  }
  
  function merchandise_discount_delete_all(){
    $pst = $this->input->post();	
	$data = $this->global_models->get_query("SELECT A.id_crm_pos_discount_merchandise"
      . " ,B.title AS merchandise"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = B.id_crm_pos_products) AS products"
      . " FROM crm_pos_discount_merchandise AS A"
      . " LEFT JOIN crm_pos_products_merchandise AS B ON B.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " AND A.status = 1"
      . " ORDER BY A.create_date DESC"      
      . "");
      
    foreach ($data AS $dt){
		$id_crm_pos_discount_merchandise = $dt->id_crm_pos_discount_merchandise;
		$this->global_models->update("crm_pos_discount_merchandise", array("id_crm_pos_discount_merchandise" => $id_crm_pos_discount_merchandise), array(
			  "status"          => 2,
			  "update_by_users" => $this->session->userdata("id")
			));	
	
	}

	$data1 = $this->global_models->get_query("SELECT A.*"
		  . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = A.id_crm_pos_products) AS products"
		  . " FROM crm_pos_products_merchandise AS A"
		  . " WHERE A.id_crm_pos_products_merchandise NOT IN (SELECT B.id_crm_pos_products_merchandise FROM crm_pos_discount_merchandise AS B WHERE B.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}' AND B.status = 1)"
		  . " ORDER BY A.create_date DESC"
		  . "");
	
	foreach ($data1 AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->products,
            "value"   => $dt->products
          ),
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_merchandise
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']  = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
	
	// $hasil['hasil'] = $this->merchandise_get;
	// $hasil['status']  = 2;
	print json_encode($hasil);
    die;
  }
  
  function _merchandise_discount_format_single_record($id){
    $data = $this->global_models->get_query("SELECT "
      . " B.title AS merchandise"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = B.id_crm_pos_products) AS products"
      . " FROM crm_pos_discount_merchandise AS A"
      . " LEFT JOIN crm_pos_products_merchandise AS B ON B.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise"
      . " WHERE A.id_crm_pos_discount_merchandise = '{$id}'");
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->products,
            "value"   => $data[0]->products
          ),
          array(
            "view"    => $data[0]->merchandise,
            "value"   => $data[0]->merchandise
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm merchandise-hasil-delete' isi='{$id}'><i class='fa fa-times'></i></button>",
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $id,
      );
    return $balik;
  }
  
  function _merchandise_format_single_record($id){
    $data = $this->global_models->get_query("SELECT "
      . " B.title AS merchandise"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = B.id_crm_pos_products) AS products"
      . " FROM crm_pos_products_merchandise AS B"
      . " WHERE B.id_crm_pos_products_merchandise = '{$id}'");
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->products,
            "value"   => $data[0]->products
          ),
          array(
            "view"    => $data[0]->merchandise,
            "value"   => $data[0]->merchandise
          ),
        ),
        "select"  => false,
        "id"      => $id,
      );
    return $balik;
  }
  
  function merchandise_discount_get(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.id_crm_pos_discount_merchandise"
      . " ,B.title AS merchandise"
      . " ,(SELECT C.title FROM crm_pos_products AS C WHERE C.id_crm_pos_products = B.id_crm_pos_products) AS products"
      . " FROM crm_pos_discount_merchandise AS A"
      . " LEFT JOIN crm_pos_products_merchandise AS B ON B.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " AND A.status = 1"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
      
    foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->products,
            "value"   => $dt->products
          ),
          array(
            "view"    => $dt->merchandise,
            "value"   => $dt->merchandise
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm merchandise-hasil-delete' isi='{$dt->id_crm_pos_discount_merchandise}'><i class='fa fa-times'></i></button>",
            "value"   => $dt->id_crm_pos_discount_merchandise
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_merchandise
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
  
  function group_customer_discount_get(){
      
    $pst = $this->input->post();
    
    $data = $this->global_models->get_query(" SELECT A.id_crm_pos_discount_company,"
      . "B.kode,B.title AS customer,C.title AS channel"
      . " FROM crm_pos_discount_company AS A"
      . " LEFT JOIN crm_customer_company AS B ON B.id_crm_customer_company = A.id_crm_customer_company"
      . " LEFT JOIN crm_customer_company AS C ON C.id_crm_customer_company = B.parent"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " ORDER BY C.title ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
//    print  $this->db->last_query();
//    die;
       foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->kode,
            "value"   => $dt->kode
          ),
          array(
            "view"    => $dt->channel,
            "value"   => $dt->channel
          ),
          array(
            "view"    => $dt->customer,
            "value"   => $dt->customer
          ),  
          array(
            "view"    => "<button class='btn btn-danger btn-sm group-customer-delete' isi='{$dt->id_crm_pos_discount_company}'><i class='fa fa-times'></i></button>",
            "value"   => $dt->id_crm_pos_discount_company
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_company
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
  
  function discount_payment_channel_get(){
      
    $pst = $this->input->post();
    
    $data = $this->global_models->get_query(" SELECT A.*,"
      . "B.code,B.title"
      . " FROM crm_pos_discount_payment_channel AS A"
      . " LEFT JOIN crm_payment_channel AS B ON B.id_crm_payment_channel = A.id_crm_payment_channel"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " ORDER BY B.title ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
//    print  $this->db->last_query();
//    die;
       foreach ($data AS $dt){
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $dt->title,
            "value"   => $dt->title
          ),
          array(
            "view"    => $dt->code,
            "value"   => $dt->code
          ),
          array(
            "view"    => "<button class='btn btn-danger btn-sm payment-channel-delete' isi='{$dt->id_crm_pos_discount_payment_channel}'><i class='fa fa-times'></i></button>",
            "value"   => $dt->id_crm_pos_discount_payment_channel
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_payment_channel
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
  
  function discount_voucher_get(){
      
    $pst = $this->input->post();
    
    $data = $this->global_models->get_query(" SELECT A.*"
      . " FROM crm_pos_discount_voucher AS A"
      . " WHERE A.id_crm_pos_discount = '{$pst['id_crm_pos_discount']}'"
      . " AND A.status = 1"
      . " ORDER BY A.create_date DESC"
      . " LIMIT {$pst['start']}, 20"
      . "");
//    print  $this->db->last_query();
//    die;
    $type = $this->global_variable->crm_discount_voucher_type(1);
    foreach ($data AS $dt){
      $button = "<button class='btn btn-danger btn-sm voucher-delete' isi='{$dt->id_crm_pos_discount_voucher}'><i class='fa fa-times'></i></button>";
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $data[0]->title,
            "value"   => $data[0]->title
          ),
          array(
            "view"    => $data[0]->startdate,
            "value"   => strtotime($data[0]->startdate)
          ),
          array(
            "view"    => $data[0]->enddate,
            "value"   => strtotime($data[0]->enddate)
          ),
          array(
            "view"    => $data[0]->batas."<br />".$type[$data[0]->type],
            "value"   => $data[0]->batas."<br />".$type[$data[0]->type]
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $dt->id_crm_pos_discount_voucher
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
  
  function group_customer_discount_delete(){
      $pst = $this->input->post();
      
      $get = $this->global_models->get("crm_pos_discount_company",array("id_crm_pos_discount_company" => "{$pst['id']}"));
      
      if($get[0]->id_crm_pos_discount_company){
        $this->global_models->trans_begin();
        $this->global_models->delete("crm_pos_discount_company",array("id_crm_pos_discount_company" => "{$get[0]->id_crm_pos_discount_company}"));
        $this->global_models->trans_commit();
        $balik= array("status" => 2,
                      "note" => "Proses");
      }else{
        $balik = array("status" => 3,
                       "note" => "Failed Proses");  
      }
      
      print json_encode($balik);
      die;
    }
    
    function company_dropdown_get($parent = NULL){
    $where = "(A.parent IS NOT NULL OR A.parent > 0)";
    if($parent)
      $where = "A.parent = '{$parent}'";
    $data_company = $this->global_models->get_query("SELECT A.id_crm_customer_company, A.title, A.kode"
      . " FROM crm_customer_company AS A"
      . " WHERE A.status = 1"
      . " AND {$where}"
      . " ORDER BY A.code ASC");
    foreach ($data_company AS $cs){
      $company[] = array(
        "id"    => $cs->id_crm_customer_company,
        "text"  => $cs->kode."-".$cs->title,
      );
      $company2[$cs->id_crm_customer_company] = $cs->kode."-".$cs->title;
    }
    $hasil['status'] = 2;
    $hasil['v1'] = $company2;
    $hasil['v2'] = $company;
    return $hasil;
  }
  
   function group_customer_dropdown_get(){
    $pst = $this->input->post();
    
     $where = "A.parent = '{$pst['id']}'";
    $data_company = $this->global_models->get_query("SELECT A.id_crm_customer_company, A.title, A.kode"
      . " FROM crm_customer_company AS A"
      . " WHERE A.status = 1"
      . " AND {$where}"
      . " ORDER BY A.code ASC");
    foreach ($data_company AS $cs){
      $company[] = array(
        "id"    => $cs->id_crm_customer_company,
        "text"  => $cs->kode."-".$cs->title,
      );
      
    }
   
    print json_encode($company);
    die;
  }
  
  function group_customer_discount_set(){
      $pst = $this->input->post();
      
    if($pst['id_crm_pos_discount']){
     if($pst['parent'] <> "" AND $pst['id_crm_customer_company'] <> ""){
      $get = $this->global_models->get("crm_pos_discount_company",array("id_crm_pos_discount" => "{$pst['id_crm_pos_discount']}","id_crm_customer_company" =>"{$pst['id_crm_customer_company']}"));
      if($get[0]->id_crm_pos_discount_company == ""){
          $kirim = array(
          "id_crm_pos_discount"     => $pst['id_crm_pos_discount'],
          "id_crm_customer_company" => $pst['id_crm_customer_company'],
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
          
        $id_crm_pos_discount_company = $this->global_models->insert("crm_pos_discount_company", $kirim);
        $data = $this->_group_customer_discount_format_single_record($id_crm_pos_discount_company); 
        $balik = array("status" => 2,
                        "note" => "Success Proses",
                        "data"  => $data);
      }else{
          $balik = array("status" => 3,
                         "note" => "Failed Proses");
       }
     }else{
         $note = "";
         if($pst['parent'] == ""){
             $note .= "Channel Type must Filled <br>";
         }
         if($pst['id_crm_customer_company'] == ""){
              $note .= "Group Customer must Filled";
         }
         $balik = array("status" => 3,
                       "note"   => $note);
     }
    
    }else{
         $balik = array("status" => 3,
                         "note" => "Please Select Scheme Discount");
    }
      
      
       print json_encode($balik);
    die;
  }
  
  function _group_customer_discount_format_single_record($id){
      
     $data = $this->global_models->get_query("SELECT A.id_crm_pos_discount_company,"
      . "B.kode,B.title AS customer,C.title AS channel"
      . " FROM crm_pos_discount_company AS A"
      . " LEFT JOIN crm_customer_company AS B ON B.id_crm_customer_company = A.id_crm_customer_company"
      . " LEFT JOIN crm_customer_company AS C ON C.id_crm_customer_company = B.parent"
      . " WHERE A.id_crm_pos_discount_company = '{$id}'"
      . "");
      
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $data[0]->kode,
            "value"   => $data[0]->kode
          ),
          array(
            "view"    => $data[0]->channel,
            "value"   => $data[0]->channel
          ),
          array(
            "view"    => $data[0]->customer,
            "value"   => $data[0]->customer
          ),
         array(
            "view"    => "<button class='btn btn-danger btn-sm group-customer-delete' isi='{$data[0]->id_crm_pos_discount_company}'><i class='fa fa-times'></i></button>",
            "value"   => $data[0]->id_crm_pos_discount_company
         ), 
        ),
        "select"  => false,
        "number"  => $data[0]->kode,            
        "id"      => $id,
      );
    return $balik;
  }
  
}