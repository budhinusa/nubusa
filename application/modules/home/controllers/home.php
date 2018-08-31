<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {
    
  function __construct() {      
    
//    $this->debug($this->menu, true);
  }
  
  function komisi_free(){
    $data = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT IF(B.frequency IS NULL, 0, B.frequency) FROM site_transport_spj AS B WHERE B.id_site_transport_spj = A.id_site_transport_spj) AS frequency"
      . " FROM site_transport_spj_partner AS A"
      . " WHERE A.nominal = 150000 OR A.nominal = 75000");
//    $this->debug($data, true);
    foreach ($data AS $dt){
      $this->global_models->update("site_transport_spj_partner", array("id_site_transport_spj_partner" => $dt->id_site_transport_spj_partner), array("nominal" => ($dt->nominal * $dt->frequency), "type" => 2));
    }
    $this->debug($this->global_models->get_query("SELECT A.*"
      . " ,(SELECT IF(B.frequency IS NULL, 0, B.frequency) FROM site_transport_spj AS B WHERE B.id_site_transport_spj = A.id_site_transport_spj) AS frequency"
      . " FROM site_transport_spj_partner AS A"
      . " WHERE A.type = 2"), true);
    die;
  }
  
  function komisi_bill(){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj_partner AS A"
      . " WHERE A.type = 2");
    foreach ($data AS $dt){
      $this->global_models->update("crm_payment_bill_out", array("id_crm_payment_bill_out" => $dt->id_crm_payment_bill_out), array("nominal_payment" => $dt->nominal));
      $this->debug(array(array("id_crm_payment_bill_out" => $dt->id_crm_payment_bill_out), array("nominal_payment" => $dt->nominal)));
    }
    die;
  }
  
  function komisi_journal(){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj_partner AS A"
      . " WHERE A.type = 2 AND A.nominal NOT IN (150000, 75000)");
    $this->debug($data, true);
  }
  
  function post_cogs($id_site_transport_spj){
    $this->load->model("crmpayment/m_crmpayment");
    $this->load->model("crmtrans/m_crmtrans");
  //      post
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj_cogs AS A"
      . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}'"
      . " AND A.status = 3");
    $spj = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT B.id_scm_outlet_storage FROM site_transport_products_classification AS B WHERE B.id_site_transport_products_classification = A.id_site_transport_products_classification) AS id_id_scm_outlet_storage"
      . " ,(SELECT C.endkm FROM site_transport_spj_close AS C WHERE C.id_site_transport_spj = A.id_site_transport_spj) AS endkm_close"
      . " FROM site_transport_spj AS A"
      . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}'"
      . "");
      
    $spj_order_payment = $this->global_models->get_query("SELECT A.*"
      . " ,(SELECT CONCAT(C.title,'|',C.acc_id)"
        . " FROM site_transport_order_classification AS B"
        . " LEFT JOIN site_transport_products_categories AS C ON C.id_site_transport_products_categories = B.id_site_transport_products_categories"
        . " WHERE B.id_site_transport_order_classification = A.id_site_transport_order_classification) AS kategori"
        . " ,(SELECT B.title FROM crm_customer_company AS B WHERE B.id_crm_customer_company = A.id_crm_customer_company) AS company"
      . " FROM site_transport_order_payment_spj AS A WHERE A.id_site_transport_spj ='{$id_site_transport_spj}' "
       );
