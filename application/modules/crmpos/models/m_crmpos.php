<?php
class M_crmpos extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function products_merchandise_set($kirim_products){
    $this->global_models->generate_id($id_crm_pos_products_merchandise, "crm_pos_products_merchandise");
    $kirim_products['id_crm_pos_products_merchandise']  = $id_crm_pos_products_merchandise;
    if($kirim_products['id_crm_pos_location_dc']){
      $kirim_products['id_crm_pos_location']            = $this->global_models->get_field("crm_pos_location_dc", "id_crm_pos_location", array("id_crm_pos_location" => $kirim_products['id_crm_pos_location']));
    }
    $kirim_products['create_by_users']                  = $this->session->userdata("id");
    $kirim_products['create_date']                      = date("Y-m-d H:i:s");
    
    $this->global_models->insert("crm_pos_products_merchandise", $kirim_products);
      
    return $id_crm_pos_products_merchandise;
  }
  
  function products_update($kirim_products, $id_crm_pos_products){
    $kirim_products['update_by_users'] = $this->session->userdata("id");
    $this->global_models->update("crm_pos_products", array("id_crm_pos_products" => $id_crm_pos_products), $kirim_products);
    return $id_crm_pos_products;
  }
  
  function products_merchandise_update($kirim_products, $id_crm_pos_products_merchandise){
    $kirim_products['update_by_users'] = $this->session->userdata("id");
    if($kirim_products['id_crm_pos_location_dc']){
      $kirim_products['id_crm_pos_location']            = $this->global_models->get_field("crm_pos_location_dc", "id_crm_pos_location", array("id_crm_pos_location" => $kirim_products['id_crm_pos_location']));
    }
    $this->global_models->update("crm_pos_products_merchandise", array("id_crm_pos_products_merchandise" => $id_crm_pos_products_merchandise), $kirim_products);
    return $id_crm_pos_products_merchandise;
  }
  
  function products_specification_detail_update($kirim, $id){
    $kirim['update_by_users'] = $this->session->userdata("id");
    $this->global_models->update("crm_pos_products_specification_data", array("id_crm_pos_products_specification_data" => $id), $kirim);
    return $id;
  }
  
  function products_specification_detail_set($id_crm_pos_products_specification, $id_crm_pos_products){
    $data = $this->global_models->get("crm_pos_products_specification_details", array("id_crm_pos_products_specification" => $id_crm_pos_products_specification));
    $this->global_models->delete("crm_pos_products_specification_data", array("id_crm_pos_products" => $id_crm_pos_products));
    foreach($data AS $key => $dt){
      $this->global_models->generate_id($id_crm_pos_products_specification_data, "crm_pos_products_specification_data", $key);
      $kirim[] = array(
        "id_crm_pos_products_specification_data"      => $id_crm_pos_products_specification_data,
        "id_crm_pos_products_specification_details"   => $dt->id_crm_pos_products_specification_details,
        "id_crm_pos_products"                         => $id_crm_pos_products,
        "title"                                       => $dt->title,
        "type"                                        => $dt->type,
        "sort"                                        => $dt->sort,
        "code"                                        => $dt->code,
        "create_by_users"                             => $this->session->userdata("id"),
        "create_date"                                 => date("Y-m-d H:i:s")
      );
    }
    if($kirim)
      $this->global_models->insert_batch("crm_pos_products_specification_data", $kirim);
    
    return $id_crm_pos_products_specification;
  }
  
  function products_set($post){
    $this->global_models->generate_id($id_crm_pos_products, "crm_pos_products");
    $post['id_crm_pos_products']  = $id_crm_pos_products;
    $post['create_by_users']      = $this->session->userdata("id");
    $post['create_date']          = date("Y-m-d H:i:s");
    
    $this->global_models->insert("crm_pos_products", $post);
      
    return $id_crm_pos_products;
  }
  
  function quotation_set($pst, $id_crm_pos_products_categories){
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    if($pst['id_crm_pos_quotation']){
      $kirim = array(
        "id_crm_customer"                         => $pst['id_crm_customer'],
        "id_crm_customer_company"                 => $pst['id_crm_customer_company'],
        "title"                                   => $pst['title'],
        "print_note"                              => $truefalse[$pst['print_note']],
        "note"                                    => $pst['note'],
        "update_by_users"                         => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_pos_quotation", array("id_crm_pos_quotation" => $pst['id_crm_pos_quotation']), $kirim);
      $id_crm_pos_quotation = $pst['id_crm_pos_quotation'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_quotation, "crm_pos_quotation");
      $nomor = $this->global_models->generate_nomor_format('crm_pos_quotation', 'crm_pos_quotation', 'tanggal', date("Y-m-d"));
      $kirim = array(
        "id_crm_pos_quotation"                    => $id_crm_pos_quotation,
        "id_crm_customer"                         => $pst['id_crm_customer'],
        "id_crm_customer_company"                 => $pst['id_crm_customer_company'],
        "id_crm_agent"                            => $this->session->userdata("crm_agent"),
        "id_users"                                => $this->session->userdata("id"),
        "id_crm_pos_products_categories"          => $id_crm_pos_products_categories,
        "title"                                   => $pst['title'],
        "nomor"                                   => $nomor['nomor'],
        "urut"                                    => $nomor['urut'],
        "print_note"                              => $truefalse[$pst['print_note']],
        "note"                                    => $pst['note'],
        "tanggal"                                 => date("Y-m-d"),
        "status"                                  => 1,
        "create_by_users"                         => $this->session->userdata("id"),
        "create_date"                             => date("Y-m-d H:i:s")
      );
      $this->global_models->insert("crm_pos_quotation", $kirim);
    }
    return $id_crm_pos_quotation;
  }
  
  function quotation_revision($pst){
    $data = $this->global_models->get("crm_pos_quotation", array("id_crm_pos_quotation" => $pst['id_crm_pos_quotation']));
    
    $update = array(
      "status"                                  => 5,
      "note"                                    => $data[0]->note."<hr />".$pst['note'],
      "update_by_users"                         => $this->session->userdata("id")
    );
    $this->global_models->update("crm_pos_quotation", array("id_crm_pos_quotation" => $pst['id_crm_pos_quotation']), $update);
    
    $this->global_models->generate_id($id_crm_pos_quotation, "crm_pos_quotation");
    $kirim = array(
      "id_crm_pos_quotation"                    => $id_crm_pos_quotation,
      "id_rev_crm_pos_quotation"                => $pst['id_crm_pos_quotation'],
      "rev"                                     => ($data[0]->rev + 1),
      "id_crm_customer"                         => $data[0]->id_crm_customer,
      "id_crm_customer_company"                 => $data[0]->id_crm_customer_company,
      "id_crm_agent"                            => $this->session->userdata("crm_agent"),
      "id_users"                                => $this->session->userdata("id"),
      "id_crm_pos_products_categories"          => $data[0]->id_crm_pos_products_categories,
      "title"                                   => $data[0]->title,
      "nomor"                                   => $data[0]->nomor,
      "urut"                                    => $data[0]->urut,
      "print_note"                              => $data[0]->print_note,
      "note"                                    => $data[0]->note,
      "tanggal"                                 => date("Y-m-d"),
      "status"                                  => 1,
      "create_by_users"                         => $this->session->userdata("id"),
      "create_date"                             => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_quotation", $kirim);
    return $id_crm_pos_quotation;
  }
  
  function quotation_merchandise_set($post, $harga, $id_crm_pos_quotation_merchandise = NULL, $potongan = 0){
    if($id_crm_pos_quotation_merchandise){
      $this->global_models->query("UPDATE crm_pos_quotation_merchandise"
        . " SET update_by_users = '{$this->session->userdata("id")}',"
        . " qty = (qty + {$post['qty']}),"
        . " price = ({$harga} * (qty + {$post['qty']})),"
        . " potongan = ({$potongan} + potongan),"
        . " price_dasar = {$harga}"
        . " WHERE id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'");
    }
    else{
      $this->global_models->generate_id($id_crm_pos_quotation_merchandise, "crm_pos_quotation_merchandise");
      $post['id_crm_pos_quotation_merchandise']   = $id_crm_pos_quotation_merchandise;
      $post['price']                              = ($harga * $post['qty']);
      $post['price_dasar']                        = $harga;
      $post['create_by_users']                    = $this->session->userdata("id");
      $post['status']                             = 1;
      $post['create_date']                        = date("Y-m-d H:i:s");
      $this->global_models->insert("crm_pos_quotation_merchandise", $post);
    }
      
    return $id_crm_pos_quotation_merchandise;
  }
  
  function order_merchandise_set($post, $harga, $id_crm_pos_order_merchandise = NULL, $potongan = 0){
    if($id_crm_pos_order_merchandise){
      $this->global_models->query("UPDATE crm_pos_order_merchandise"
        . " SET update_by_users = '{$this->session->userdata("id")}',"
        . " qty = (qty + {$post['qty']}),"
        . " price = ({$harga} * (qty + {$post['qty']})),"
        . " potongan = ({$potongan} + potongan),"
        . " price_dasar = {$harga}"
        . " WHERE id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'");
    }
    else{
      $this->global_models->generate_id($id_crm_pos_order_merchandise, "crm_pos_order_merchandise");
      $post['id_crm_pos_order_merchandise']       = $id_crm_pos_order_merchandise;
      $post['price']                              = ($harga * $post['qty']);
      $post['price_dasar']                        = $harga;
      $post['create_by_users']                    = $this->session->userdata("id");
      $post['status']                             = 1;
      $post['create_date']                        = date("Y-m-d H:i:s");
      $this->global_models->insert("crm_pos_order_merchandise", $post);
    }
      
    return $id_crm_pos_order_merchandise;
  }
  
  function quotation_merchandise_delete($id_crm_pos_quotation_merchandise){
    $this->global_models->update("crm_pos_quotation_merchandise", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_quotation_merchandise;
  }
  
  function quotation_order($id_crm_pos_quotation){
    $quotation = $this->global_models->get("crm_pos_quotation", array("id_crm_pos_quotation" => $id_crm_pos_quotation));
    $this->global_models->generate_id($id_crm_pos_order, "crm_pos_order");
    $nomor = $this->global_models->generate_nomor_format('crm_pos_order', 'crm_pos_order', 'tanggal', date("Y-m-d"));
    
    $data_json = $this->nbscache->get("crm");
    $data_banding = json_decode($data_json);
    
    $kirim_order = array(
      "id_crm_pos_order"                      => $id_crm_pos_order,
      "id_crm_pos_quotation"                  => $id_crm_pos_quotation,
      "id_crm_customer"                       => $quotation[0]->id_crm_customer,
      "id_crm_agent"                          => $this->session->userdata("crm_agent"),
      "id_crm_customer_company"               => $quotation[0]->id_crm_customer_company,
      "id_users"                              => $this->session->userdata("id"),
      "id_crm_pos_products_categories"        => $data_banding->crmtrans_crm_pos_products_categories->id,
      "title"                                 => $quotation[0]->title,
      "tanggal"                               => date("Y-m-d H:i:s"),
      "nomor"                                 => $nomor['nomor'],
      "urut"                                  => $nomor['urut'],
      "status"                                => 1,
      "note"                                  => $quotation[0]->note,
      "print_note"                            => $quotation[0]->print_note,
      "create_by_users"                       => $this->session->userdata("id"),
      "create_date"                           => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_order", $kirim_order);
    $this->global_models->update("crm_pos_quotation", array("id_crm_pos_quotation" => $id_crm_pos_quotation), array("status" => 7, "update_by_users" => $this->session->userdata("id")));
    return $id_crm_pos_order;
  }
  
  function addon_merchandise_quotation_set($pst, $id_crm_pos_quotation_merchandise, $price = 0){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_quotation_merchandise AS A"
      . " WHERE A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . "");
    $mer = $this->global_models->get_query("SELECT B.harga"
      . " FROM crm_pos_products_merchandise AS B"
      . " WHERE B.id_crm_pos_products_merchandise = '{$pst['id_crm_pos_products_merchandise']}'");
      
//    $cek = $this->global_models->get("crm_pos_quotation_merchandise_addon", array("status" => 2 ,"id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise));
//    if($cek){
//      $id_crm_pos_quotation_merchandise_addon = $cek[0]->id_crm_pos_quotation_merchandise_addon;
//      $kirim = array(
//        "id_crm_pos_products_merchandise"             => $pst['id_crm_pos_products_merchandise'],
//        "id_crm_pos_quotation"                        => $data[0]->id_crm_pos_quotation,
//        "id_crm_pos_quotation_merchandise"            => $id_crm_pos_quotation_merchandise,
//        "tanggal"                                     => date("Y-m-d H:i:s"),
//        "price"                                       => $pst['qty'] * $mer[0]->harga,
//        "status"                                      => 1,
//        "qty"                                         => $pst['qty'],
//        "price_dasar"                                 => $mer[0]->harga,
//        "note"                                        => $pst['note'],
//        "update_by_users"                             => $this->session->userdata("id"),
//      );
//      $this->global_models->update("crm_pos_quotation_merchandise_addon", array("id_crm_pos_quotation_merchandise_addon" => $id_crm_pos_quotation_merchandise_addon), $kirim);
//    }
//    else{
    
      $this->global_models->generate_id($id_crm_pos_quotation_merchandise_addon, "crm_pos_quotation_merchandise_addon");
      $kirim = array(
        "id_crm_pos_quotation_merchandise_addon"      => $id_crm_pos_quotation_merchandise_addon,
        "id_crm_pos_products_merchandise"             => $pst['id_crm_pos_products_merchandise'],
        "id_crm_pos_quotation"                        => $data[0]->id_crm_pos_quotation,
        "id_crm_pos_quotation_merchandise"            => $id_crm_pos_quotation_merchandise,
        "tanggal"                                     => date("Y-m-d H:i:s"),
        "price"                                       => $pst['qty'] * ($price > 0 ? $price:$mer[0]->harga),
        "status"                                      => 1,
        "type"                                        => $pst['type'],
        "category"                                    => $pst['category'], 
        "qty"                                         => $pst['qty'],
        "price_dasar"                                 => ($price > 0 ? $price:$mer[0]->harga),
        "note"                                        => $pst['note'],
        "create_by_users"                             => $this->session->userdata("id"),
        "create_date"                                 => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("crm_pos_quotation_merchandise_addon", $kirim);
//    }
    return $id_crm_pos_quotation_merchandise_addon;
  }
  
  function addon_merchandise_quotation_delete($id){
    $this->global_models->update("crm_pos_quotation_merchandise_addon", array("id_crm_pos_quotation_merchandise_addon" => $id), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id;
  }
  
  function addon_merchandise_quotation_sum($id_crm_pos_quotation_merchandise){
    $total = $this->global_models->get_field("crm_pos_quotation_merchandise_addon", "SUM(price)", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise, "status" => 1));
    return $total;
  }
  
  function addon_merchandise_order_sum($id_crm_pos_order_merchandise){
    $total1 = $this->global_models->get_field("crm_pos_order_merchandise_addon", "SUM(price)", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise, "status" => 1, "category" => 1));
    $total2 = $this->global_models->get_field("crm_pos_order_merchandise_addon", "SUM(price)", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise, "status" => 1, "category" => 2));
    
    $total['additional'] = $total1;
    $total['direct_cost'] = $total2;
    return $total;
  }
  
  function quotation_merchandise_addon_get($id_crm_pos_quotation_merchandise){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.title FROM crm_pos_products_merchandise AS B WHERE B.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise) AS title"
      . " FROM crm_pos_quotation_merchandise_addon AS A"
      . " WHERE A.id_crm_pos_quotation_merchandise = '{$id_crm_pos_quotation_merchandise}'"
      . " AND status = 1");
    return $data;
  }
  
  function order_merchandise_addon_get($id_site_transport_order_merchandise){
   
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT C.title FROM crm_pos_products_merchandise AS C WHERE C.id_crm_pos_products_merchandise = A.id_crm_pos_products_merchandise) AS title"
      . " FROM crm_pos_order_merchandise_addon AS A"
      . " WHERE A.id_crm_pos_order_merchandise = '{$id_site_transport_order_merchandise}'"
      . " AND A.status = 1"
      . " ORDER BY A.tanggal DESC"
      . "");
      return $data;
  }   
  
  function quo_order_merchandise_addon($id_crm_pos_quotation_merchandise, $id_crm_pos_order_merchandise, $id_crm_pos_order){
    $data = $this->global_models->get("crm_pos_quotation_merchandise_addon", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise, "status" => 1));
