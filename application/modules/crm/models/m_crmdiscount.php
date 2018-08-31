<?php
class M_crmdiscount extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function approve_discount($id_crm_pos_quotation_discount){
    $this->global_models->update("crm_pos_quotation_discount", array("id_crm_pos_quotation_discount" => $id_crm_pos_quotation_discount), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_discount;
  }
  
  function delete_discount($id_crm_pos_quotation_discount){
    $this->global_models->update("crm_pos_quotation_discount", array("id_crm_pos_quotation_discount" => $id_crm_pos_quotation_discount), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_discount;
  }
  
  function discount_quotation_delete_gradual($id_crm_pos_quotation){
    $this->global_models->update("crm_pos_quotation_discount", array("id_crm_pos_quotation" => $id_crm_pos_quotation, "bertingkat" => 2), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_discount;
  }
  
  function availibility_discount_get($param){
      
    $filter = "";
    if($param['flag']){
        $filter = " AND IF(A.is_company=1,B.id_crm_customer_company='{$param['id_crm_customer_company']}',A.is_company=2)";
//        $filter = " AND (A.is_company = 2 OR (A.is_company = 1 AND B.id_crm_customer_company='{$param['id_crm_customer_company']}'";
    }

    if($param['flag'] == 1){
//        $filter .= " AND A.id_crm_pos_discount IN (SELECT C.id_crm_pos_discount FROM crm_pos_discount_merchandise AS C "
//            . " LEFT JOIN crm_pos_order_merchandise AS D ON D.id_crm_pos_products_merchandise = C.id_crm_pos_products_merchandise "
//            . " WHERE D.id_crm_pos_order = '{$param['id_crm_pos_order']}' AND D.status=1"
//            . " GROUP BY C.id_crm_pos_discount)";
    }else{
//        $filter .= " AND A.id_crm_pos_discount IN (SELECT C.id_crm_pos_discount FROM crm_pos_discount_merchandise AS C "
//            . " LEFT JOIN crm_pos_quotation_merchandise AS D ON D.id_crm_pos_products_merchandise = C.id_crm_pos_products_merchandise "
//            . " WHERE D.id_crm_pos_quotation = '{$param['id_crm_pos_quotation']}' AND D.status=1"
//            . " GROUP BY C.id_crm_pos_discount)";
    }
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount AS A"
      . " LEFT JOIN crm_pos_discount_company AS B ON B.id_crm_pos_discount = A.id_crm_pos_discount"
      . " WHERE A.status = 1"
      . " AND (A.bataswaktu = 2"
          . " OR (A.bataswaktu = 1 AND ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate)))"
      . " AND (A.merchandise <> 1 OR A.merchandise IS NULL)"
//      . " AND (A.approve = 2 OR (A.approve = 1 AND (SELECT SUM(C.nilai) FROM crm_pos_discount_set AS C WHERE C.id_crm_pos_discount = A.id_crm_pos_discount) >= 100))"
      . "{$filter}"
      . " ORDER BY A.sort ASC"
      . "");
//      print_r($param)."<br>";
//      die;
//      print_r($param);
//      die;
    
    $hasil = array();

if($param['flag'] == 1){
    foreach($data AS $dt){
      $hasil[] = array(
        "sort"      => $dt->sort,
        "view"      => $dt->title,
        "nominal"   => $dt->nilai,
        "value"     => $dt->id_crm_pos_discount,
        "editable"  => ($dt->editable == 2 ? "not-editable" : "editable"),
        "cashback"  => ($dt->cashback == 2 ? "not-editable" : "editable"),
        "type"      => ($dt->type == 2 ? lang("Nominal") : lang("Persentase")),
        
      );
    }
}elseif($param['flag'] == 2){
    foreach($data AS $dt){
      $hasil[] = array(
        "sort"      => $dt->sort,
        "view"      => $dt->title,
        "nominal"   => $dt->nilai,
        "value"     => $dt->id_crm_pos_discount,
        "editable"  => ($dt->editable == 2 ? "not-editable" : "editable"),
        "type"      => ($dt->type == 2 ? lang("Nominal") : lang("Persentase")),
      );
    }
}else{
    foreach($data AS $dt){
      $hasil[] = array(
        "id_crm_pos_discount"         => $dt->id_crm_pos_discount,
        "title"                       => $dt->title,
        "sort"                        => $dt->sort,
        "nominal"                     => $dt->nilai,
        "type"                        => $dt->type,
        "editable"                    => $dt->editable,
        "cashback"                    => $dt->cashback,
      );
    }
}
    return $hasil;
  }
  
  function availibility_discount_merchandise_get($param){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_discount AS A"
      . " WHERE A.status = 1"
      . " AND (A.bataswaktu = 2"
          . " OR (A.bataswaktu = 1 AND ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate)))"
      . " AND A.merchandise = 1"
      . " AND A.id_crm_pos_discount IN (SELECT B.id_crm_pos_discount FROM crm_pos_discount_merchandise AS B WHERE B.status = 1 AND B.id_crm_pos_products_merchandise = '{$param['id_crm_pos_products_merchandise']}')"
//      . " AND (A.approve = 2 OR (A.approve = 1 AND (SELECT SUM(C.nilai) FROM crm_pos_discount_set AS C WHERE C.id_crm_pos_discount = A.id_crm_pos_discount) >= 100))"
      . " AND (A.is_company = 2 OR (A.is_company = 1 AND A.id_crm_pos_discount IN (SELECT D.id_crm_pos_discount FROM crm_pos_discount_company AS D WHERE D.id_crm_customer_company = '{$param['id_crm_customer_company']}')))"
      . " ORDER BY A.sort ASC"
      . "");
//      print $this->db->last_query();
//      die;
    $hasil = array();
    
    foreach($data AS $dt){
      $hasil[] = array(
        "id_crm_pos_discount"         => $dt->id_crm_pos_discount,
        "title"                       => $dt->title,
        "sort"                        => $dt->sort,
        "nominal"                     => $dt->nilai,
        "type"                        => $dt->type,
        "editable"                    => $dt->editable,
        "cashback"                    => $dt->cashback,
      );
    }
    return $hasil;
  }
  