//      $this->debug(array($data, $spj, $spj_order_payment));
    if((
        (in_array($spj[0]->type, array(3,1,0)) OR !$spj[0]->type)
//        AND $spj[0]->id_site_transport_products_merchandise
      ) OR $spj[0]->type == 2){
        $data_json = $this->nbscache->get("crmtrans_account");
        $data_banding = json_decode($data_json);

        $kategori = explode("|",$spj_order_payment[0]->kategori);   

        foreach ($data_banding->company_grouping AS $cg){
          if(in_array($spj_order_payment[0]->id_crm_customer_company, $cg->company)){
            $acc_ar = $cg->acc_id;
            $acc_title = $cg->title;
            break;
          }
        }
   
    // Sale Kendaraan
        if($spj_order_payment){
          $debit[] = array(
            "acc_id"  => $acc_ar,
            "nilai"   => (($spj_order_payment[0]->price_sales + $spj_order_payment[0]->price_add) - $spj_order_payment[0]->discount),
            "note"    => "Account A/R Group Company ".$acc_title." Company:".$spj_order_payment[0]->company,
          );
          $credit[] = array(
            "acc_id"  => $kategori[1],
            "nilai"   => (($spj_order_payment[0]->price_sales + $spj_order_payment[0]->price_add) - $spj_order_payment[0]->discount),
            "note"    => "Sales Account Categories ".$kategori[0]
          );
          
          if($spj_order_payment[0]->cashback){
  //   CN
            $debit[] = array(
              "acc_id"  => $kategori[3],
              "nilai"   => ($spj_order_payment[0]->cashback),
              "note"    => "Sales Discount Account Categories ".$kategori[0]
            );
            $credit[] = array(
              "acc_id"  => $data_banding->account_default->site_transport_ap_cashback_acc_id,
              "nilai"   => ($spj_order_payment[0]->cashback),
              "note"    => "Acc A/P CN"
            );

            $kirim_bill = array(
              "nominal_payment"     => $spj_order_payment[0]->cashback,
              "start_date"          => date("Y-m-d H:i:s"),
              "end_date"            => date("Y-m-d H:i:s"),
              "source_id"           => $spj_order_payment[0]->id_site_transport_order_payment_spj,
              "source_table"        => "site_transport_order_payment_spj",
              "remark"              => "",
              "status"              => 2,
              "note"                => "SPJ COGS - {$spj[0]->nomor}",  
              "fungsi"              => $data_banding->account_default->crmtrans_alter_cashier_out_claim,
            );
            $bill = $this->m_crmpayment->pembayaran_bill_set($kirim_bill);
          }
        }
//    if($spj_order_payment[0]->discount){
//        //Discount
//        $debit[] = array(
//        "acc_id"  => $kategori[3],
//        "nilai"   => $spj_order_payment[0]->discount,
//        "note"    => "Sales Discount Account Categories ".$kategori[0]
//      );
//    $credit[] = array(
//        "acc_id"  => $kategori[1],
//        "nilai"   => $spj_order_payment[0]->discount,
//        "note"    => "Sales Account Categories ".$kategori[0]
//      );
//    }
    
   
        $bs = $this->global_models->get("site_transport_partner_bs", array("id_site_transport_spj" => $pst['id_site_transport_spj']));
//    return array($debit, $credit, $data);
        if($spj[0]->status == 5){
//          $this->global_models->trans_begin();
          foreach ($data AS $dt){
  //      buat penyelesaiaan bs (site_transport_partner_bs_closing)
  //      jika bs done
  //      jika ambil dari asset
  //      jika bayar
            if(in_array($dt->type, array(1,3))){
              if($dt->is_bs == 1){
                $kirim_api = array(
                  "tanggal"       => date("Y-m-d H:i:s"),
                  "nilai"         => $dt->qty * $dt->nominal,
      //          "file"          => $pst['file'],
                  "id_hrm_bs"     => $bs[0]->id_hrm_bs,
                  "status"        => 2,
                );

                $hrm_bs_closing = $this->api_hrm->bs_closing_set($kirim_api);
                $this->global_models->generate_id($id_site_transport_partner_bs_closing, "site_transport_partner_bs_closing");

                $data_account_json = $this->nbscache->get("crmtrans_account");
                $data_account_banding = json_decode($data_account_json);
                $credit_bs = $data_account_banding->account_default->site_transport_partners_bs_acc_id;

                $kirim = array(
                  "id_site_transport_partner_bs_closing"  => $id_site_transport_partner_bs_closing,
                  "id_site_transport_partner_bs"          => $bs[0]->id_site_transport_partner_bs,
                  "id_hrm_bs_closing"                     => $hrm_bs_closing['id_hrm_bs_closing'],
                  "id_site_transport_spj_cogs"            => $dt->id_site_transport_spj_cogs,
                  "debit"                                 => $dt->credit,
                  "credit"                                => $credit_bs,
                  "type_cogs"                             => $dt->cogs,
                  "type"                                  => 2,
                  "status"                                => 2,
                  "note"                                  => $dt->note,
                  "create_by_users"                       => $this->session->userdata("id"),
                  "create_date"                           => date("Y-m-d H:i:s")
                );
                $this->global_models->insert("site_transport_partner_bs_closing", $kirim);

                $note_acc_debit  = "COGS ".$dt->title;
                $note_acc_kredit = "ACC BS";
              }
              else{

                if($dt->is_asset == 1){
  //            commit log out

  //      pas posting cogs
  //            cek qty
                  $this->load->model("scmtrans/m_scmtrans");
                  $kirim_po_fuel_deposit = array(
                    "id_site_transport_products_classification" => $spj[0]->id_site_transport_products_classification,
                    "note"                                      => "",
                    "qty"                                       => $dt->qty,
                    "nominal"                                   => $dt->nominal,
                    "id_site_transport_spj"                     => $dt->id_site_transport_spj,
                  );
                  $po_fuel_deposit = $this->m_scmtrans->fuel_deposit_procurement_set($kirim_po_fuel_deposit);

                  $kirim_po_fuel_deposit_confirm = array(
                    "id_site_transport_fuel_deposit"  => $po_fuel_deposit['id']
                  );
                  $po_fuel_deposit_confirm = $this->m_scmtrans->fuel_deposit_procurement_confirm($kirim_po_fuel_deposit_confirm);

  //      deposit out
                  $kirim_po_fuel_deposit_out = array(
                    "id_site_transport_products_classification" => $spj[0]->id_site_transport_products_classification,
                    "id_scm_outlet_storage"                     => $spj[0]->id_scm_outlet_storage,
                    "id_site_transport_spj"                     => $pst['id_site_transport_spj'],
                    "km"                                        => ($spj[0]->endkm_close - $spj[0]->startkm),
                    "nominal"                                   => $dt->qty,
                    "harga"                                     => $dt->nominal,
                    "type"                                      => 2,
                    "tanggal"                                   => date("Y-m-d H:i:s"),
                    "status"                                    => 3,
                    "note"                                      => $dt->note,
                  );
                  $po_fuel_deposit_out = $this->m_scmtrans->fuel_deposit_set($kirim_po_fuel_deposit_out);
  //      storage out
                  $fuel_deposit = $this->global_models->get_query("SELECT A.*"
                    . " ,(SELECT B.id_scm_inventory_category FROM scm_inventory AS B WHERE B.id_scm_inventory = A.id_scm_inventory) AS id_scm_inventory_category"
                    . " FROM scm_outlet_storage_inventory_log AS A"
                    . " WHERE A.id_scm_outlet_storage_inventory_log = '{$po_fuel_deposit_confirm['id_scm_outlet_storage_inventory_log']}'");
                  $this->load->model("scmoutlet/m_scmoutlet");
                  $kirim_log_out = array(
                    "id_scm_outlet_storage_inventory_log"     => $po_fuel_deposit_confirm['id_scm_outlet_storage_inventory_log'],
                    "id_scm_inventory"                        => $fuel_deposit[0]->id_scm_inventory,
                    "source_id"                               => $dt->id_site_transport_spj_cogs,
                    "source_table"                            => "site_transport_spj_cogs",
                    "id_scm_satuan"                           => $fuel_deposit[0]->id_scm_satuan,
                    "qty"                                     => $fuel_deposit[0]->qty,
                    "nominal"                                 => $fuel_deposit[0]->nominal,
                  );
                  $this->m_scmoutlet->scm_outlet_storage_inventory_log_out_set($kirim_log_out);
                  $note_acc_kredit = $dt->title;
                }
                else{
                  $this->global_models->update("site_transport_spj_cogs", array("id_site_transport_spj_cogs" => $dt->id_site_transport_spj_cogs), array("id_crm_payment_bill_out" => $pembayaran_bill_tambahan['id'], "update_by_users" => $this->session->userdata("id")));

                  if($dt->is_bs > 0){  
                    $fungsi_out = ($dt->type == 1? "crmtrans|m_crmtrans|alter_crm_payment_kasir_out_direct_cost": "crmtrans|m_crmtrans|alter_crm_payment_kasir_out_tambahan");
                    $kirim_bill = array(
                      "nominal_payment"               => $dt->qty * $dt->nominal,
                      "start_date"                    => date("Y-m-d H:i:s"),
                      "end_date"                      => date("Y-m-d H:i:s"),
                      "remark"                        => "SPJ COGS ".$spj[0]->nomor,
                      "status"                        => 2,
                      "source_id"                     => $dt->id_site_transport_spj_cogs,
                      "source_table"                  => "site_transport_spj_cogs",
                      "fungsi"                        => $fungsi_out,
                      "note"                          => $dt->note,
                    );
                    $pembayaran_bill_tambahan = $this->m_crmpayment->pembayaran_bill_set($kirim_bill);
                  }
                  $note_acc_kredit = "A/P COGS ".$dt->title;
                }
      // buat bill out

                $note_acc_debit  = "COGS ".$dt->title;
              }
            }
            else{
              $note_acc_debit  = "COGS ".$dt->title;
              $note_acc_kredit = "A/P COGS ".$dt->title;
            }

            $debit[] = array(
              "acc_id"  => $dt->debit,
              "nilai"   => $dt->qty * $dt->nominal,
              "note"    => $note_acc_debit
            );
  //      $this->debug($dt);
            $credit[] = array(
              "acc_id"  => $dt->credit,
              "nilai"   => $dt->qty * $dt->nominal,
              "note"    => $note_acc_kredit
            ); 
//        $this->debug($dt);
            $this->global_models->update("site_transport_spj_cogs", array("id_site_transport_spj_cogs" => $dt->id_site_transport_spj_cogs), array("status" => 3, "update_by_users" => $this->session->userdata("id")));
          }
  //      buat bill komisi + menginap
  //    $partner = $this->global_models->get("site_transport_spj_partner", array("id_site_transport_spj" => $pst['id_site_transport_spj'], "status" => 1));
          $partner = $this->global_models->get_query("SELECT A.*,"
            . " (SELECT B.category FROM site_transport_partner AS B WHERE B.id_site_transport_partner = A.id_site_transport_partner) AS category "
            . " FROM site_transport_spj_partner AS A"
            . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}' AND A.status=1");
          $note = "Komisi & biaya menginap";
//        $this->debug(array($data, $spj, $spj_order_payment, $partner));
          foreach ($partner AS $prt){  
            if($prt->category == 1){
              $ckpartner = "Driver";
            }
            else{
              $ckpartner = "Helper";
            }

          if($prt->nominal){
  //          Bill Out Komisi
            $komisi = $prt->nominal;
            $kirim_bill = array(
              "nominal_payment"               => $komisi,
              "start_date"                    => date("Y-m-d H:i:s"),
              "end_date"                      => date("Y-m-d H:i:s"),
              "remark"                        => $note,
              "status"                        => 2,
              "source_id"                     => $prt->id_site_transport_spj_partner,
              "source_table"                  => "site_transport_spj_partner",  
              "fungsi"                        => "crmtrans|m_crmtrans|alter_crm_payment_kasir_out_komisi",
              "note"                          => "SPJ COGS Komisi {$ckpartner}- {$spj[0]->nomor}",
            );
            $pembayaran_bill = $this->m_crmpayment->pembayaran_bill_set($kirim_bill);
          }
          if($prt->menginap){
  //          Bill Out Menginap
            $menginap = $prt->qty_menginap * $prt->menginap;
            $kirim_bill = array(
              "nominal_payment"               => $menginap,
              "start_date"                    => date("Y-m-d H:i:s"),
              "end_date"                      => date("Y-m-d H:i:s"),
              "remark"                        => $note,
              "source_id"                     => $prt->id_site_transport_spj_partner,
              "source_table"                  => "site_transport_spj_partner",
              "status"                        => 2, 
              "fungsi"                        => "crmtrans|m_crmtrans|alter_crm_payment_kasir_out_overnight",
              "note"                          => "SPJ COGS Menginap {$ckpartner}- {$spj[0]->nomor}",
            );
            $pembayaran_bill_menginap = $this->m_crmpayment->pembayaran_bill_set($kirim_bill);
          }
          $komisi = $prt->nominal;

          $this->global_models->update("site_transport_spj_partner", array("id_site_transport_spj_partner" => $prt->id_site_transport_spj_partner), array("id_crm_payment_bill_out" => $pembayaran_bill['id'], "update_by_users" => $this->session->userdata("id")));
        }

        $journal = array(
          "title"     => "SPJ COGS - {$spj[0]->nomor}",
          "code"      => "SP"
        );

  //    print "<pre>";
  //    print_r($debit);
  //    print_r($credit);
  //    print_r($journal);
  //    die("cek");
  //    $this->debug(array($journal, $debit, $credit), true);
          
        $this->m_crmtrans->post_journal($journal, $debit, $credit);
        
//        $this->global_models->update("site_transport_spj", array("id_site_transport_spj" => $pst['id_site_transport_spj']), array("status" => 5, "update_by_users" => $this->session->userdata("id")));
    //    $this->debug("akhir", true);
        
        
//        merger bill out
//        $this->load->model("crmpayment/m_crmpayment");
//        $crm_payment_bill_out = $this->m_crmpayment->bill_out_open_cek();
        
//        $this->global_models->trans_commit();
        
        $balik['status'] = 2;
//        $balik['data']= $this->_spj_format_single_record($pst['id_site_transport_spj']);
      }
      else{
        $balik['status'] = 3;
        $balik['note']   = "Proses Failed";        
      }
    }
    return $balik;
  }
  
  function hitung_menginap_komisi($id_site_transport_spj){
    $partner = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj_partner AS A"
      . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}'"
      . " AND A.nominal NOT IN (150000,75000)"
      . " ");