//    print_r($data);die;
    foreach($data AS $key => $d){
      $this->global_models->generate_id($id_crm_pos_order_merchandise_addon, "crm_pos_order_merchandise_addon", $key);
      $kirim[] = array(
        "id_crm_pos_order_merchandise_addon"        => $id_crm_pos_order_merchandise_addon,
        "id_crm_pos_quotation_merchandise_addon"    => $d->id_crm_pos_quotation_merchandise_addon,
        "id_crm_pos_products_merchandise"           => $d->id_crm_pos_products_merchandise,
        "id_crm_pos_order"                          => $id_crm_pos_order,
        "id_crm_pos_order_merchandise"              => $id_crm_pos_order_merchandise,
        "tanggal"                                   => $d->tanggal,
        "price"                                     => $d->price,
        "status"                                    => 1,
        "qty"                                       => $d->qty,
        "category"                                  => $d->category,
        "type"                                      => $d->type,  
        "price_dasar"                               => $d->price_dasar,
        "note"                                      => $d->note,
        "create_by_users"                           => $this->session->userdata("id"),
        "create_date"                               => date("Y-m-d H:i:s")
      );
    }
    
    if($kirim){
      $this->global_models->insert_batch("crm_pos_order_merchandise_addon", $kirim);
    }
    return $id_crm_pos_order_merchandise_addon;
  }
  
  function quo_order_merchandise_discount($id_crm_pos_quotation_merchandise, $id_crm_pos_order_merchandise){
    $data = $this->global_models->get("crm_pos_quotation_merchandise_discount", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise, "status" => 2));
    foreach($data AS $key => $d){
      $this->global_models->generate_id($id_crm_pos_order_merchandise_discount, "crm_pos_order_merchandise_discount", $key);
      $kirim = array(
        "id_crm_pos_order_merchandise_discount"   => $id_crm_pos_order_merchandise_discount,
        "id_crm_pos_quotation_merchandise_discount" => $d->id_crm_pos_quotation_merchandise_discount,
        "id_crm_pos_discount"                     => $d->id_crm_pos_discount,
        "id_crm_pos_order_merchandise"            => $id_crm_pos_order_merchandise,
        "id_crm_pos_approval_settings"            => $d->id_crm_pos_approval_settings,
        "tanggal"                                 => $d->tanggal,
        "potongan"                                => $d->potongan,
        "qty"                                     => $d->qty,
        "nilai"                                   => $d->nilai,
        "nilai_dari"                              => $d->nilai_dari,
        "status"                                  => 2,
        "type"                                    => $d->type,
        "bertingkat"                              => $d->bertingkat,
        "sort"                                    => $d->sort,
        "approve"                                 => $d->approve,
        "note"                                    => $d->note,
        "create_by_users"                         => $this->session->userdata("id"),
        "create_date"                             => date("Y-m-d H:i:s")
      );
       $this->global_models->insert("crm_pos_order_merchandise_discount", $kirim);
      $get_hostory = $this->global_models->get("site_transport_quo_merchandise_discount_approve",array("id_crm_pos_quotation_merchandise_discount" =>"{$d->id_crm_pos_quotation_merchandise_discount}"));
    
        foreach($get_hostory AS $k => $dh){
            $this->global_models->generate_id($id_site_transport_order_merchandise_discount_approve, "site_transport_order_merchandise_discount_approve");
        
            $kirim_history = array(
              "id_site_transport_order_merchandise_discount_approve"=> $id_site_transport_order_merchandise_discount_approve,
              "id_crm_pos_order_merchandise_discount"               => $id_crm_pos_order_merchandise_discount,
              "id_users"                                            => $dh->id_users,
              "id_privilege"                                        => $dh->id_privilege,
              "nilai"                                               => $dh->nilai,
              "note"                                                => $dh->note,
              "create_by_users"                                     => $this->session->userdata("id"),
              "create_date"                                         => date("Y-m-d H:i:s")
            );
            $this->global_models->insert("site_transport_order_merchandise_discount_approve", $kirim_history);
        }
      }
    