  function set_discount($pst){
    $discount = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $pst['id_crm_pos_discount']));
    
    if($discount[0]->bertingkat == 2){
      $this->discount_quotation_delete_gradual($pst['id_crm_pos_quotation']);
    }
    
    $this->global_models->generate_id($id_crm_pos_quotation_discount, "crm_pos_quotation_discount");
    $status = ($discount[0]->approve == 1 ? 4 : 1);
    $kirim = array(
      "id_crm_pos_quotation_discount"         => $id_crm_pos_quotation_discount,
      "id_crm_pos_discount"                   => $pst['id_crm_pos_discount'],
      "id_crm_pos_quotation"                  => $pst['id_crm_pos_quotation'],
      "potongan"                              => 0,
      "nilai"                                 => ($discount[0]->editable == 1 ? $pst['nominal'] : $discount[0]->nilai),
      "type"                                  => $discount[0]->type,
      "status"                                => $status,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "bertingkat"                            => $discount[0]->bertingkat,
      "approve"                               => $discount[0]->approve,
      "sort"                                  => $pst['sort'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_quotation_discount", $kirim);
    return $id_crm_pos_quotation_discount;
  }
  
  function get_discount($id_crm_pos_quotation){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_quotation_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'"
      . " ORDER BY A.sort ASC"
      . "");
    return $data;
  }
  
  function get_discount_fix($id_crm_pos_quotation){
    $data = $this->global_models->get_query("SELECT SUM(A.potongan) AS total"
      . " FROM crm_pos_quotation_discount AS A"
      . " WHERE A.status = 2"
      . " AND A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'"
      . "");
    $hasil = array(
      "total"     => $data[0]->total
    );
    return $hasil;
  }
  
  function get_order_discount($id_crm_pos_order){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_order_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_order = '{$id_crm_pos_order}'"
      . " ORDER BY A.sort ASC"
      . "");
    return $data;
  }
  
  function generate_discount($id_crm_pos_quotation){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_quotation_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'"
      . " ORDER BY A.sort ASC"
      . "");
      
    $total_belanja = $this->global_models->get_field("crm_pos_quotation_merchandise", "SUM(price)", array("status" => 1, "id_crm_pos_quotation" => $id_crm_pos_quotation));
    $total_addon = $this->global_models->get_field("crm_pos_quotation_merchandise_addon", "SUM(price)", array("status" => 1, "id_crm_pos_quotation" => $id_crm_pos_quotation));
    $total_merchandise_discount_temp = $this->global_models->get_query("SELECT SUM(A.potongan) AS potongan"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.status = 2"
      . " AND A.id_crm_pos_quotation_merchandise IN (SELECT B.id_crm_pos_quotation_merchandise FROM crm_pos_quotation_merchandise AS B WHERE B.id_crm_pos_quotation = '{$id_crm_pos_quotation}' AND B.status = 1)");
    $total_merchandise_discount = $total_merchandise_discount_temp[0]->potongan;
    
    $total_belanja = $belanja_akhir = $total_belanja + $total_addon - $total_merchandise_discount;
    foreach ($data AS $key => $dt){
      $id_crm_pos_approval_settings = NULL;
      $potongan = 0;
      if($dt->type == 2){
        $nilai = $dt->nilai;
        $nilai_dari = $belanja_akhir;
      }
      else{
        if($dt->bertingkat == 2){
          $nilai = $total_belanja * $dt->nilai/100;
          $nilai_dari = $total_belanja;
        }
        else{
          $nilai = $belanja_akhir * $dt->nilai/100;
          $nilai_dari = $belanja_akhir;
        }
      }
      
      if($dt->approve == 1){
        $id_crm_pos_approval_settings = $this->get_approve_settings($dt->id_crm_pos_discount, $dt->nilai, $dt->type, $belanja_akhir);
        $status = 4;
      }
      else{
        $status = 2;
      }
      $data[$key]->potongan = $potongan = $nilai;
      $belanja_akhir = $belanja_akhir - $nilai;
      
      $dt->status = $status;
      $dt->potongan = $potongan;
      
      $this->global_models->update("crm_pos_quotation_discount", array("id_crm_pos_quotation_discount" => $dt->id_crm_pos_quotation_discount), array(
        "id_crm_pos_approval_settings"  => $id_crm_pos_approval_settings,
        "status"          => $status,
        "potongan"        => $potongan,
        "nilai_dari"      => $nilai_dari,
        "update_by_users" => $this->session->userdata("id"),
      ));
    }
    return $data;
  }
  
  function get_approve_settings($id_crm_pos_discount, $potongan, $type, $belanja_akhir){
    if($type == 2){
      $x_belanja_akhir = $belanja_akhir/100;
      $pot = $potongan/$x_belanja_akhir;
    }
    else{
      $pot = $potongan;
    }
    $data = $this->global_models->get_query("SELECT A.id_crm_pos_approval_settings"
      . " FROM crm_pos_discount_set AS A"
      . " WHERE A.nilai >= {$pot}"
      . " AND A.id_crm_pos_discount = '{$id_crm_pos_discount}'"
      . " ORDER BY A.nilai ASC LIMIT 0,1");
    $id_crm_pos_approval_settings = $data[0]->id_crm_pos_approval_settings;
    return $id_crm_pos_approval_settings;
  }
  
  function discount_merchandise_quotation_set($pst, $id_crm_pos_quotation_merchandise){
    
    $data = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $pst['id_crm_pos_discount']));
    if($data[0]->bertingkat == 2){
      $this->discount_merchandise_quotation_delete_gradual($id_crm_pos_quotation_merchandise);
    }
    
    $this->global_models->generate_id($id_crm_pos_quotation_merchandise_discount, "crm_pos_quotation_merchandise_discount");
    $kirim = array(
      "id_crm_pos_quotation_merchandise_discount" => $id_crm_pos_quotation_merchandise_discount,
      "id_crm_pos_discount"                       => $pst['id_crm_pos_discount'],
      "id_crm_pos_quotation_merchandise"          => $id_crm_pos_quotation_merchandise,
      "tanggal"                                   => date("Y-m-d H:i:s"),
      "potongan"                                  => 0,
      "nilai"                                     => $pst['nominal'],
      "qty"                                       => $pst['qty'] * $pst['frequency'],
      "status"                                    => 1,
      "type"                                      => $data[0]->type,
      "bertingkat"                                => $data[0]->bertingkat,
      "sort"                                      => $pst['sort'],
      "approve"                                   => $data[0]->approve,
      "note"                                      => $pst['note'],
      "create_by_users"                           => $this->session->userdata("id"),
      "create_date"                               => date("Y-m-d H:i:s"),
    );
    
    $this->global_models->insert("crm_pos_quotation_merchandise_discount", $kirim);
    return $id_crm_pos_quotation_merchandise_discount;
  }
  
  function discount_merchandise_generate($id_crm_pos_quotation_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . " ORDER BY A.sort ASC"
      . "");
      
    $total_belanja = $this->global_models->get_field("crm_pos_quotation_merchandise", "price", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise));
    
    $addon = $this->global_models->get_query("SELECT SUM(price) AS total FROM `crm_pos_quotation_merchandise_addon` WHERE category=1 AND status=1 and id_crm_pos_quotation_merchandise='{$id_crm_pos_quotation_merchandise}' ");
   
    $belanja_akhir = $total_belanja + $addon[0]->total;
    
    foreach ($data AS $key => $dt){
      $id_crm_pos_approval_settings = NULL;
      $potongan = 0;
      if($dt->type == 2){
        $nilai = $dt->nilai * $dt->qty;
        $nilai_dari = $total_belanja + $addon[0]->total;
      }
      else{
        if($dt->bertingkat == 2){
          $nilai = $total_belanja * $dt->nilai/100;
          $nilai_dari = $total_belanja + $addon[0]->total;
        }
        else{
          $nilai = $belanja_akhir * $dt->nilai/100;
          $nilai_dari = $belanja_akhir;
        }
      }
      
      if($dt->approve == 1){
        $id_crm_pos_approval_settings = $this->get_approve_settings($dt->id_crm_pos_discount, $dt->nilai, $dt->type, $belanja_akhir);
        $status = 4;
      }
      else{
        $status = 2;
      }
      $data[$key]->potongan = $potongan = $nilai;
      $belanja_akhir = $belanja_akhir - $nilai;
      
      $dt->status = $status;
      $dt->potongan = $potongan;
      
      $this->global_models->update("crm_pos_quotation_merchandise_discount", array("id_crm_pos_quotation_merchandise_discount" => $dt->id_crm_pos_quotation_merchandise_discount), array(
        "id_crm_pos_approval_settings"  => $id_crm_pos_approval_settings,
        "status"          => $status,
        "potongan"        => $potongan,
        "nilai_dari"      => $total_belanja + $addon[0]->total,
        "update_by_users" => $this->session->userdata("id"),
      ));
    }
    return $data;
  }
  
  function merchandise_discount_get($id_crm_pos_quotation_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . " ORDER BY A.sort ASC"
      . "");
    return $data;
  }
  
  function merchandise_discount_get_fix($id_crm_pos_quotation_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
	  . " ,(SELECT C.nameinprint FROM crm_pos_discount AS C WHERE C.id_crm_pos_discount = A.id_crm_pos_discount) AS nameinprint"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.status = 2"
      . " AND A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . " ORDER BY A.sort ASC"
      . "");
    return $data;
  }
  
  function merchandise_discount_sum($id_crm_pos_quotation_merchandise){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS total"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . " AND A.status IN (2,4)");
    return $total[0]->total;
  }
  
  function order_merchandise_discount_sum($id_crm_pos_order_merchandise){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS total"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'"
      . " AND A.status IN (2,4)");
    return $total[0]->total;
  }
  
  function merchandise_discount_delete($id_crm_pos_quotation_merchandise_discount){
    $this->global_models->update("crm_pos_quotation_merchandise_discount", array("id_crm_pos_quotation_merchandise_discount" => $id_crm_pos_quotation_merchandise_discount), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_merchandise_discount;
  }
  
  function discount_merchandise_quotation_delete_gradual($id_crm_pos_quotation_merchandise){
    $this->global_models->update("crm_pos_quotation_merchandise_discount", array("bertingkat" => 2, "id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_merchandise_discount;
  }
  
  function discount_quotation_merchandise_delete_all($id_crm_pos_quotation){
    $this->global_models->query("UPDATE crm_pos_quotation_merchandise_discount"
      . " SET status = 3, update_by_users = {$this->session->userdata("id")}"
      . " WHERE id_crm_pos_quotation_merchandise IN (SELECT A.id_crm_pos_quotation_merchandise FROM crm_pos_quotation_merchandise AS A WHERE A.id_crm_pos_quotation = '{$id_crm_pos_quotation}')");
    return $id_crm_pos_quotation;
  }
  
  function discount_quotation_delete_all($id_crm_pos_quotation){
    $this->global_models->update("crm_pos_quotation_discount", array("id_crm_pos_quotation" => $id_crm_pos_quotation), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation;
  }
  
  function merchandise_discount_approve($id_crm_pos_quotation_merchandise_discount){
    $this->global_models->update("crm_pos_quotation_merchandise_discount", array("id_crm_pos_quotation_merchandise_discount" => $id_crm_pos_quotation_merchandise_discount), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_merchandise_discount;
  }
  
  function order_merchandise_discount_get($id_crm_pos_order_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
	  . " ,(SELECT C.nameinprint FROM crm_pos_discount AS C WHERE C.id_crm_pos_discount = A.id_crm_pos_discount) AS nameinprint"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'"
      . " ORDER BY A.sort ASC"
      . "");
    return $data;
    
  }
  
  function discount_order_delete_all($id_crm_pos_order){
    $this->global_models->update("crm_pos_order_discount", array("id_crm_pos_order" => $id_crm_pos_order), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order;
  }
  
  function discount_merchandise_order_set($pst, $id_crm_pos_order_merchandise){

    $data = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $pst['id_crm_pos_discount']));
    if($data[0]->bertingkat == 2){
      $this->discount_merchandise_order_delete_gradual($id_crm_pos_order_merchandise);
      $this->discount_merchandise_cashback_order_delete_gradual($id_crm_pos_order_merchandise);
    }
    
    $this->global_models->generate_id($id_crm_pos_order_merchandise_discount, "crm_pos_order_merchandise_discount");
    $kirim = array(
      "id_crm_pos_order_merchandise_discount"     => $id_crm_pos_order_merchandise_discount,
      "id_crm_pos_discount"                       => $pst['id_crm_pos_discount'],
      "id_crm_pos_order_merchandise"              => $id_crm_pos_order_merchandise,
      "tanggal"                                   => date("Y-m-d H:i:s"),
      "potongan"                                  => 0,
      "nilai"                                     => $pst['nominal'],
      "status"                                    => 1,
      "type"                                      => $data[0]->type,
      "qty"                                       => $pst['qty'] * $pst['frequency'],
      "bertingkat"                                => $data[0]->bertingkat,
      "sort"                                      => $pst['sort'],
      "approve"                                   => $data[0]->approve,
      "note"                                      => $pst['note'],
      "create_by_users"                           => $this->session->userdata("id"),
      "create_date"                               => date("Y-m-d H:i:s"),
    );
    
    if($data[0]->cashback == 1){
      $this->global_models->generate_id($id_crm_pos_order_merchandise_discount_cashback, "crm_pos_order_merchandise_discount_cashback");
      
      $kirim_cn = array(
        "id_crm_pos_order_merchandise_discount_cashback"  => $id_crm_pos_order_merchandise_discount_cashback,
        "id_crm_pos_order_merchandise_discount"           => $id_crm_pos_order_merchandise_discount,
        "id_crm_pos_order"                                => $this->global_models->get_field("crm_pos_order_merchandise", "id_crm_pos_order", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise)),
        "id_crm_pos_order_merchandise"                    => $id_crm_pos_order_merchandise,
        "tanggal"                                         => date("Y-m-d H:i:s"),
        "nominal"                                         => 0,
        "nilai"                                           => $pst['cn'],
        "type"                                            => $data[0]->type,
        "status"                                          => 1,
        "create_by_users"                                 => $this->session->userdata("id"),
        "create_date"                                     => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_order_merchandise_discount_cashback", $kirim_cn);
    }
    
    $this->global_models->insert("crm_pos_order_merchandise_discount", $kirim);
    return $id_crm_pos_order_merchandise_discount;
  }
  
  function discount_merchandise_order_delete_gradual($id_crm_pos_order_merchandise){
    $this->global_models->update("crm_pos_order_merchandise_discount", array("bertingkat" => 2, "id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_merchandise_discount;
  }
  
  function discount_order_merchandise_generate($id_crm_pos_order_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'"
      . " ORDER BY A.sort ASC"
      . "");
      
    $total_belanja = $this->global_models->get_field("crm_pos_order_merchandise", "price", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise));
    $addon = $this->global_models->get_query("SELECT SUM(price) AS total FROM `crm_pos_order_merchandise_addon` WHERE category=1 AND status=1 and id_crm_pos_order_merchandise='{$id_crm_pos_order_merchandise}' ");
   
    $belanja_akhir = $total_belanja + $addon[0]->total;
    
    foreach ($data AS $key => $dt){
      $cn = $this->global_models->get("crm_pos_order_merchandise_discount_cashback", array("id_crm_pos_order_merchandise_discount" => $dt->id_crm_pos_order_merchandise_discount));
      
      $id_crm_pos_approval_settings = NULL;
      $potongan = $nilai_dari = 0;
      if($dt->type == 2){
        $nilai = $dt->nilai * $dt->qty;
        $data_cn['nilai'] = $cn[0]->nilai;
        $nilai_dari = $belanja_akhir;
      }
      else{
        if($dt->bertingkat == 2){
          $nilai = $total_belanja * $dt->nilai/100;
          $nilai_dari = $total_belanja + $addon[0]->total;
          $data_cn['nilai'] = $total_belanja * $cn[0]->nilai/100;
        }
        else{
          $nilai = $belanja_akhir * $dt->nilai/100;
          $data_cn['nilai'] = $belanja_akhir * $cn[0]->nilai/100;
          $nilai_dari = $belanja_akhir;
        }
      }
      
      if($dt->approve == 1){
        $id_crm_pos_approval_settings = $this->get_approve_settings($dt->id_crm_pos_discount, $dt->nilai, $dt->type, $belanja_akhir);
        $status = 4;
      }
      else{
        $status = 2;
      }
      $data[$key]->potongan = $potongan = $nilai;
      $belanja_akhir = $belanja_akhir - $nilai;
      
      $dt->status = $status;
      $dt->potongan = $potongan;
      
      $this->global_models->update("crm_pos_order_merchandise_discount", array("id_crm_pos_order_merchandise_discount" => $dt->id_crm_pos_order_merchandise_discount), array(
        "id_crm_pos_approval_settings"  => $id_crm_pos_approval_settings,
        "status"          => $status,
        "potongan"        => $potongan,
        "nilai_dari"      => $nilai_dari,
        "update_by_users" => $this->session->userdata("id"),
      ));
      $this->global_models->update("crm_pos_order_merchandise_discount_cashback", array("id_crm_pos_order_merchandise_discount_cashback" => $cn[0]->id_crm_pos_order_merchandise_discount_cashback), array(
        "nominal"         => $data_cn['nilai'],
        "nilai_dari"      => $nilai_dari,
        "update_by_users" => $this->session->userdata("id"),
      ));
    }
    return $data;
  }
  
  function order_merchandise_discount_approve($id_crm_pos_order_merchandise_discount){
    $this->global_models->update("crm_pos_order_merchandise_discount", array("id_crm_pos_order_merchandise_discount" => $id_crm_pos_order_merchandise_discount), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_merchandise_discount;
  }
  
  function order_merchandise_discount_delete($id_crm_pos_order_merchandise_discount){
    $this->global_models->update("crm_pos_order_merchandise_discount", array("id_crm_pos_order_merchandise_discount" => $id_crm_pos_order_merchandise_discount), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_merchandise_discount;
  }
  
  function discount_order_merchandise_delete_all($id_crm_pos_order){
    $this->global_models->query("UPDATE crm_pos_order_merchandise_discount"
      . " SET status = 3, update_by_users = {$this->session->userdata("id")}"
      . " WHERE id_crm_pos_order_merchandise IN (SELECT A.id_crm_pos_order_merchandise FROM crm_pos_order_merchandise AS A WHERE A.id_crm_pos_order = '{$id_crm_pos_order}') AND bertingkat = 2");
    return $id_crm_pos_order;
  }
  
  function order_set_discount($pst){
    $discount = $this->global_models->get("crm_pos_discount", array("id_crm_pos_discount" => $pst['id_crm_pos_discount']));
    
    if($discount[0]->bertingkat == 2){
      $this->discount_order_delete_gradual($pst['id_crm_pos_order']);
      $this->discount_cashback_order_delete_gradual($pst['id_crm_pos_order']);
    }
    
    $this->global_models->generate_id($id_crm_pos_order_discount, "crm_pos_order_discount");
    $status = ($discount[0]->approve == 1 ? 4 : 1);
    $kirim = array(
      "id_crm_pos_order_discount"             => $id_crm_pos_order_discount,
      "id_crm_pos_discount"                   => $pst['id_crm_pos_discount'],
      "id_crm_pos_order"                      => $pst['id_crm_pos_order'],
      "potongan"                              => 0,
      "nilai"                                 => ($discount[0]->editable == 1 ? $pst['nominal'] : $discount[0]->nilai),
      "type"                                  => $discount[0]->type,
      "status"                                => $status,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "bertingkat"                            => $discount[0]->bertingkat,
      "approve"                               => $discount[0]->approve,
      "sort"                                  => $pst['sort'],
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_order_discount", $kirim);
    
    if($discount[0]->cashback == 1){
      $this->global_models->generate_id($id_crm_pos_order_discount_cashback, "crm_pos_order_discount_cashback");
      $kirim_cn = array(
        "id_crm_pos_order_discount_cashback"    => $id_crm_pos_order_discount_cashback,
        "id_crm_pos_order_discount"             => $id_crm_pos_order_discount,
        "tanggal"                               => date("Y-m-d H:i:s"),
        "nominal"                               => 0,
        "nilai"                                 => $pst['cn'],
        "type"                                  => $discount[0]->type,
        "status"                                => 1,
        "create_by_users"                       => $this->session->userdata("id"),
        "create_date"                           => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_order_discount_cashback", $kirim_cn);
    }
    
    return $id_crm_pos_order_discount;
  }
  
  function discount_order_delete_gradual($id_crm_pos_order){
    $this->global_models->update("crm_pos_order_discount", array("id_crm_pos_order" => $id_crm_pos_order, "bertingkat" => 2), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_discount;
  }
  
  function order_approve_discount($id_crm_pos_order_discount){
    $this->global_models->update("crm_pos_order_discount", array("id_crm_pos_order_discount" => $id_crm_pos_order_discount), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_discount;
  }
  
  function order_generate_discount($id_crm_pos_order){
    $this->discount_cashback_order_delete_gradual($id_crm_pos_order);
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_discount AS B WHERE B.id_crm_pos_discount = A.id_crm_pos_discount) AS title"
      . " FROM crm_pos_order_discount AS A"
      . " WHERE A.status NOT IN (3,5)"
      . " AND A.id_crm_pos_order = '{$id_crm_pos_order}'"
      . " ORDER BY A.sort ASC"
      . "");
      
    $total_belanja = $this->global_models->get_field("crm_pos_order_merchandise", "SUM(price)", array("status" => 1, "id_crm_pos_order" => $id_crm_pos_order));
    $total_addon = $this->global_models->get_field("crm_pos_order_merchandise_addon", "SUM(price)", array("status" => 1, "id_crm_pos_order" => $id_crm_pos_order));
    $total_merchandise_discount_temp = $this->global_models->get_query("SELECT SUM(A.potongan) AS potongan"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.status = 2"
      . " AND A.id_crm_pos_order_merchandise IN (SELECT B.id_crm_pos_order_merchandise FROM crm_pos_order_merchandise AS B WHERE B.id_crm_pos_order = '{$id_crm_pos_order}' AND B.status = 1)");
    $total_merchandise_discount = $total_merchandise_discount_temp[0]->potongan;
    
    $total_belanja = $belanja_akhir = $total_belanja + $total_addon - $total_merchandise_discount;
    foreach ($data AS $key => $dt){
      
      $cn = $this->global_models->get("crm_pos_order_discount_cashback", array("id_crm_pos_order_discount" => $dt->id_crm_pos_order_discount));
      
      $id_crm_pos_approval_settings = NULL;
      $potongan = 0;
      if($dt->type == 2){
        $nilai = $dt->nilai;
        
        $data_cn['nilai'] = $cn[0]->nilai;
        
        $nilai_dari = $belanja_akhir;
      }
      else{
        if($dt->bertingkat == 2){
          $nilai = $total_belanja * $dt->nilai/100;
          $nilai_dari = $total_belanja;
          
          $data_cn['nilai'] = $total_belanja * $cn[0]->nilai/100;
        }
        else{
          $nilai = $belanja_akhir * $dt->nilai/100;
          $data_cn['nilai'] = $belanja_akhir * $cn[0]->nilai/100;
          $nilai_dari = $belanja_akhir;
        }
      }
      
      if($dt->approve == 1){
        $id_crm_pos_approval_settings = $this->get_approve_settings($dt->id_crm_pos_discount, ($dt->nilai + $cn[0]->nilai), $dt->type, $nilai_dari);
        $status = 4;
      }
      else{
        $status = 2;
      }
      $data[$key]->potongan = $potongan = $nilai;
      $belanja_akhir = $belanja_akhir - $nilai;
      
      $dt->status = $status;
      $dt->potongan = $potongan;
      
      $this->global_models->update("crm_pos_order_discount", array("id_crm_pos_order_discount" => $dt->id_crm_pos_order_discount), array(
        "id_crm_pos_approval_settings"  => $id_crm_pos_approval_settings,
        "status"          => $status,
        "potongan"        => $potongan,
        "nilai_dari"      => $nilai_dari,
        "update_by_users" => $this->session->userdata("id"),
      ));
      $this->global_models->update("crm_pos_order_discount_cashback", array("id_crm_pos_order_discount_cashback" => $cn[0]->id_crm_pos_order_discount_cashback), array(
        "id_crm_pos_order"=> $dt->id_crm_pos_order,
        "nominal"         => $data_cn['nilai'],
        "nilai_dari"      => $nilai_dari,
        "update_by_users" => $this->session->userdata("id"),
      ));
    }
    return $data;
  }
  
  function order_delete_discount($id_crm_pos_order_discount){
    $this->global_models->update("crm_pos_order_discount", array("id_crm_pos_order_discount" => $id_crm_pos_order_discount), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order_discount;
  }
  
  function order_discount($id_crm_pos_order){
    $total = $this->global_models->get_field("crm_pos_order_discount", "SUM(potongan)", array("id_crm_pos_order" => $id_crm_pos_order, "status" => 2));
    return array("total" => $total);
  }
  
  function order_merchandise_discount($id_crm_pos_order){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS jml"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.id_crm_pos_order_merchandise IN (SELECT B.id_crm_pos_order_merchandise FROM crm_pos_order_merchandise AS B WHERE B.id_crm_pos_order = '{$id_crm_pos_order}')"
      . " AND A.status = 2");
    return array("total" => $total[0]->jml);
  }
  
  function discount_cashback_order_delete_gradual($id_crm_pos_order){
    $this->global_models->query("UPDATE crm_pos_order_discount_cashback"
      . " SET status = 2, update_by_users = '{$this->session->userdata("id")}'"
      . " WHERE id_crm_pos_order_discount IN ("
        . "SELECT B.id_crm_pos_order_discount"
        . " FROM crm_pos_order_discount AS B"
        . " WHERE B.id_crm_pos_order = '{$id_crm_pos_order}'"
        . " AND B.status = 3)");
    return true;
  }
  
  function discount_merchandise_cashback_order_delete_gradual($id_crm_pos_order_merchandise){
    $this->global_models->query("UPDATE crm_pos_order_merchandise_discount_cashback"
      . " SET status = 2, update_by_users = '{$this->session->userdata("id")}'"
      . " WHERE id_crm_pos_order_merchandise_discount IN ("
        . "SELECT B.id_crm_pos_order_merchandise_discount"
        . " FROM crm_pos_order_merchandise_discount AS B"
        . " WHERE B.id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'"
        . " AND B.status = 3)");
    return true;
  }
  
  function cashback_sum($id_crm_pos_order){
    $cn = $this->global_models->get_field("crm_pos_order_discount_cashback", "SUM(nominal)", array("id_crm_pos_order" => $id_crm_pos_order, "status" => 1));
    $cn_mer = $this->global_models->get_field("crm_pos_order_merchandise_discount_cashback", "SUM(nominal)", array("id_crm_pos_order" => $id_crm_pos_order, "status" => 1));
    return array("total" => $cn_mer);
  }
  
  function cashback_set($pst){
    $id_crm_cashback = $this->global_models->get_field("crm_cashback", "id_crm_cashback", array("name" => $pst['name'], "bank_number" => $pst['bank_number']));
    if(!$id_crm_cashback){
      $this->global_models->generate_id($id_crm_cashback, "crm_cashback");
      $kirim_cashback = array(
        "id_crm_cashback"         => $id_crm_cashback,
        "name"                    => $pst['name'],
        "bank_name"               => $pst['bank_name'],
        "bank_number"             => $pst['bank_number'],
        "bank"                    => $pst['bank'],
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_cashback", $kirim_cashback);
    }
    return array("id" => $id_crm_cashback);
  }
  
  function discount_company_list(){
    $data_company = $this->global_models->get_query("SELECT A.id_crm_pos_discount, A.title"
      . " FROM crm_pos_discount AS A"
      . " WHERE A.status = 1"
      . " AND A.is_company = 1"
      . " ORDER BY A.title DESC");
    foreach ($data_company AS $cs){
      $company[] = array(
        "id"    => $cs->id_crm_pos_discount,
        "text"  => $cs->title,
      );
      $company2[$cs->id_crm_pos_discount] = $cs->title;
    }
    $hasil['status'] = 2;
    $hasil['v1'] = $company2;
    $hasil['v2'] = $company;
    return $hasil;
  }
  
  function discount_company_clear($id_crm_pos_discount, $kirim_discount){
    if($kirim_discount){
      foreach ($kirim_discount AS $kd){
        $list .= $kd.",";
      }
      $list = "(".trim($list, ",").")";
      
      $this->global_models->query("DELETE FROM crm_pos_discount_company"
        . " WHERE id_crm_pos_discount = '{$id_crm_pos_discount}'"
        . " AND id_crm_customer_company IN {$list}");
    }
    return true;
  }
  
  function discount_company_set($id_crm_pos_discount, $kirim_discount){
    if($kirim_discount){
      foreach ($kirim_discount AS $key => $kd){
//      $this->global_models->generate_id($id_crm_pos_products_specification_data, "crm_pos_discount_company", $key);
        $kirim[] = array(
          "id_crm_pos_discount"     => $id_crm_pos_discount,
          "id_crm_customer_company" => $kd,
          "create_by_users"         => $this->session->userdata("id"),
          "create_date"             => date("Y-m-d H:i:s")
        );
        
      }
     
      if($kirim)
        $this->global_models->insert_batch("crm_pos_discount_company", $kirim);
    }
    $hasil['status'] = 2;
    $hasil['data']   = $kirim;
    return $hasil;
  }
  
}
?>