//    $this->debug($partner);
    $type = 2;
     
    $jml_driver = $this->global_models->get_query("SELECT COUNT(B.category) AS total"
      . " FROM site_transport_spj_partner AS A"
      . " LEFT JOIN site_transport_partner AS B ON B.id_site_transport_partner = A.id_site_transport_partner"
      . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}'"
      . " AND B.category = 1"
      . "");
//    
    $spj = $this->global_models->get_query("SELECT A.id_site_transport_spj,A.status, A.frequency"
      . " ,(SELECT B.komisi FROM site_transport_products_categories AS B WHERE B.id_site_transport_products_categories = ("
        . "SELECT C.id_site_transport_products_categories FROM site_transport_products AS C WHERE C.id_site_transport_products = ("
          . "SELECT D.id_site_transport_products FROM site_transport_products_classification AS D WHERE D.id_site_transport_products_classification = A.id_site_transport_products_classification"
        . ")"
      . ")) AS komisi"
      . " FROM site_transport_spj AS A"
      . " WHERE A.id_site_transport_spj = '{$id_site_transport_spj}'"
      . "");
    
    if($spj[0]->status == 5){
      $this->global_models->query("DELETE FROM site_transport_spj_cogs"
        . " WHERE id_site_transport_spj = '{$id_site_transport_spj}'"
        . " AND type = '{$type}'"
        . " AND nominal <> 150000"
        . " AND nominal <> 75000");
    
      $payment = $this->global_models->get("site_transport_order_payment_spj", array("id_site_transport_spj" => $id_site_transport_spj));
      $total_project = $payment[0]->price_sales + $payment[0]->price_add - $payment[0]->discount - $payment[0]->cashback;
//    total direct cost
      $cogs = $this->global_models->get_query("SELECT A.qty, A.nominal"
        . " FROM site_transport_spj_cogs AS A"
        . " WHERE A.status IN (1,3)"
        . " AND A.type IN (1,4)"
        . " AND A.id_site_transport_spj = '{$id_site_transport_spj}'");
      $total_direct = 0;
      foreach ($cogs AS $cg){
        $total_direct += ($cg->qty * $cg->nominal);
      }
      $sales = $total_project - $total_direct;
//      $this->debug($jml_driver[0]->total);
//      $this->debug($sales);
      if($jml_driver[0]->total > 1){
        $data_json = $this->nbscache->get("crm");
        $data_banding = json_decode($data_json);
        $sales = $sales - $data_banding->variable_default->crmtrans_biaya_2driver;
      }
//      $this->debug($data_banding->variable_default->crmtrans_biaya_2driver);
//      $this->debug($sales, true);
      $komisi = explode("|", $spj[0]->komisi);
      
      $data_json = $this->nbscache->get("crmtrans_account");
      $data_banding = json_decode($data_json);
      
      foreach ($partner AS $prt){
        $qty_masa = 1;
        $komisi_persen = $prt->komisi;
        if($prt->komisi > 4){
          $title = lang("Komisi")." ".lang("Driver");
          $komisi_persen = $komisi[0];
          $deb_cre = explode("|", $data_banding->account_default->crmtrans_account_komisi_driver);
        }
        else{
          $title = lang("Komisi")." ".lang("Helper");
          $komisi_persen = $komisi[1];

          $deb_cre = explode("|", $data_banding->account_default->crmtrans_account_komisi_helper);
        }
      
        $komisi_total = $komisi_persen/100 * $sales;
        $debit = $deb_cre[0];
        $credit = $deb_cre[1];
      
//        if($prt->type == 2){
//          $komisi_total = $prt->komisi;
//          $qty_masa = ($spj[0]->frequency ? $spj[0]->frequency : $qty_masa);
//        }
        
        $this->global_models->generate_id($id_site_transport_spj_cogs, "site_transport_spj_cogs");
        $kirim = array(
          "id_site_transport_spj_cogs"      => $id_site_transport_spj_cogs,
          "id_site_transport_spj"           => $id_site_transport_spj,
          "id_users"                        => $this->session->userdata("id"),
          "title"                           => $title,
          "qty"                             => $qty_masa,
          "nominal"                         => $komisi_total,
          "is_bs"                           => 2,
          "debit"                           => $debit,
          "credit"                          => $credit,
          "type"                            => $type,
          "status"                          => 3,
//          "note"                            => $pst['note'],
          "create_by_users"                 => $this->session->userdata("id"),
          "create_date"                     => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("site_transport_spj_cogs", $kirim);
      
        $this->global_models->update("site_transport_spj_partner", array("id_site_transport_spj_partner" => $prt->id_site_transport_spj_partner), array(
          "komisi"          => $komisi_persen,
          "nominal"         => $komisi_total,
          "note"            => $prt->category."|".$prt->type,
          "update_by_users" => $this->session->userdata("id"),
        ));
        
      }
    }
  }
  
  function spj(){
    $this->global_models->trans_begin();
    $cogs = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj AS A"
      . " WHERE A.status = 5"
      . " AND A.create_by_users <> 1"
      . " AND (A.type = 1 OR A.type IS NULL)"
      . " ORDER BY A.create_date DESC");
    $this->debug($cogs, true);
    foreach ($cogs AS $co){
      $this->debug("buka-----{$co->id_site_transport_spj}");
      $this->hitung_menginap_komisi($co->id_site_transport_spj);
      $this->debug("tengah-----{$co->id_site_transport_spj}");
      $post[] = $this->post_cogs($co->id_site_transport_spj);
      $this->debug("tutup-----{$co->id_site_transport_spj}");
    }
    
    $this->global_models->trans_commit();
    $this->debug($post);
    $this->debug($cogs);
    $this->debug(array(), true);
  }
  
  function spj2(){
    $this->global_models->trans_begin();
    $cogs = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_spj AS A"
      . " WHERE A.status = 5"
      . " AND A.create_by_users = 1"
      . " AND A.note NOT LIKE '%fake%'"
      . " AND (A.type = 1 OR A.type IS NULL)"
      . " ORDER BY A.create_date DESC");