//    if($kirim){
//      $this->global_models->insert_batch("crm_pos_order_merchandise_discount", $kirim);
//    }
    return $id_crm_pos_order_merchandise_discount;
  }
  
  function quotation_merchandise_normal($id_crm_pos_quotation){
    $this->global_models->update("crm_pos_quotation_merchandise", array("status" => 4, "id_crm_pos_quotation" => $id_crm_pos_quotation), array("status" => 1));
    return $id_crm_pos_quotation;
  }
  
  function quotation_normal($id_crm_pos_quotation){
    $this->global_models->update("crm_pos_quotation", array("id_crm_pos_quotation" => $id_crm_pos_quotation), array("status" => 1));
    return $id_crm_pos_quotation;
  }
  
  function quotation_cek_status($id_crm_pos_quotation){
    $status_quo = $this->global_models->get_field("crm_pos_quotation", "status", array("id_crm_pos_quotation" => $id_crm_pos_quotation));
    $merchandise = $this->global_models->get_field("crm_pos_quotation_merchandise", "status", array("id_crm_pos_quotation" => $id_crm_pos_quotation, "status" =>  4));
    $discount = $this->global_models->get_field("crm_pos_quotation_discount", "status", array("id_crm_pos_quotation" => $id_crm_pos_quotation, "status" =>  4));
    $cashback = $this->global_models->get_query("SELECT A.id_crm_pos_quotation_cashback"
      . " FROM crm_pos_quotation_cashback AS A"
      . " WHERE A.status IN (1,4)"
      . " AND A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'");
    if(($merchandise OR $discount OR $cashback[0]->id_crm_pos_quotation_cashback) AND !in_array($status_quo, array(2, 10, 5, 8))){
      return array("status" => 4, "quo" => $status_quo);
    }
    else{
      return array("status" => 1, "quo" => $status_quo);
    }
  }
  
  function quotation_merchandise_cek_status($id_crm_pos_quotation_merchandise){
    $status_quo = $this->global_models->get_field("crm_pos_quotation_merchandise", "status", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise));
    $discount = $this->global_models->get_field("crm_pos_quotation_merchandise_discount", "status", array("id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise, "status" =>  4));
    if($merchandise OR $discount AND !in_array($status_quo, array(2))){
      return array("status" => 4, "quo" => $status_quo);
    }
    else{
      return array("status" => 1, "quo" => $status_quo);
    }
  }
  
  function _order_not_customer(){
    return array(1);
  }
  
  function order_set($pst, $id_crm_pos_products_categories){
    $truefalse = array(
      "true"    => 1,
      "false"    => 2,
    );
    if($pst['id_crm_pos_order']){
      $kirim = array(
        "id_crm_customer"                         => $pst['id_crm_customer'],
        "id_crm_customer_company"                 => $pst['id_crm_customer_company'],
        "title"                                   => $pst['title'],
        "industry"                                => $pst['industry'],  
        "print_note"                              => $truefalse[$pst['print_note']],
        "note"                                    => $pst['note'],
        "update_by_users"                         => $this->session->userdata("id"),
      );
      $status_quo = $this->global_models->get_query("SELECT A.id_crm_pos_order_reference, A.id_crm_pos_quotation"
        . " FROM crm_pos_order AS A"
        . " WHERE A.id_crm_pos_order = '{$pst['id_crm_pos_order']}'");
      if($status_quo[0]->id_crm_pos_quotation OR $status_quo[0]->id_crm_pos_order_reference){
        unset($kirim['id_crm_customer']);
        unset($kirim['id_crm_customer_company']);
      }
      $this->global_models->update("crm_pos_order", array("id_crm_pos_order" => $pst['id_crm_pos_order']), $kirim);
      $id_crm_pos_order = $pst['id_crm_pos_order'];
    }
    else{
      $this->global_models->generate_id($id_crm_pos_order, "crm_pos_order");
      $nomor = $this->global_models->generate_nomor_format('crm_pos_order', 'crm_pos_order', 'tanggal', date("Y-m-d"));
      $kirim = array(
        "id_crm_pos_order"                        => $id_crm_pos_order,
        "id_crm_customer"                         => $pst['id_crm_customer'],
        "id_crm_customer_company"                 => $pst['id_crm_customer_company'],
        "id_crm_agent"                            => $this->session->userdata("crm_agent"),
        "id_users"                                => $this->session->userdata("id"),
        "id_crm_pos_products_categories"          => $id_crm_pos_products_categories,
        "title"                                   => $pst['title'],
        "industry"                                => $pst['industry'],  
        "nomor"                                   => $nomor['nomor'],
        "urut"                                    => $nomor['urut'],
        "print_note"                              => $truefalse[$pst['print_note']],
        "note"                                    => $pst['note'],
        "tanggal"                                 => date("Y-m-d"),
        "status"                                  => 14,
        "create_by_users"                         => $this->session->userdata("id"),
        "create_date"                             => date("Y-m-d H:i:s")
      );
//      print "<pre>";
//      print_r($pst);
//      print_r($kirim);
//      print "</pre>";
      $this->global_models->insert("crm_pos_order", $kirim);
    }
    return $id_crm_pos_order;
  }
  
  function order_revision($pst){
    $data = $this->global_models->get_query("SELECT A.*,B.id_crm_payment"
            . " ,(SELECT SUM(C.nominal) FROM crm_payment_kasir AS C WHERE C.id_crm_payment = B.id_crm_payment AND C.status=2) AS nominal_kasir"
            . " FROM crm_pos_order AS A "
            . " LEFT JOIN site_transport_order_payment AS B ON B.id_crm_pos_order = A.id_crm_pos_order"
            . " WHERE A.id_crm_pos_order='{$pst['id_crm_pos_order']}' ");
    
    $update = array(
      "status"                                  => 5,
      "note"                                    => $data[0]->note."<hr />".$pst['note'],
      "update_by_users"                         => $this->session->userdata("id")
    );
    $this->global_models->update("crm_pos_order", array("id_crm_pos_order" => $pst['id_crm_pos_order']), $update);
    
    $status = 14;
    
    $this->global_models->generate_id($id_crm_pos_order, "crm_pos_order");
    $kirim = array(
      "id_crm_pos_order"                        => $id_crm_pos_order,
      "id_crm_pos_order_reference"              => $data[0]->id_crm_pos_order_reference,
      "id_rev_crm_pos_order"                    => $pst['id_crm_pos_order'],
      "rev"                                     => ($data[0]->rev + 1),
      "industry"                                => $data[0]->industry,  
      "id_crm_customer"                         => $data[0]->id_crm_customer,
      "id_crm_customer_company"                 => $data[0]->id_crm_customer_company,
      "id_crm_agent"                            => $this->session->userdata("crm_agent"),
      "id_users"                                => $this->session->userdata("id"),
      "id_crm_pos_products_categories"          => $data[0]->id_crm_pos_products_categories,
      "title"                                   => $data[0]->title,
      "nomor"                                   => $data[0]->nomor,
      "urut"                                    => $data[0]->urut,
      "print_note"                              => $data[0]->print_note,
      "note"                                    => $data[0]->note,
      "tanggal"                                 => date("Y-m-d"),
      "id_crm_pos_quotation"                    => $data[0]->id_crm_pos_quotation,
      "price"                                   => $data[0]->price,
      "potongan"                                => $data[0]->potongan,
      "status"                                  => $status,
      "create_by_users"                         => $this->session->userdata("id"),
      "create_date"                             => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("crm_pos_order", $kirim);
    
    if($data[0]->id_crm_payment){
        if($data[0]->nominal_kasir > 0){
            $crm_payment = $data[0]->id_crm_payment;
        }else{
            $kirim_pay = array("status" => 10,
                        "note_cancel" => "Payment Cancel,Order Dengan Nomor {$data[0]->nomor} di Revisi ke {$kirim['rev']}",
                        "update_date"   => date("Y-m-d H:i:s"));
        $this->global_models->update("crm_payment",array("id_crm_payment" => "{$data[0]->id_crm_payment}"),$kirim_pay);
            $crm_payment = NULL;
        }
        
     $this->global_models->generate_id($id_site_transport_order_payment, "site_transport_order_payment");
    $pay = array(
      "id_site_transport_order_payment"     => $id_site_transport_order_payment,
      "id_crm_pos_order"                    => $id_crm_pos_order,
      "id_crm_payment"                      => $crm_payment,  
      "create_by_users"                     => $this->session->userdata("id"),
      "create_date"                         => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("site_transport_order_payment", $pay);    
    }
    
    return $id_crm_pos_order;
  }
  
  function order_merchandise_delete($id_crm_pos_order_merchandise){
    $this->global_models->update("crm_pos_order_merchandise", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    $this->global_models->update("crm_pos_order_merchandise_addon", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
   $this->global_models->update("crm_pos_order_merchandise_discount", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
    
    return $id_crm_pos_order_merchandise;
  }
  
  function order_classification_delete($id_crm_pos_order_merchandise){
    $this->global_models->update("site_transport_order_classification",array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise),array("status" => 10, "update_by_users" => $this->session->userdata("id")));  
    return $id_crm_pos_order_merchandise;
  }
  
  function addon_merchandise_order_set($pst, $id_crm_pos_order_merchandise, $price = 0){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_pos_order_merchandise AS A"
      . " WHERE A.id_crm_pos_order_merchandise = '{$id_crm_pos_order_merchandise}'"
      . "");
    $mer = $this->global_models->get_query("SELECT B.harga"
      . " FROM crm_pos_products_merchandise AS B"
      . " WHERE B.id_crm_pos_products_merchandise = '{$pst['id_crm_pos_products_merchandise']}'");
      
//    $cek = $this->global_models->get("crm_pos_quotation_merchandise_addon", array("status" => 2 ,"id_crm_pos_quotation_merchandise" => $id_crm_pos_quotation_merchandise));
//    if($cek){
//      $id_crm_pos_quotation_merchandise_addon = $cek[0]->id_crm_pos_quotation_merchandise_addon;
//      $kirim = array(
//        "id_crm_pos_products_merchandise"             => $pst['id_crm_pos_products_merchandise'],
//        "id_crm_pos_quotation"                        => $data[0]->id_crm_pos_quotation,
//        "id_crm_pos_quotation_merchandise"            => $id_crm_pos_quotation_merchandise,
//        "tanggal"                                     => date("Y-m-d H:i:s"),
//        "price"                                       => $pst['qty'] * $mer[0]->harga,
//        "status"                                      => 1,
//        "qty"                                         => $pst['qty'],
//        "price_dasar"                                 => $mer[0]->harga,
//        "note"                                        => $pst['note'],
//        "update_by_users"                             => $this->session->userdata("id"),
//      );
//      $this->global_models->update("crm_pos_quotation_merchandise_addon", array("id_crm_pos_quotation_merchandise_addon" => $id_crm_pos_quotation_merchandise_addon), $kirim);
//    }
//    else{
    
      $this->global_models->generate_id($id_crm_pos_order_merchandise_addon, "crm_pos_order_merchandise_addon");
      $kirim = array(
        "id_crm_pos_order_merchandise_addon"          => $id_crm_pos_order_merchandise_addon,
        "id_crm_pos_products_merchandise"             => $pst['id_crm_pos_products_merchandise'],
        "id_crm_pos_order"                            => $data[0]->id_crm_pos_order,
        "id_crm_pos_order_merchandise"                => $id_crm_pos_order_merchandise,
        "tanggal"                                     => date("Y-m-d H:i:s"),
        "price"                                       => $pst['qty'] * ($price > 0 ? $price:$mer[0]->harga),
        "status"                                      => 1,
        "qty"                                         => $pst['qty'],
        "category"                                    => $pst['category'],
        "type"                                        => $pst['type'],
        "price_dasar"                                 => ($price > 0 ? $price:$mer[0]->harga),
        "note"                                        => $pst['note'],
        "create_by_users"                             => $this->session->userdata("id"),
        "create_date"                                 => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("crm_pos_order_merchandise_addon", $kirim);
//    }
    return $id_crm_pos_order_merchandise_addon;
  }
  
  function addon_merchandise_order_delete($id){
    $this->global_models->update("crm_pos_order_merchandise_addon", array("id_crm_pos_order_merchandise_addon" => $id), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
    return $id;
  }
  
  function order_normal($id_crm_pos_order){
    $this->global_models->update("crm_pos_order", array("id_crm_pos_order" => $id_crm_pos_order), array("status" => 14));
    return $id_crm_pos_order;
  }
  
  function order_cek_status($id_crm_pos_order){
    $status_quo = $this->global_models->get_field("crm_pos_order", "status", array("id_crm_pos_order" => $id_crm_pos_order));
    $merchandise = $this->global_models->get_field("crm_pos_order_merchandise", "status", array("id_crm_pos_order" => $id_crm_pos_order, "status" =>  4));
    $discount = $this->global_models->get_field("crm_pos_order_discount", "status", array("id_crm_pos_order" => $id_crm_pos_order, "status" =>  4));
    
    $cashback = $this->global_models->get_query("SELECT A.id_crm_pos_order_cashback"
      . " FROM crm_pos_order_cashback AS A"
      . " WHERE A.status IN (1,4)"
      . " AND A.id_crm_pos_order = '{$id_crm_pos_order}'");
      
    if(($merchandise OR $discount OR $cashback[0]->id_crm_pos_order_cashback) AND !in_array($status_quo, array(2, 10, 5, 8, 13))){
      return array("status" => 4, "quo" => $status_quo);
    }
    else{
      return array("status" => 1, "quo" => $status_quo);
    }
  }
  
  function order_merchandise_cek_status($id_crm_pos_order_merchandise){
    $status_quo = $this->global_models->get_field("crm_pos_order_merchandise", "status", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise));
    $discount = $this->global_models->get_field("crm_pos_order_merchandise_discount", "status", array("id_crm_pos_order_merchandise" => $id_crm_pos_order_merchandise, "status" =>  4));
    if($merchandise OR $discount AND !in_array($status_quo, array(2))){
      return array("status" => 4, "quo" => $status_quo);
    }
    else{
      return array("status" => 1, "quo" => $status_quo);
    }
  }
  
  function order_merchandise_normal($id_crm_pos_order){
    $this->global_models->update("crm_pos_order_merchandise", array("status" => 4, "id_crm_pos_order" => $id_crm_pos_order), array("status" => 1));
    $data = $this->global_models->get_query("SELECT A.id_crm_pos_order_merchandise"
      . " FROM crm_pos_order_merchandise_discount AS A"
      . " WHERE A.id_crm_pos_order_merchandise IN (SELECT B.id_crm_pos_order_merchandise FROM crm_pos_order_merchandise AS B WHERE B.id_crm_pos_order = '{$id_crm_pos_order}')"
      . " AND A.status = 4");
    foreach($data AS $dt){
      $this->global_models->update("crm_pos_order_merchandise", array("status" => 4, "id_crm_pos_order_merchandise" => $dt->id_crm_pos_order_merchandise), array("status" => 4));
    }
    return $id_crm_pos_order;
  }
  
  function order_spj_count($id_crm_pos_order, $discount, $cashback, $status_class = 1){
    $order = $this->order_merchandise_get($id_crm_pos_order);
    $all = $order['order'] + $order['addon'] - $order['discount'];
    $sisa = $discount;
    $sisa_cn = $cashback;
    $order['vehicle'] = array();
    foreach($order['merchandise'] AS $key => $mer){
      if($key == (count($order['merchandise']) - 1)){
        $discount_mer = $sisa;
        $cashback_mer = $sisa_cn;
      }
      else{
        $total_mer = $mer['merchandise'] + $mer['addon'] - $mer['discount'];
        $discount_mer = round(round($total_mer/$all * $discount) / 1000) * 1000;
        $cashback_mer = round(round($total_mer/$all * $cashback) / 1000) * 1000;
        $sisa = $sisa - $discount_mer;
        $sisa_cn = $sisa_cn - $cashback_mer;
      }
      $order['merchandise'][$key]['discount_order'] = $discount_mer;
      $order['merchandise'][$key]['cashback_order'] = $cashback_mer;
      $where_status = "";
			if($status != 0){
				$where_status = " AND A.status = '{$status_class}'";
			}
      $vehicle = $this->global_models->get_query("SELECT A.*
			 FROM site_transport_order_classification AS A
			 WHERE A.id_crm_pos_order_merchandise = '{$mer['id_crm_pos_order_merchandise']}'
				 {$where_status}");
      $sisa_mer = array(
        "merchandise"       => $mer['merchandise'],
        "addon"             => $mer['addon'],
        "direct_cost"       => $mer['direct_cost'],
        "discount"          => $mer['discount'] + $discount_mer,
        "cashback"          => $cashback_mer
      );
      foreach ($vehicle AS $tf => $ve){
        if($tf == ($mer['qty'] - 1)){
          $set_mer = $sisa_mer['merchandise'];
          $set_add = $sisa_mer['addon'];
          $set_direct_cost = $sisa_mer['direct_cost'];
          $set_disc = $sisa_mer['discount'];
          $set_cashback = $sisa_mer['cashback'];
        }
        else{
          $set_mer = round(round($mer['merchandise']/$mer['qty']) / 1000) * 1000;
          $sisa_mer['merchandise'] = $sisa_mer['merchandise'] - $set_mer;
          
          $set_add = round(round($mer['addon']/$mer['qty']) / 1000) * 1000;
          $sisa_mer['addon'] = $sisa_mer['addon'] - $set_add;
          
          $set_direct_cost = round(round($mer['direct_cost']/$mer['qty']) / 1000) * 1000;
          $sisa_mer['direct_cost'] = $sisa_mer['direct_cost'] - $set_direct_cost;
          
          $set_disc = round(round(($mer['discount'] + $discount_mer)/$mer['qty']) / 1000) * 1000;
          $sisa_mer['discount'] = $sisa_mer['discount'] - $set_disc;
          
          $set_cashback = round(round(($mer['cashback'] + $cashback_mer)/$mer['qty']) / 1000) * 1000;
          $sisa_mer['cashback'] = $sisa_mer['cashback'] - $set_cashback;
          
        }
        $order['vehicle'][] = array(
          "merchandise"                             => $set_mer,
          "addon"                                   => $set_add,
          "direct_cost"                             => $set_direct_cost,
          "discount"                                => $set_disc,
          "cashback"                                => $set_cashback,
          "id_site_transport_order_classification"  => $ve->id_site_transport_order_classification,
          "startdate"                               => $ve->tanggal,
        );
      }
    }
    $order['discount_order'] = $discount;
    $order['cashback_order'] = $cashback;
    return $order;
  }
  
  function order_merchandise_get($id_crm_pos_order){
    $data = $this->global_models->get("site_transport_order_merchandise", array("id_crm_pos_order" => $id_crm_pos_order, "status" => 1));
    $total_merchandise = $total_addon = $total_addon2 = $total_discount = 0;
    foreach($data AS $dt){
      $addon = $this->addon_merchandise_order_sum($dt->id_crm_pos_order_merchandise);
      $discount = $this->global_models->get_field("crm_pos_order_merchandise_discount", "SUM(potongan)", array("id_crm_pos_order_merchandise" => $dt->id_crm_pos_order_merchandise, "status" => 2));
      $kirim[] = array(
        "merchandise"                   => $dt->price,
        "qty"                           => $dt->qty,
        "id_crm_pos_order_merchandise"  => $dt->id_crm_pos_order_merchandise,
        "id_site_transport_order_merchandise"  => $dt->id_site_transport_order_merchandise,
        "id_crm_pos_order"              => $dt->id_crm_pos_order,
        "addon"                         => $addon['additional'],
        "direct_cost"                   => $addon['direct_cost'],
        "discount"                      => $discount,
      );
      $total_merchandise += $dt->price;
      $total_addon += $addon['additional'];
      $total_addon2 += $addon['direct_cost'];
      $total_discount += $discount;
    }
    return array("merchandise" => $kirim, "order" => $total_merchandise, "addon" => $total_addon, "direct_cost" => $total_addon2, "discount" => $total_discount);
  }
  
  function order_merchandise_sum($id_crm_pos_order){
      $total_belanja = $this->global_models->get_query("SELECT SUM(price) AS total FROM crm_pos_order_merchandise AS A"
              . " WHERE A.status IN(1,4) AND A.id_crm_pos_order ='{$id_crm_pos_order}' ");
//    $total_belanja = $this->global_models->get_field("crm_pos_order_merchandise", "SUM(price)", array("status IN" => "(1,4)", "id_crm_pos_order" => $id_crm_pos_order));
    return array("total" => $total_belanja[0]->total,
                "db"    => $this->db->last_query());
  }
  
  function order_addon_merchandise_sum($id_crm_pos_order){
    $total_addon = $this->global_models->get_field("crm_pos_order_merchandise_addon", "SUM(price)", array("status" => 1, "id_crm_pos_order" => $id_crm_pos_order));
    return array("total" => $total_addon);
  }
  
  function quotation_merchandise_sum($id_crm_pos_quotation){
//    $total_belanja = $this->global_models->get_field("crm_pos_quotation_merchandise", "SUM(price)", array("status" => 1, "id_crm_pos_quotation" => $id_crm_pos_quotation));
    $total_belanja = $this->global_models->get_query("SELECT SUM(price) AS total FROM crm_pos_quotation_merchandise AS A "
            . " WHERE A.status IN(1,4) AND A.id_crm_pos_quotation ='{$id_crm_pos_quotation}' ");
    return array("total" => $total_belanja[0]->total);
  }
  
  function quotation_merchandise_addon_sum($id_crm_pos_quotation){
    $total_belanja = $this->global_models->get_field("crm_pos_quotation_merchandise_addon", "SUM(price)", array("id_crm_pos_quotation" => $id_crm_pos_quotation, "status" => 1));
    return array("total" => $total_belanja);
  }
  
  function quotation_merchandise_discount_sum($id_crm_pos_quotation){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS price"
      . " FROM crm_pos_quotation_merchandise_discount AS A"
      . " WHERE A.id_crm_pos_quotation_merchandise IN (SELECT B.id_crm_pos_quotation_merchandise FROM crm_pos_quotation_merchandise AS B WHERE B.id_crm_pos_quotation = '{$id_crm_pos_quotation}' AND B.status IN (1,4))"
      . " AND A.status IN (2,4)");
      
//      $dt = $this->global_models->get_query("SELECT A.id_crm_pos_quotation_merchandise "
//              . " FROM crm_pos_quotation_merchandise AS A "
//              . " WHERE A.status IN(1,4) AND A.id_crm_pos_quotation='{$id_crm_pos_quotation}'");
//
//      $dt_total = 0;
//      foreach ($dt as $key => $val) {
//          $total = $this->global_models->get_query("SELECT A.potongan AS price"
//                  . " FROM crm_pos_quotation_merchandise_discount AS A"
//                  . " WHERE A.status IN(2,4) AND A.id_crm_pos_quotation_merchandise='{$val->id_crm_pos_quotation_merchandise}'"
//                  . "");
//            if($total[0]->price){
//                $hasil = $total[0]->price;
//            }else{
//                $hasil = 0;
//            }      
// 
//          $dt_total = $dt_total + $hasil;
//      }
    return array("total" => $total[0]->price);
  }
  
  function quotation_discount_sum($id_crm_pos_quotation){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS price"
      . " FROM crm_pos_quotation_discount AS A"
      . " WHERE A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'"
      . " AND A.status IN (2,4)");
    return array("total" => $total[0]->price);
  }
  
  function quotation_cashback_sum($id_crm_pos_quotation){
    $total = $this->global_models->get_query("SELECT A.nominal"
      . " FROM crm_pos_quotation_cashback AS A"
      . " WHERE A.id_crm_pos_quotation = '{$id_crm_pos_quotation}'"
      . " AND A.status IN (2,4)"
      . " ORDER BY A.update_date DESC LIMIT 0,1");
    return array("total" => $total[0]->nominal);
  }
  
  function order_merchandise_addon_sum($id_crm_pos_order){
    $total = $this->global_models->get_field("crm_pos_order_merchandise_addon", "SUM(price)", array("id_crm_pos_order" => $id_crm_pos_order, "status" => 1));
    return array("total" => $total);
  }
  
  function order_merchandise_discount_sum($id_crm_pos_order){
//    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS price"
//      . " FROM crm_pos_order_merchandise_discount AS A"
//      . " WHERE A.id_crm_pos_order_merchandise IN (SELECT B.id_crm_pos_order_merchandise FROM crm_pos_order_merchandise AS B WHERE B.id_crm_pos_order = '{$id_crm_pos_order}' AND B.status IN(1,4))"
//      . " AND A.status IN (2,4)");
      $dt = $this->global_models->get_query("SELECT A.id_crm_pos_order_merchandise "
              . " FROM crm_pos_order_merchandise AS A "
              . " WHERE A.status IN(1,4) AND id_crm_pos_order='{$id_crm_pos_order}'");

      $dt_total = 0;
      foreach ($dt as $key => $val) {
          $total = $this->global_models->get_query("SELECT A.potongan AS price"
                  . " FROM crm_pos_order_merchandise_discount AS A"
                  . " WHERE A.status IN(2,4) AND A.id_crm_pos_order_merchandise='{$val->id_crm_pos_order_merchandise}'"
                  . "");
            if($total[0]->price){
                $hasil = $total[0]->price;
            }else{
                $hasil = 0;
            }      
 
          $dt_total = $dt_total + $hasil;
      }
    return array("total" => $dt_total
                );
  }
  
  function order_discount_sum($id_crm_pos_order){
    $total = $this->global_models->get_query("SELECT SUM(A.potongan) AS price"
      . " FROM crm_pos_order_discount AS A"
      . " WHERE A.id_crm_pos_order = '{$id_crm_pos_order}'"
      . " AND A.status IN (2,4)");
    return array("total" => $total[0]->price);
  }
  
  function order_cashback_sum($id_crm_pos_order){
    $total = $this->global_models->get_query("SELECT A.nominal"
      . " FROM crm_pos_order_cashback AS A"
      . " WHERE A.id_crm_pos_order = '{$id_crm_pos_order}'"
      . " AND A.status IN (2,4)"
      . " ORDER BY A.update_date DESC LIMIT 0,1");
    return array("total" => $total[0]->nominal);
  }
  
  function request_set($pst){
    $nomor = $this->global_models->generate_nomor_format('crm_pos_request', 'crm_pos_request', 'tanggal', date("Y-m-d H:i:s"));
    $this->global_models->generate_id($id_crm_pos_request, "crm_pos_request");
    $kirim = array(
      "id_crm_pos_request"      => $id_crm_pos_request,
      "id_crm_customer"         => $pst['id_crm_customer'],
      "id_crm_customer_company" => $pst['id_crm_customer_company'],
      "id_users"                => $this->session->userdata("id"),
      "title"                   => $pst['title'],
      "tanggal"                 => $pst['tanggal'],
      "nomor"                   => $nomor['nomor'],
      "urut"                    => $nomor['urut'],
      "status"                  => 1,
      "note"                    => $pst['note'],
      "create_by_users"         => $this->session->userdata("id"),
      "create_date"             => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("crm_pos_request", $kirim);
    $hasil = array(
      "status"      => 2,
      "data"        => array(
        "id"          => $id_crm_pos_request,
        "nomor"       => $kirim['nomor']
      ),
      "id"          => $id_crm_pos_request
    );
    return $hasil;
  }
  
  function request_update($kirim, $id_crm_pos_request){
    $kirim["update_by_users"] = $this->session->userdata("id");
    $this->global_models->update("crm_pos_request", array("id_crm_pos_request" => $id_crm_pos_request), $kirim);
    $hasil = array(
      "status"      => 2,
      "data"        => array(
        "id"          => $id_crm_pos_request,
      ),
      "id"          => $id_crm_pos_request
    );
    return $hasil;
  }
  
  function transport_spj_delete($kirim){
    $this->global_models->update("site_transport_spj",array("id_site_transport_spj" => $kirim['id_site_transport_spj']),array("status" => 7, "update_by_users" => $this->session->userdata("id"),"note" => "{$kirim['note']}"));  
    return $id_site_transport_spj;
  }
  
  function transport_order_payment_spj_delete($kirim){
    $this->global_models->update("site_transport_order_payment_spj",array("id_site_transport_order_payment_spj" => "{$kirim['id_site_transport_order_payment_spj']}"),array("status" => 4, "update_by_users" => $this->session->userdata("id"),"note" => "{$kirim['note']}"));  
    return $id_site_transport_spj;
  }
  
  function file_products_set($pst){
    $this->global_models->generate_id($id_crm_pos_products_file, "crm_pos_products_file");
    $kirim = array(
      "id_crm_pos_products_file"      => $id_crm_pos_products_file,
      "id_crm_pos_products"           => $pst['id_crm_pos_products'],
      "tanggal"                       => date("Y-m-d H:i:s"),
      "title"                         => $pst['title'],
      "note"                          => $pst['note'],
      "create_by_users"               => $this->session->userdata("id"),
      "create_date"                   => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("crm_pos_products_file", $kirim);
    $return = array(
      "status"    => 2,
      "data"      => array(
        "id"        => $id_crm_pos_products_file
      )
    );
    return $return;
  }
  
  function request_merchandise_set($kirim, $id_crm_pos_request){
    foreach ($kirim AS $key => $krm){
      $this->global_models->generate_id($id_crm_pos_request_merchandise, "crm_pos_request_merchandise", $key);
      $pst[] = array(
        "id_crm_pos_request_merchandise"  => $id_crm_pos_request_merchandise,
        "id_crm_pos_products_merchandise" => $krm['id_crm_pos_products_merchandise'],
        "id_crm_pos_request"              => $id_crm_pos_request,
        "tanggal"                         => $krm['tanggal'],
        "price"                           => $krm['price'],
        "potongan"                        => $krm['potongan'],
        "status"                          => 1,
        "qty"                             => $krm['qty'],
        "price_dasar"                     => $krm['price_dasar'],
        "note"                            => $krm['note'],
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s")
      );
      $id[] = $id_crm_pos_request_merchandise;
    }
    if($pst){
      $this->global_models->insert_batch("crm_pos_request_merchandise", $pst);
      $return = array(
        "status"      => 2,
        "data"        => array(
          "id"          => $id
        )
      );
    }
    else{
      $return = array(
        "status"      => 3,
        "note"        => ""
      );
    }
    return $return;
  }
  
}
?>