//    $this->debug($cogs, true);
    foreach ($cogs AS $co){
      $this->debug("buka-----{$co->id_site_transport_spj}");
      $this->hitung_menginap_komisi($co->id_site_transport_spj);
      $this->debug("tengah-----{$co->id_site_transport_spj}");
      $post[] = $this->post_cogs($co->id_site_transport_spj);
      $this->debug("tutup-----{$co->id_site_transport_spj}");
    }
    
    $this->global_models->trans_commit();
    $this->debug($post);
    $this->debug($cogs);
    $this->debug(array(), true);
  }
  
  function order(){
    $order = $this->global_models->get_query(""
      . " SELECT C.*"
      . " ,(SELECT D.fungsi FROM crm_payment_bill AS D WHERE D.id_crm_payment_bill = C.id_crm_payment_bill) AS bill"
      . " FROM crm_payment_kasir AS C"
      . " WHERE"
      . " C.id_crm_payment_bill IN ("
        . " SELECT B.id_crm_payment_bill"
        . " FROM crm_payment_bill AS B"
        . " WHERE B.id_crm_payment IN (SELECT A.id_crm_payment FROM site_transport_order_payment AS A)"
        . " AND B.status IN (4,5)"
      . " )"
      . " AND"
      . " C.status = 2"
      . " ORDER BY C.create_date DESC"
      . "");
    $this->load->model("frm/m_frm");
    $this->global_models->trans_begin();
    foreach ($order AS $od){
      $this->global_models->delete("crm_customer_company_deposit_log", array("id" => $od->id_crm_payment_kasir, "tabledatabase" => "crm_payment_kasir"));
      $this->global_models->delete("crm_customer_company_credit_log", array("id" => $od->id_crm_payment_kasir, "tabledatabase" => "crm_payment_kasir"));
      $this->global_models->delete("site_transport_company_credit", array("id_crm_payment_kasir" => $od->id_crm_payment_kasir));
      
      if($od->bill){
        $fungsi = explode("|", $od->bill);
        $this->load->model("{$fungsi[0]}/{$fungsi[1]}");
        $journal = $this->{$fungsi[1]}->{$fungsi[2]}($od->id_crm_payment_kasir);
        
        $periode_tms = $this->m_frm->journal_periode_get($od->update_date);
        $this->global_models->update("frm_journal", array("id_frm_journal" => $journal[0]['data']['id']), array("id_frm_journal_periode" => $periode_tms['data']['id'], "tanggal" => $od->update_date));
//         = $od->id_crm_payment_kasir;
      }
    }
    $this->global_models->trans_commit();
    
    $return = array(
      $journal,
      $order,
    );
    $this->debug($return, true);
  }
  
  function email(){
    
    $this->load->model("home/m_home");
    print $this->m_home->email();
    die;
    
  }
  
  function komisi(){
    $json = '[{"tanggal":"2018-01-08 01:15:00","nomor":"SPJ-20180105-000028","komisi":"86100","qty":"0","menginap":"0","name":"MOCH MURTAQI SHODIQ I","category":"Driver","type":"1"}, {"tanggal":"2018-01-08 01:15:00","nomor":"SPJ-20180105-000028","komisi":"75000","qty":"0","menginap":"0","name":"SETIYONO","category":"Helper","type":"2"}, {"tanggal":"2018-01-09 21:00:00","nomor":"SPJ-20180105-000029","komisi":"121100","qty":"0","menginap":"0","name":"MOCH MURTAQI SHODIQ I","category":"Driver","type":"1"}, {"tanggal":"2018-01-09 21:00:00","nomor":"SPJ-20180105-000029","komisi":"75000","qty":"0","menginap":"0","name":"SETIYONO","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 22:00:00","nomor":"SPJ-20180105-000030","komisi":"149800","qty":"0","menginap":"0","name":"MOCH MURTAQI SHODIQ I","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 22:00:00","nomor":"SPJ-20180105-000030","komisi":"75000","qty":"0","menginap":"0","name":"SETIYONO","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180105-000031","komisi":"44017.89","qty":"0","menginap":"0","name":"MOCH MURTAQI SHODIQ I","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180105-000031","komisi":"75000","qty":"0","menginap":"0","name":"Setiyono","category":"Helper","type":"2"}, {"tanggal":"2018-01-08 16:30:00","nomor":"SPJ-20180105-000034","komisi":"186755.455","qty":"0","menginap":"0","name":"MULYADI","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 01:00:00","nomor":"SPJ-20180108-000054","komisi":"61458.55","qty":"0","menginap":"0","name":"MUDJIONO","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 21:00:00","nomor":"SPJ-20180108-000055","komisi":"109411.185","qty":"0","menginap":"0","name":"MUDJIONO","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 22:15:00","nomor":"SPJ-20180109-000059","komisi":"111117.895","qty":"0","menginap":"0","name":"MUDJIONO","category":"Driver","type":"1"}, {"tanggal":"2018-01-08 14:30:00","nomor":"SPJ-20180109-000061","komisi":"60143.98","qty":"0","menginap":"0","name":"EDI BALDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-08 15:00:00","nomor":"SPJ-20180109-000062","komisi":"150000","qty":"0","menginap":"0","name":"PONIMAN AJI WIBOWO","category":"Driver","type":"2"}, {"tanggal":"2018-01-10 19:00:00","nomor":"SPJ-20180109-000063","komisi":"75000","qty":"0","menginap":"0","name":"NUR RAHIM","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 19:00:00","nomor":"SPJ-20180109-000063","komisi":"98569.366","qty":"0","menginap":"0","name":"DUDIEK PANDUADIANTORO","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 20:00:00","nomor":"SPJ-20180109-000064","komisi":"93246.335","qty":"0","menginap":"0","name":"MULYADI","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000066","komisi":"100020.026","qty":"0","menginap":"0","name":"NUR ROCHIM","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000066","komisi":"175035.0455","qty":"0","menginap":"0","name":"ADE RUSWENDA","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000067","komisi":"116684.673","qty":"0","menginap":"0","name":"JOHANA","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000067","komisi":"75000","qty":"0","menginap":"0","name":"RONI IRAWAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000068","komisi":"150000","qty":"0","menginap":"0","name":"SIGIT SURYANTO","category":"Driver","type":"2"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000068","komisi":"75000","qty":"0","menginap":"0","name":"NURDIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000069","komisi":"65552.838","qty":"0","menginap":"0","name":"ANDRE","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000069","komisi":"114717.4665","qty":"0","menginap":"0","name":"ARSAD","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000070","komisi":"150000","qty":"0","menginap":"0","name":"DONI ASTIAN","category":"Driver","type":"2"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000070","komisi":"71057.702","qty":"0","menginap":"0","name":"SUPRASETYO","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 18:00:00","nomor":"SPJ-20180109-000071","komisi":"110425.28","qty":"0","menginap":"0","name":"APRILIYANTO PRATAMA","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 18:00:00","nomor":"SPJ-20180109-000071","komisi":"63100.16","qty":"0","menginap":"0","name":"SOLEHAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000072","komisi":"116911.872","qty":"0","menginap":"0","name":"FERRY M NUGRAHA","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000072","komisi":"66806.784","qty":"0","menginap":"0","name":"NANDA","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000073","komisi":"58690.796","qty":"0","menginap":"0","name":"EGA HERMAWAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000073","komisi":"102708.893","qty":"0","menginap":"0","name":"HUMAEDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:15:00","nomor":"SPJ-20180109-000074","komisi":"75000","qty":"0","menginap":"0","name":"RIZAL FL","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 17:15:00","nomor":"SPJ-20180109-000074","komisi":"133609","qty":"0","menginap":"0","name":"WAHYUDI AMIN","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 17:15:00","nomor":"SPJ-20180109-000075","komisi":"120781.648","qty":"0","menginap":"0","name":"MARYADI","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 17:15:00","nomor":"SPJ-20180109-000075","komisi":"150000","qty":"0","menginap":"0","name":"ASEP AWALUDIN","category":"Driver","type":"2"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000076","komisi":"150000","qty":"0","menginap":"0","name":"NAPIH","category":"Driver","type":"2"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000076","komisi":"75000","qty":"0","menginap":"0","name":"GUSTIAN ARISMAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000077","komisi":"65512.42","qty":"0","menginap":"0","name":"ENDE WAHYUDIN","category":"Helper","type":"1"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000077","komisi":"114646.735","qty":"0","menginap":"0","name":"ANDI BUDI RAHARJO","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000078","komisi":"118343.778","qty":"0","menginap":"0","name":"HAMAM MUNANDAR","category":"Driver","type":"1"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000078","komisi":"75000","qty":"0","menginap":"0","name":"EVIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000079","komisi":"98601.22","qty":"0","menginap":"0","name":"AMIN MANSYUR","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000080","komisi":"93261.96","qty":"0","menginap":"0","name":"AMIN MANSYUR","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:00:00","nomor":"SPJ-20180110-000081","komisi":"108825.91","qty":"0","menginap":"0","name":"MULYADI","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:00:00","nomor":"SPJ-20180110-000083","komisi":"113638.07","qty":"0","menginap":"0","name":"EDI BALDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000084","komisi":"150000","qty":"0","menginap":"0","name":"PONIMAN AJI WIBOWO","category":"Driver","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000085","komisi":"104403.2115","qty":"0","menginap":"0","name":"RESTU EKA","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000085","komisi":"75000","qty":"0","menginap":"0","name":"NURDIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000086","komisi":"58916.966","qty":"0","menginap":"0","name":"SUPRASETYO","category":"Helper","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000086","komisi":"150000","qty":"0","menginap":"0","name":"SIGIT SURYANTO","category":"Driver","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000087","komisi":"61289.398","qty":"0","menginap":"0","name":"SOLEHAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000087","komisi":"107256.4465","qty":"0","menginap":"0","name":"APRILIYANTO PRATAMA","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000088","komisi":"75000","qty":"0","menginap":"0","name":"RIZAL FL","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000088","komisi":"101788.82","qty":"0","menginap":"0","name":"WAHYUDI AMIN","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000089","komisi":"60433.744","qty":"0","menginap":"0","name":"MARYADI","category":"Helper","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000089","komisi":"150000","qty":"0","menginap":"0","name":"MOH.SHOFARI\/EAGLE","category":"Driver","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000090","komisi":"75000","qty":"0","menginap":"0","name":"GUSTIAN ARISMAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000090","komisi":"150000","qty":"0","menginap":"0","name":"NAPIH","category":"Driver","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000091","komisi":"105403.116","qty":"0","menginap":"0","name":"ANDI BUDI RAHARJO","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000091","komisi":"60230.352","qty":"0","menginap":"0","name":"ENDE WAHYUDIN","category":"Helper","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000092","komisi":"99434.5625","qty":"0","menginap":"0","name":"HAMAM MUNANDAR","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000092","komisi":"75000","qty":"0","menginap":"0","name":"EVIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000093","komisi":"57697.42","qty":"0","menginap":"0","name":"ANDRE","category":"Helper","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000093","komisi":"100970.485","qty":"0","menginap":"0","name":"ARSAD","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000094","komisi":"109797.9715","qty":"0","menginap":"0","name":"FERRY M NUGRAHA","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000094","komisi":"75000","qty":"0","menginap":"0","name":"NUR RAHIM","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000095","komisi":"145997.908","qty":"0","menginap":"0","name":"JOHANA","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000095","komisi":"75000","qty":"0","menginap":"0","name":"RONI IRAWAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-11 20:30:00","nomor":"SPJ-20180110-000096","komisi":"148407.3185","qty":"0","menginap":"0","name":"HUMAEDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-11 20:30:00","nomor":"SPJ-20180110-000096","komisi":"84804.182","qty":"0","menginap":"0","name":"EGA HERMAWAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000101","komisi":"520437.96","qty":"2","menginap":"50000","name":"MULYADI","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 09:00:00","nomor":"SPJ-20180111-000102","komisi":"75000","qty":"0","menginap":"0","name":"RONI IRAWAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-12 09:00:00","nomor":"SPJ-20180111-000102","komisi":"98969.22","qty":"0","menginap":"0","name":"JOHANA","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 10:00:00","nomor":"SPJ-20180111-000103","komisi":"58573.67","qty":"0","menginap":"0","name":"SOLEHAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-12 10:00:00","nomor":"SPJ-20180111-000103","komisi":"102503.9225","qty":"0","menginap":"0","name":"APRILIYANTO PRATAMA","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 15:00:00","nomor":"SPJ-20180111-000104","komisi":"150000","qty":"0","menginap":"0","name":"H TOPIK","category":"Driver","type":"2"}, {"tanggal":"2018-01-13 15:00:00","nomor":"SPJ-20180111-000104","komisi":"56628.412","qty":"0","menginap":"0","name":"MARYADI","category":"Helper","type":"1"}, {"tanggal":"2018-01-12 21:30:00","nomor":"SPJ-20180111-000106","komisi":"130445","qty":"0","menginap":"0","name":"HAMAM MUNANDAR","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 21:30:00","nomor":"SPJ-20180111-000106","komisi":"74540","qty":"0","menginap":"0","name":"IQBAL","category":"Helper","type":"1"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000107","komisi":"178034.192","qty":"1","menginap":"40000","name":"ENDE WAHYUDIN","category":"Helper","type":"1"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000107","komisi":"311559.836","qty":"1","menginap":"50000","name":"ARIFIN","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000109","komisi":"75000","qty":"0","menginap":"0","name":"SETIYONO","category":"Helper","type":"2"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000109","komisi":"315521.3705","qty":"1","menginap":"50000","name":"MOCH MURTAQI SHODIQ I","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 23:00:00","nomor":"SPJ-20180111-000110","komisi":"75000","qty":"0","menginap":"0","name":"NURDIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-12 23:00:00","nomor":"SPJ-20180111-000110","komisi":"168207.9175","qty":"0","menginap":"0","name":"RESTU EKA","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 12:30:00","nomor":"SPJ-20180111-000112","komisi":"150000","qty":"0","menginap":"0","name":"PONIMAN AJI WIBOWO","category":"Driver","type":"2"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000114","komisi":"150000","qty":"0","menginap":"0","name":"PONIMAN AJI WIBOWO","category":"Driver","type":"2"}, {"tanggal":"2018-01-12 21:00:00","nomor":"SPJ-20180111-000116","komisi":"96031.6875","qty":"0","menginap":"0","name":"HUMAEDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-12 21:00:00","nomor":"SPJ-20180111-000116","komisi":"54875.25","qty":"0","menginap":"0","name":"EGA HERMAWAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 20:00:00","nomor":"SPJ-20180112-000132","komisi":"164970.255","qty":"0","menginap":"0","name":"MUDJIONO","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000133","komisi":"75000","qty":"0","menginap":"0","name":"NURDIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000133","komisi":"157378.753","qty":"0","menginap":"0","name":"JOHANA","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000134","komisi":"75000","qty":"0","menginap":"0","name":"DUDI","category":"Helper","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000134","komisi":"159879.7025","qty":"0","menginap":"0","name":"RESTU EKA","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000135","komisi":"150000","qty":"0","menginap":"0","name":"SAIFUL","category":"Driver","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000135","komisi":"88525.5","qty":"0","menginap":"0","name":"SUPRASETYO","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000136","komisi":"154301.049","qty":"0","menginap":"0","name":"APRILIYANTO PRATAMA","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000136","komisi":"88172.028","qty":"0","menginap":"0","name":"SOLEHAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 20:45:00","nomor":"SPJ-20180112-000137","komisi":"75000","qty":"0","menginap":"0","name":"RIZAL FL","category":"Helper","type":"2"}, {"tanggal":"2018-01-14 20:45:00","nomor":"SPJ-20180112-000137","komisi":"161873.3095","qty":"0","menginap":"0","name":"WAHYUDI AMIN","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 20:30:00","nomor":"SPJ-20180112-000138","komisi":"89090.352","qty":"0","menginap":"0","name":"MARYADI","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 20:30:00","nomor":"SPJ-20180112-000138","komisi":"150000","qty":"0","menginap":"0","name":"H TOPIK","category":"Driver","type":"2"}, {"tanggal":"2018-01-14 20:30:00","nomor":"SPJ-20180112-000139","komisi":"93783.42","qty":"0","menginap":"0","name":"EDI SIREGAR","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 20:30:00","nomor":"SPJ-20180112-000139","komisi":"150000","qty":"0","menginap":"0","name":"MOH.SHOFARI\/EAGLE","category":"Driver","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000140","komisi":"150000","qty":"0","menginap":"0","name":"NAPIH","category":"Driver","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000140","komisi":"75000","qty":"0","menginap":"0","name":"GUSTIAN ARISMAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000141","komisi":"90379.476","qty":"0","menginap":"0","name":"FACHRIZAL A","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000141","komisi":"158164.083","qty":"0","menginap":"0","name":"ANDI BUDI RAHARJO","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000142","komisi":"162783.1695","qty":"0","menginap":"0","name":"HUMAEDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000142","komisi":"93018.954","qty":"0","menginap":"0","name":"EGA HERMAWAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-13 17:00:00","nomor":"SPJ-20180112-000143","komisi":"150000","qty":"0","menginap":"0","name":"NAPIH","category":"Driver","type":"2"}, {"tanggal":"2018-01-13 17:00:00","nomor":"SPJ-20180112-000143","komisi":"75000","qty":"0","menginap":"0","name":"GUSTIAN ARISMAN","category":"Helper","type":"2"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000144","komisi":"169332.8","qty":"0","menginap":"0","name":"APRILIYANTO PRATAMA","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000144","komisi":"96761.6","qty":"0","menginap":"0","name":"SOLEHAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180112-000145","komisi":"75000","qty":"0","menginap":"0","name":"UUN RUSDIANA","category":"Helper","type":"2"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180112-000145","komisi":"255407.4201","qty":"0","menginap":"0","name":"IWAN RUSWANDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000147","komisi":"75000","qty":"0","menginap":"0","name":"NURDIN","category":"Helper","type":"2"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000147","komisi":"133940.6635","qty":"0","menginap":"0","name":"JOHANA","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000148","komisi":"69753.966","qty":"0","menginap":"0","name":"ANDRE","category":"Helper","type":"1"}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000148","komisi":"122069.4405","qty":"0","menginap":"0","name":"ARSAD","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000149","komisi":"72125.138","qty":"0","menginap":"0","name":"NANDA","category":"Helper","type":"1"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000149","komisi":"126218.9915","qty":"0","menginap":"0","name":"FERRY M NUGRAHA","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 20:15:00","nomor":"SPJ-20180112-000150","komisi":"75000","qty":"0","menginap":"0","name":"DUDI","category":"Helper","type":"2"}, {"tanggal":"2018-01-13 20:15:00","nomor":"SPJ-20180112-000150","komisi":"132883.6285","qty":"0","menginap":"0","name":"RESTU EKA","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000151","komisi":"130996.7715","qty":"0","menginap":"0","name":"HUMAEDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000151","komisi":"74855.298","qty":"0","menginap":"0","name":"EGA HERMAWAN","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 23:00:00","nomor":"SPJ-20180112-000152","komisi":"122954.9615","qty":"0","menginap":"0","name":"ADE RUSWENDA","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 23:00:00","nomor":"SPJ-20180112-000152","komisi":"70259.978","qty":"0","menginap":"0","name":"NUR ROCHIM","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 17:30:00","nomor":"SPJ-20180112-000153","komisi":"101979.619","qty":"0","menginap":"0","name":"ARSAD","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 17:30:00","nomor":"SPJ-20180112-000153","komisi":"58274.068","qty":"0","menginap":"0","name":"ANDRE","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 17:30:00","nomor":"SPJ-20180112-000154","komisi":"101289.622","qty":"0","menginap":"0","name":"FERRY M NUGRAHA","category":"Driver","type":"1"}, {"tanggal":"2018-01-14 17:30:00","nomor":"SPJ-20180112-000154","komisi":"57879.784","qty":"0","menginap":"0","name":"NANDA","category":"Helper","type":"1"}, {"tanggal":"2018-01-14 20:00:00","nomor":"SPJ-20180112-000155","komisi":"160683.365","qty":"0","menginap":"0","name":"AMIN MANSYUR","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 18:30:00","nomor":"SPJ-20180112-000156","komisi":"75000","qty":"0","menginap":"0","name":"RIZAL FL","category":"Helper","type":"2"}, {"tanggal":"2018-01-13 18:30:00","nomor":"SPJ-20180112-000156","komisi":"123253.9525","qty":"0","menginap":"0","name":"WAHYUDI AMIN","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 19:00:00","nomor":"SPJ-20180112-000157","komisi":"136650.85","qty":"0","menginap":"0","name":"IWAN RUSWANDI","category":"Driver","type":"1"}, {"tanggal":"2018-01-13 19:00:00","nomor":"SPJ-20180112-000157","komisi":"75000","qty":"0","menginap":"0","name":"UUN RUSDIANA","category":"Helper","type":"2"}]';
    
    $data = json_decode($json);
//    $this->debug($data, true);
    print "<table width='100%'>";
    foreach ($data AS $dt){
      print "<tr>"
        . "<td>{$dt->tanggal}</td>"
        . "<td>{$dt->nomor}</td>"
        . "<td>{$dt->name}</td>"
        . "<td>{$dt->category}</td>"
        . "<td>".number_format($dt->komisi, 4, ",", ".")."</td>"
        . "<td>".number_format(($dt->type == 1 ? $dt->qty: 0), 0, ",", ".")."</td>"
        . "<td>".number_format(($dt->type == 1 ? $dt->menginap: 0), 4, ",", ".")."</td>"
      . "</tr>";
    }
    print "</table>";
    die;
  }
  
  function cogs(){
    $json = '[{"tanggal":"2018-01-08 01:15:00","nomor":"SPJ-20180105-000028","title":"Lainnya","nominal":"100000","qty":"1","note":"<p>tol&amp;parkir<br><\/p>"}, {"tanggal":"2018-01-09 21:00:00","nomor":"SPJ-20180105-000029","title":"Lainnya","nominal":"150000","qty":"1","note":"<p>tol&amp;parkir<br><\/p>"}, {"tanggal":"2018-01-10 22:00:00","nomor":"SPJ-20180105-000030","title":"Lainnya","nominal":"300000","qty":"1","note":"<p>tol&amp;parkir<br><\/p>"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180105-000031","title":"Lainnya","nominal":"150000","qty":"1","note":"<p>tol&amp;parkir<br><\/p>"}, {"tanggal":"2018-01-08 16:30:00","nomor":"SPJ-20180105-000034","title":"Tol","nominal":"88500","qty":"1","note":"<p>4 LMB<br><\/p>"}, {"tanggal":"2018-01-10 01:00:00","nomor":"SPJ-20180108-000054","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LEMBAR<br><\/p>"}, {"tanggal":"2018-01-10 21:00:00","nomor":"SPJ-20180108-000055","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-11 22:15:00","nomor":"SPJ-20180109-000059","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LMB<br><\/p>"}, {"tanggal":"2018-01-08 14:30:00","nomor":"SPJ-20180109-000061","title":"Tol","nominal":"16500","qty":"1","note":"<p>1 LMB<br><\/p>"}, {"tanggal":"2018-01-08 14:30:00","nomor":"SPJ-20180109-000061","title":"Lainnya","nominal":"100000","qty":"1","note":"<p>BIAYA TAMBAHAN TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-08 15:00:00","nomor":"SPJ-20180109-000062","title":"Lainnya","nominal":"100000","qty":"1","note":"<p>BIAYA TAMBAHAN TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-08 15:00:00","nomor":"SPJ-20180109-000062","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LEMBAR<br><\/p>"}, {"tanggal":"2018-01-10 20:00:00","nomor":"SPJ-20180109-000064","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LB<br><\/p>"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000066","title":"Tol","nominal":"27000","qty":"1","note":"<p>2 LMBR<br><\/p>"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000069","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LB<br><\/p>"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000070","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LB<br><\/p>"}, {"tanggal":"2018-01-10 18:00:00","nomor":"SPJ-20180109-000071","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000072","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-10 17:30:00","nomor":"SPJ-20180109-000073","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-10 17:15:00","nomor":"SPJ-20180109-000074","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LEMBAR<br><\/p>"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000076","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000077","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-10 18:15:00","nomor":"SPJ-20180109-000078","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000079","title":"Tol","nominal":"39500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-10 19:15:00","nomor":"SPJ-20180109-000079","title":"Lainnya","nominal":"72000","qty":"1","note":"<p>TAMBAHAN BIAYA TOL &amp; PARKIR TAMU<br><\/p>"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000080","title":"Lainnya","nominal":"200000","qty":"1","note":"<p>TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-11 18:00:00","nomor":"SPJ-20180110-000081","title":"Lainnya","nominal":"200000","qty":"1","note":"<p>TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-11 18:00:00","nomor":"SPJ-20180110-000083","title":"Lainnya","nominal":"200000","qty":"1","note":"<p>TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000084","title":"Lainnya","nominal":"200000","qty":"1","note":"<p>TOL DAN PARKIR<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000085","title":"Tol","nominal":"52000","qty":"1","note":"<p>5 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000086","title":"Tol","nominal":"52000","qty":"1","note":"<p>5 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000087","title":"Tol","nominal":"42500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000088","title":"Tol","nominal":"47000","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000089","title":"Tol","nominal":"52000","qty":"1","note":"<p>5 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000090","title":"Tol","nominal":"61000","qty":"1","note":"<p>5 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000091","title":"Tol","nominal":"42500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000092","title":"Tol","nominal":"61500","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000093","title":"Tol","nominal":"47000","qty":"1","note":"<p>5 LB<br><\/p>"}, {"tanggal":"2018-01-11 18:30:00","nomor":"SPJ-20180110-000094","title":"Tol","nominal":"42500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-11 19:30:00","nomor":"SPJ-20180110-000095","title":"Tol","nominal":"42500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-11 20:30:00","nomor":"SPJ-20180110-000096","title":"Tol","nominal":"39500","qty":"1","note":"<p>4 LB<br><\/p>"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000101","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 lb<br><\/p>"}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000101","title":"Fuel","nominal":"360500","qty":"1","note":""}, {"tanggal":"2018-01-12 09:00:00","nomor":"SPJ-20180111-000102","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-12 10:00:00","nomor":"SPJ-20180111-000103","title":"Tol","nominal":"16500","qty":"1","note":"<p>1 lb<br><\/p>"}, {"tanggal":"2018-01-13 15:00:00","nomor":"SPJ-20180111-000104","title":"Tol","nominal":"16500","qty":"1","note":"<p>2 LB<br><\/p>"}, {"tanggal":"2018-01-12 21:30:00","nomor":"SPJ-20180111-000106","title":"Tol","nominal":"16500","qty":"1","note":"<p>1 lmbr<br><\/p>"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000107","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-13 15:30:00","nomor":"SPJ-20180111-000109","title":"Tol","nominal":"33000","qty":"1","note":""}, {"tanggal":"2018-01-12 23:00:00","nomor":"SPJ-20180111-000110","title":"Tol","nominal":"95500","qty":"1","note":""}, {"tanggal":"2018-01-12 12:30:00","nomor":"SPJ-20180111-000112","title":"Lainnya","nominal":"150000","qty":"1","note":"<p>tol&amp;parkir<br><\/p>"}, {"tanggal":"2018-01-12 12:30:00","nomor":"SPJ-20180111-000112","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000114","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-14 23:30:00","nomor":"SPJ-20180111-000114","title":"Parkir","nominal":"50000","qty":"1","note":""}, {"tanggal":"2018-01-12 21:00:00","nomor":"SPJ-20180111-000116","title":"Tol","nominal":"61500","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-12 21:00:00","nomor":"SPJ-20180111-000116","title":"Lainnya","nominal":"200000","qty":"1","note":"<p>TOL&amp;PARKIR<br><\/p>"}, {"tanggal":"2018-01-14 20:00:00","nomor":"SPJ-20180112-000132","title":"Tol","nominal":"23500","qty":"1","note":""}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000133","title":"Tol","nominal":"14000","qty":"1","note":"<p>2 LB<br><\/p>"}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000135","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-14 21:00:00","nomor":"SPJ-20180112-000136","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 lb<br><\/p>"}, {"tanggal":"2018-01-14 20:45:00","nomor":"SPJ-20180112-000137","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-14 20:30:00","nomor":"SPJ-20180112-000138","title":"Tol","nominal":"16500","qty":"1","note":""}, {"tanggal":"2018-01-13 17:00:00","nomor":"SPJ-20180112-000143","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000144","title":"Tol","nominal":"33000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000148","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-13 21:00:00","nomor":"SPJ-20180112-000149","title":"Tol","nominal":"26000","qty":"1","note":"<p>3 LB<br><\/p>"}, {"tanggal":"2018-01-13 20:15:00","nomor":"SPJ-20180112-000150","title":"Tol","nominal":"52000","qty":"1","note":""}, {"tanggal":"2018-01-13 20:30:00","nomor":"SPJ-20180112-000151","title":"Tol","nominal":"52000","qty":"1","note":""}, {"tanggal":"2018-01-13 18:30:00","nomor":"SPJ-20180112-000156","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}, {"tanggal":"2018-01-13 19:00:00","nomor":"SPJ-20180112-000157","title":"Tol","nominal":"52000","qty":"1","note":"<p>6 LB<br><\/p>"}]';
    
    $data = json_decode($json);
//    $this->debug($data, true);
    print "<table width='100%'>";
    foreach ($data AS $dt){
      print "<tr>"
        . "<td>{$dt->tanggal}</td>"
        . "<td>{$dt->nomor}</td>"
        . "<td>{$dt->title}</td>"
        . "<td>".number_format($dt->qty, 4, ",", ".")."</td>"
        . "<td>".number_format($dt->nominal, 4, ",", ".")."</td>"
        . "<td>{$dt->note}</td>"
      . "</tr>";
    }
    print "</table>";
    die;
  }
  
  function test($id_crm_payment_kasir){
    
//    $this->load->model("crmtrans/m_crmtrans");
//    $this->debug($this->m_crmtrans->merchandise_tambahan_get("G7SKMJB7UKPSOLE2GRUV"), true);
    
    $this->load->model("crmpos/m_crmpos");
    $this->debug($this->m_crmpos->order_spj_count("BZQJ8R", 0, 0), true);
    
    
    $this->load->model("scmoutlet/m_scmoutlet");
    $this->m_scmoutlet->scm_outlet_storage_inventory_log_out_commit('EHOOHSRU');
    die;
    $this->global_models->generate_id($id, "crm_cashback", $id_crm_payment_kasir);
    $this->debug($id, true);
    $data = $this->global_models->get_query("SHOW PROCESSLIST");
    foreach ($data AS $dt){
//      if($dt->Command == 'Sleep')
//        $this->global_models->query("KILL {$dt->Id}");
    }
    $data = $this->global_models->get_query("SHOW PROCESSLIST");
    $this->debug($data, true);
  }
  
  function alter(){
    $this->global_models->get_connect('finger');
    $this->global_models->query(""
      . "ALTER TABLE checkinout ADD create_date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER Reserved"
      . "");
    $this->global_models->query(""
      . "ALTER TABLE userinfo ADD id_hrm_attendance_shifting VARCHAR(20) NULL DEFAULT NULL AFTER userid"
      . "");
    $this->global_models->query(""
      . "ALTER TABLE `userinfo` ADD `shifting_type` TINYINT(1) NULL AFTER `userid`"
      . "");
//    $this->global_models->query(""
//      . "TRUNCATE userinfo"
//      . "");
//    $this->global_models->query(""
//      . "TRUNCATE departments"
//      . "");
    $this->debug($this->global_models->get("userinfo"));
//    $this->debug($this->global_models->get("userinfo"));
//    $this->debug($this->global_models->get_query("SELECT A.*"
//      . " FROM checkinout AS A"
//      . " ORDER BY A.checktime ASC"));
//    $this->debug($this->global_models->get("iclock"));
    $this->global_models->get_connect('default');
    $this->debug($this->global_models->get("m_users"));
    print "nbs";
    die;
  }
  
	public function index(){
    $this->load->model("home/js/j_home");
    $foot .= ""
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . $this->j_home->widget_variable()
      . $this->j_home->widget_get_hrd()
      . "get_hrd();"
      . $this->j_home->widget_get_kurs()
      . "get_kurs();"
      . "</script>";
    
    
    $this->template
      ->set_layout('default')
      ->build('main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "home",
        'title'       => lang("Dashboard"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("main");
	}
  
	public function index2(){
    $foot = ""
      . "<script src='https://cdn.onesignal.com/sdks/OneSignalSDK.js' async='async'></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: 'f14970af-c82f-4d84-97ee-118dc0a3faf2',
      autoRegister: false,
      notifyButton: {
        enable: true,
      },
    });
  });
</script>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('main', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "home",
        'title'       => lang("Dashboard"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("main");
	}
  
	public function contact_us($id_contact, $stat = 0, $pesan = ""){
    if(!$this->input->post(NULL)){
      if($this->session->userdata('id') == 1){
        $detail = $this->global_models->get("d_contact_us", array("id_contact_us" => $id_contact));
      }
      $this->template->build("contact-us", 
        array('message'     => urldecode ($pesan),
              'url'         => base_url()."themes/srabon/",
              'title_table' => "Cotact Us",
              'stat'        => $stat,
              'detail'      => $detail,
              'foot'        => ""
            ));
      $this->template
        ->set_layout('default')
        ->build("contact-us");
    }
    else{
      $pst = $this->input->post(NULL);
      $today = time();
      $kirim = array(
          "title"     =>  $pst['title'],
          "name"      =>  $pst['name'],
          "tanggal"   =>  date("Y-m-d"),
          "email"     =>  $pst['email'],
          "telp"      =>  $pst['telp'],
          "note"      =>  $pst['note']
      );
      if($this->global_models->insert("d_contact_us", $kirim)){
        $this->email->from($pst['email'], $pst['name']);
        $this->email->to('project@nusato.com');

        $this->email->subject('Opportunity New Client');
        $this->email->message("
          title     =>  {$pst['title']}
          name      =>  {$pst['name']}
          tanggal   =>  ".date("Y-m-d")."
          email     =>  {$pst['email']}
          telp      =>  {$pst['telp']}
          note      =>  {$pst['note']}
          ");

        if($this->email->send() === TRUE){
          redirect("home/contact-us/0/1/Data telah disimpan dan mengirim email kepada kami. Kami akan membaca dan merespon keinginan anda. Terima Kasih");
        }
        else{
          redirect("home/contact-us/0/1/Data telah disimpan tapi gagal mengirim email. Kami tetap dapat membaca dan merespon keinginan anda. Terima Kasih");
        }
      }
      else{
        redirect("home/contact-us/0/2/Data gagal disimpan harap coba lagi atau langsung contact kami dengan info contact di bawah. Terima Kasih");
      }
    }
	}
	public function opportunity_list(){
    $data = $this->global_models->get("d_contact_us");
    $this->template->build("opportunity-list",
      array('message'     => $pesan,
            'url'         => base_url()."themes/srabon/",
            'title_table' => "Opportunity",
            'data'        => $data,
            'foot'        => ""
          ));
    $this->template
      ->set_layout('default')
      ->build("opportunity-list");
	}
    
   function calculate_deposite(){
       $data = $this->global_models->get("crm_customer_company_deposit");
       
       foreach ($data as $val) {
          $get =  $this->global_models->get_query("SELECT A.id_crm_customer_company"
                   . " ,(SELECT SUM(B.credit) FROM crm_customer_company_deposit_log AS B WHERE B.status=1 AND B.id_crm_customer_company= '{$val->id_crm_customer_company}') AS kredit"
                   . " ,(SELECT SUM(C.debit) FROM crm_customer_company_deposit_log AS C WHERE C.status=11 AND C.id_crm_customer_company= '{$val->id_crm_customer_company}') AS debit"
                   . " FROM crm_customer_company_deposit_log AS A WHERE A.id_crm_customer_company='{$val->id_crm_customer_company}'"
                   . " GROUP BY A.id_crm_customer_company");
       
         if($get[0]->debit){
             $dtdebit = $get[0]->debit;
         }else{
             $dtdebit = 0;
         }
         
         if($get[0]->kredit){
             $dtcredit = $get[0]->kredit;
         }else{
             $dtcredit = 0;
         }
        $deposit = ($dtcredit - $dtdebit);
        
        print "debit :".$dtdebit."<br>";
        print "credit :".$dtcredit."<br>";
        
        print $get[0]->id_crm_customer_company." ".$deposit."<br>";
        
        $kirim = array("deposit" => "{$deposit}");           
        $this->global_models->update("crm_customer_company_deposit",array("id_crm_customer_company" => "{$get[0]->id_crm_customer_company}"),$kirim);          
           
       }
       die("selesai");
   }
   
   function calculate_credit(){
       $data = $this->global_models->get("crm_customer_company_credit");
       
       foreach ($data as $val) {
           $get = $this->global_models->get_query("SELECT A.id_crm_customer_company"
            . " ,(SELECT SUM(B.in) FROM crm_customer_company_credit_log AS B WHERE B.status IN(1,10) AND B.id_crm_customer_company = A.id_crm_customer_company) AS dtin"
            . " ,(SELECT SUM(C.out) FROM crm_customer_company_credit_log AS C WHERE C.status IN(11) AND C.id_crm_customer_company = A.id_crm_customer_company) AS dtout"       
            . " FROM crm_customer_company_credit_log AS A WHERE A.id_crm_customer_company ='{$val->id_crm_customer_company}' GROUP BY A.id_crm_customer_company");
       
            if($get[0]->dtin){
                $dt_in = $get[0]->dtin;
            }else{
                $dt_in = 0;
            }
            
            if($get[0]->dtout){
                $dt_out = $get[0]->dtout;
            }else{
                $dt_out = 0;
            }
            
            $credit = $dt_in - $dt_out;
            if($credit > 0){
                $h_credit = $credit;
            }else{
                $h_credit = 0;
            }
            $kirim = array("credit" => "{$h_credit}");
            $this->global_models->update("crm_customer_company_credit",array("id_crm_customer_company" => "{$get[0]->id_crm_customer_company}"),$kirim);          
        
            }
       
   }
   
   
   function test_noty(){
      $response = $this->sendMessage();
      $return["allresponses"] = $response;
      $return = json_encode($return);

      $data = json_decode($response, true);
      print_r($data);
      $id = $data['id'];
      print_r($id);

      print("\n\nJSON received:\n");
      print($return);
      print("\n");
   }
   
   function sendMessage() {
    $content      = array(
        "en" => 'English Message'
    );
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "",
        "url" => "http://117.102.80.180/demo/cek/home/index2"
    ));
    array_push($hashes_array, array(
        "id" => "like-button-2",
        "text" => "Like2",
        "icon" => "",
        "url" => "http://117.102.80.180/demo/cek/home/index2"
    ));
    $fields = array(
        'app_id' => "f14970af-c82f-4d84-97ee-118dc0a3faf2",
        'included_segments' => array(
            'All'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
        'web_buttons' => $hashes_array
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MDFjMWEwNzAtZDkxOC00MDRlLTk2YjgtZGE3YzRmMTk4ZTE4'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */