<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Komisi_ajax extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
 
  function bulanan_set(){
    $pst = $this->input->post();
    
    if($pst['bulan'] <> "" AND $pst['tahun'] <> ""){
    $get = $this->global_models->get("site_transport_komisi",array("tahun" => "{$pst['tahun']}","bulan" => "{$pst['bulan']}"));
    
    if($get[0]->id_site_transport_komisi){
        $hasil['status'] = 3;
        $hasil['note']  = "Data Sudah Ada";
    }else{
    $this->global_models->generate_id($id_site_transport_komisi, "site_transport_komisi");
    $this->db->trans_begin();
    $kirim = array("id_site_transport_komisi" => "{$id_site_transport_komisi}",
                "bulan"               => "{$pst['bulan']}",
                "tahun"               => "{$pst['tahun']}",
                "create_by_users"     => $this->session->userdata("id"),
                "create_date"         => date("Y-m-d H:i:s")
            );
    $this->global_models->insert("site_transport_komisi",$kirim);
    $get = $this->global_models->get("site_transport_partner",array("status" => 1));
    
    foreach ($get as $v) {
        if($v->npwp){
            $st_npwp = 1;
        }else{
            $st_npwp = 2;
        }
        
        if($v->no_bpjs_kesehatan){
            $bpjs_kesehatan = $v->bpjs_kesehatan;
        }else{
            $bpjs_kesehatan = "";
        }
        
        $tgl2 = date("{$pst['tahun']}-{$pst['bulan']}");
        $lastday = date('t',strtotime($tgl2));
        $dd = "{$pst['tahun']}-{$pst['bulan']}-{$lastday}";
        
        $selisih = ((round(strtotime ($dd) - strtotime ($v->hire_date)))/(60*60*24));
        
        /* selisih > 30
         status selisih =1 lebih dari 30 hari kerja
         * selisih > 0 status selisih =2 proposional;
         * status = 3;
         * 
        */
        if($selisih > 30){
            $cek_status = 1;
        }else{
            if($selisih > 0){
                $cek_status = 2;
            }else{
                $cek_status = 3;
            }
        }
        if(in_array($cek_status, array(1,2))){
        $this->global_models->generate_id($id_site_transport_komisi_partner, "site_transport_komisi_partner");
        $kirim = array("id_site_transport_komisi"   => "{$id_site_transport_komisi}",
                "id_site_transport_komisi_partner"  => $id_site_transport_komisi_partner,
                "id_site_transport_partner"         => $v->id_site_transport_partner,
                "biaya_retensi"                     => "{$v->biaya_retensi}",
                "uang_pengganti"                    => "{$v->uang_pengganti}",
                "status_partner"                    => $cek_status,
                "last_date"                         => $dd,       
                "bpjs_kesehatan"                    => "{$bpjs_kesehatan}",
                "npwp"                              => "{$st_npwp}",
                "create_by_users"                   => $this->session->userdata("id"),
                "create_date"                       => date("Y-m-d H:i:s")
            );
        $this->global_models->insert("site_transport_komisi_partner",$kirim);
        }
    }
    $this->db->trans_commit();
    $hasil['status'] = 2;
    }
    }else{
        $note = "";
        if($pst['bulan'] == ""){
            $note .= "Bulan Harus diisi </br>";
        }
        if($pst['tahun'] == ""){
            $note .= "Tahun harus di isi";
        }
        $hasil['status'] = 3;
        $hasil['note']  = $note;
    }
    print json_encode($hasil);
    die;
  }
  
  function partner_get(){
      $pst = $this->input->post();
       $data = $this->global_models->get_query("SELECT A.*,MONTH(A.last_date)AS bulan,YEAR(A.last_date)AS tahun"
      . " ,(SELECT CONCAT(COALESCE(X.name,''),'|',COALESCE(X.category,''),'|',COALESCE(X.unit,'')) FROM site_transport_partner AS X WHERE X.id_site_transport_partner=A.id_site_transport_partner)AS name"
      . " FROM site_transport_komisi_partner AS A"
      . " WHERE A.id_site_transport_komisi='{$pst['id']}' "         
      . " ORDER BY A.create_date ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    $bulan = $this->global_variable->bulan();
    foreach ($data AS $dt){
       
        $unit = $this->global_variable->site_transport_bus_unit();
        if($dt->status == 1){
         $status = "<label class='label label-success'>Post</label>";  
        }else{
         $status = "<label class='label label-warning'>Created</label>";   
        }
        
        $n = explode("|", $dt->name);
        if($n[2]){
            $dt_unit = $n[2];
        }else{
            $dt_unit = 0;
        }
        $awal = "{$dt->tahun}-{$dt->bulan}-01";
        $dcogs = array(1 => "COGS Driver",
              2 => "COGS Helper");
        $vc = $this->global_models->get_query("SELECT SUM(D.nominal) AS total"
              . " FROM site_transport_spj AS A "
              . " LEFT JOIN site_transport_spj_cogs AS B ON A.id_site_transport_spj= B.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_close AS C ON A.id_site_transport_spj = C.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_partner AS D ON D.id_site_transport_spj = A.id_site_transport_spj"
              . " LEFT JOIN site_transport_partner AS E ON D.id_site_transport_partner = E.id_site_transport_partner"
              . " WHERE B.status=3 AND D.id_site_transport_partner ='{$dt->id_site_transport_partner}' AND "
              . " (C.tanggal >= '{$awal}' AND C.tanggal <= '{$dt->last_date}') AND B.type=2 AND B.debit='{$dcogs[$n[1]]}'  "
//              . " GROUP BY D.id_site_transport_komisi_partner"
              );
       
//             print $this->db->last_query();
//              die;
      $button = "";
      $biaya_premi = $vc[0]->total;
      
      if($dt->status_partner == 1){
          if($dt->masuk+$dt->jalan >= 15){
              $biaya_retensi = $dt->biaya_retensi;
          }else{
              $biaya_retensi = 0;
          }
      }else{
          $biaya_retensi = round((($dt->masuk+$dt->jalan)/30)* $dt->biaya_retensi);
      }
      
      $uang_pengganti_transport = $dt->masuk * $dt->uang_pengganti;
      $total_pendapatan = $uang_pengganti_transport+$biaya_retensi+$biaya_premi+$dt->bpjs_kesehatan;
      
      if($dt->npwp == 1){
         $gross =  round($total_pendapatan/(1-0.025));
         $pajak = round((2.5/100)*$gross);
         $denda = "";
      }else{
          $gross = round($total_pendapatan/(1-(0.025*1.2)));
          $pajak = round((2.5/100)*$gross);
          $denda = round((20/100)*$pajak);
      }
      $total_pph = $pajak+$denda;
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $n[0],
            "value"   => $n[0],
          ),
          array(
            "view"    => $unit[$dt_unit],
            "value"   => $unit[$dt_unit],
          ),  
          array(
            "view"    => $status,
            "value"   => $status,
          ),  
          array(
            "view"    => $dt->jalan,
            "value"   => $dt->jalan,
          ),
          array(
            "view"    => $dt->masuk,
            "value"   => $dt->masuk,
          ),
          array(
            "view"    => $dt->off,
            "value"   => $dt->off,
          ),
        array(
            "view"    => ($dt->masuk+$dt->jalan),
            "value"   => ($dt->masuk+$dt->jalan),
          ),
         array(
            "view"    => number_format($uang_pengganti_transport),
            "value"   => number_format($uang_pengganti_transport),
          ),
         array(
            "view"    => number_format($biaya_retensi),
            "value"   => number_format($biaya_retensi),
          ),
          array(
            "view"    => number_format($biaya_premi),
            "value"   => number_format($biaya_premi),
          ),
         array(
            "view"    => number_format($dt->bpjs_kesehatan),
            "value"   => number_format($dt->bpjs_kesehatan),
          ),    
          array(
            "view"    => number_format($biaya_retensi+$dt->bpjs_kesehatan),
            "value"   => number_format($biaya_retensi+$dt->bpjs_kesehatan),
          ), 
         array(
            "view"    => number_format($total_pendapatan),
            "value"   => number_format($total_pendapatan),
          ), 
         array(
            "view"    => number_format($gross),
            "value"   => number_format($gross),
          ),
         array(
            "view"    => number_format($pajak),
            "value"   => number_format($pajak),
          ),
         array(
            "view"    => number_format($denda),
            "value"   => number_format($denda),
          ),
         array(
            "view"    => number_format($total_pph),
            "value"   => number_format($total_pph),
          ),    
        ),
        "select"  => false,
        "id"      => $dt->id_site_transport_komisi_partner
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']   = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  
  function bulanan_get(){
      $pst = $this->input->post();
       $data = $this->global_models->get_query("SELECT A.*"
      . " FROM site_transport_komisi AS A"
      . " WHERE A.tahun='{$pst['id']}'"
      . " ORDER BY A.bulan ASC"
      . " LIMIT {$pst['start']}, 20"
      . "");
    
    $bulan = $this->global_variable->bulan();
    foreach ($data AS $dt){
//      $button = "";
        $button = " <a href='".site_url("hrm/komisi/cetakan-komisi/{$dt->id_site_transport_komisi}")."' class='btn btn-primary btn-sm cetakan-komisi' ><i class='fa fa-print'></i></a> ";
       
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => $bulan[$dt->bulan],
            "value"   => $bulan[$dt->bulan]
          ),
          array(
            "view"    => $button,
            "value"   => $button
          ),  
        ),
        "select"  => false,
        "id"      => $dt->id_site_transport_komisi
      );
    }
    
    if($hasil['data']){
      $hasil['status']  = 2;
      $hasil['start']   = $pst['start'] + 20;
    }
    else
      $hasil['status']  = 3;
    
    print json_encode($hasil);
    die;
  }
  function report_komisi(){
      $pst = $this->input->post();
      
    $this->load->model("hrm/m_report");
    $report = $this->m_report->export_komisi("oke");
    $hasil['status'] = 3;
    $hasil['note'] = "tes";
    print json_encode($hasil);
    die;  
  }
  
  function partner_get_detail(){
    $pst = $this->input->post();
    $data = $this->global_models->get("site_transport_komisi_partner", array("id_site_transport_komisi_partner" => $pst['id']));
    $hasil = array(
      "jalan"                   => $data[0]->jalan,
      "masuk"                   => $data[0]->masuk,
      "off"                     => $data[0]->off,
      "status"                  => 2,  
    );
    print json_encode($hasil);
    die;
  }
  
  function partner_set(){
    $pst = $this->input->post();  
    
    $get = $this->global_models->get("site_transport_komisi_partner",array("id_site_transport_komisi_partner" => "{$pst['id_site_transport_komisi_partner']}"));
    if($get[0]->id_site_transport_komisi_partner){
        if($pst['flag'] == 1 AND $get[0]->status <> 1){
             $kirim = array("status"            => 1,    
                           "update_by_users"    => $this->session->userdata("id"),
                           "update_date"        => date("Y-m-d H:i:s")       
                    );
            $this->global_models->update("site_transport_komisi_partner",array("id_site_transport_komisi_partner" => "{$get[0]->id_site_transport_komisi_partner}"),$kirim);
            $hasil['data'] = $this->_partner_single_record($get[0]->id_site_transport_komisi_partner);
            $hasil['status'] = 2; 
        }else{
            if($get[0]->status == 1){
                $hasil['status'] = 3;
                $hasil['note']   = "Data sudah tidak dapat di update";
            }else{
            $get2 = $this->global_models->get("site_transport_partner",array("id_site_transport_partner" => "{$get[0]->id_site_transport_partner}"));

            $kirim = array("jalan"              => str_replace(",", "", $pst['jalan']),
                           "masuk"              => str_replace(",", "", $pst['masuk']),
                           "off"                => str_replace(",", "", $pst['off']),
                           "biaya_retensi"      => "{$get2[0]->biaya_retensi}",
                           "bpjs_kesehatan"     => "{$get2[0]->bpjs_kesehatan}",
                           "uang_pengganti"     => "{$get2[0]->uang_pengganti}",        
                           "update_by_users"    => $this->session->userdata("id"),
                           "update_date"        => date("Y-m-d H:i:s")       
                    );
            $this->global_models->update("site_transport_komisi_partner",array("id_site_transport_komisi_partner" => "{$get[0]->id_site_transport_komisi_partner}"),$kirim);
            $hasil['data'] = $this->_partner_single_record($get[0]->id_site_transport_komisi_partner);
            $hasil['status'] = 2; 
            }
        }    
     }else{
        $hasil['status'] = 3;
        $hasil['note']   = "Pilih nama Driver/helper yang ingin di update";
    }
    
    print json_encode($hasil);
    die;
  }
  
   function _partner_single_record($id = ""){
    $data = $this->global_models->get_query("SELECT A.*,MONTH(A.last_date)AS bulan,YEAR(A.last_date)AS tahun"
      . " ,(SELECT CONCAT(COALESCE(X.name,''),'|',COALESCE(X.category,''),'|',COALESCE(X.unit,'')) FROM site_transport_partner AS X WHERE X.id_site_transport_partner=A.id_site_transport_partner)AS name"
      . " FROM site_transport_komisi_partner AS A"
      . " WHERE A.id_site_transport_komisi_partner='{$id}' "         
      );
      $bulan = $this->global_variable->bulan();
      $unit = $this->global_variable->site_transport_bus_unit();
      if($data[0]->status == 1){
         $status = "<label class='label label-success'>Post</label>";  
        }else{
         $status = "<label class='label label-warning'>Created</label>";   
        }
        
        $n = explode("|", $data[0]->name);
        $awal = "{$data[0]->tahun}-{$data[0]->bulan}-01";
        $dcogs = array(1 => "COGS Driver",
              2 => "COGS Helper");
        $vc = $this->global_models->get_query("SELECT SUM(D.nominal) AS total"
              . " FROM site_transport_spj AS A "
              . " LEFT JOIN site_transport_spj_cogs AS B ON A.id_site_transport_spj= B.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_close AS C ON A.id_site_transport_spj = C.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_partner AS D ON D.id_site_transport_spj = A.id_site_transport_spj"
              . " LEFT JOIN site_transport_partner AS E ON D.id_site_transport_partner = E.id_site_transport_partner"
              . " WHERE B.status=3 AND D.id_site_transport_partner ='{$data[0]->id_site_transport_partner}' AND "
              . " (C.tanggal >= '{$awal}' AND C.tanggal <= '{$data[0]->last_date}') AND B.debit='{$dcogs[$n[1]]}'  "
//              . " GROUP BY D.id_site_transport_komisi_partner"
              );
       
//             print $this->db->last_query();
//              die;
      $button = "";
      $biaya_premi = $vc[0]->total;
      
      if($data[0]->status_partner == 1){
          if($data[0]->masuk+$data[0]->jalan >= 15){
              $biaya_retensi = $data[0]->biaya_retensi;
          }else{
              $biaya_retensi = 0;
          }
      }else{
          $biaya_retensi = round((($data[0]->masuk+$data[0]->jalan)/30)* $data[0]->biaya_retensi);
      }
      
      $uang_pengganti_transport = $data[0]->masuk * $data[0]->uang_pengganti;
      $total_pendapatan = $uang_pengganti_transport+$biaya_retensi+$biaya_premi+$data[0]->bpjs_kesehatan;
      
      if($data[0]->npwp == 1){
         $gross =  round($total_pendapatan/(1-0.025));
         $pajak = round((2.5/100)*$gross);
         $denda = "";
      }else{
          $gross = round($total_pendapatan/(1-(0.025*1.2)));
          $pajak = round((2.5/100)*$gross);
          $denda = round((20/100)*$pajak);
      }
      $total_pph = $pajak+$denda;
     
    $balik  = array(
        "data"    => array(
          array(
            "view"    => $n[0],
            "value"   => $n[0],
          ),
          array(
            "view"    => $unit[$n[2]],
            "value"   => $unit[$n[2]],
          ),  
          array(
            "view"    => $status,
            "value"   => $status,
          ),  
          array(
            "view"    => $data[0]->jalan,
            "value"   => $data[0]->jalan,
          ),
          array(
            "view"    => $data[0]->masuk,
            "value"   => $data[0]->masuk,
          ),
          array(
            "view"    => $data[0]->off,
            "value"   => $data[0]->off,
          ),
        array(
            "view"    => ($data[0]->masuk+$data[0]->jalan),
            "value"   => ($data[0]->masuk+$data[0]->jalan),
          ),
         array(
            "view"    => number_format($uang_pengganti_transport),
            "value"   => number_format($uang_pengganti_transport),
          ),
         array(
            "view"    => number_format($biaya_retensi),
            "value"   => number_format($biaya_retensi),
          ),
          array(
            "view"    => number_format($biaya_premi),
            "value"   => number_format($biaya_premi),
          ),
         array(
            "view"    => number_format($data[0]->bpjs_kesehatan),
            "value"   => number_format($data[0]->bpjs_kesehatan),
          ),    
          array(
            "view"    => number_format($biaya_retensi+$data[0]->bpjs_kesehatan),
            "value"   => number_format($biaya_retensi+$data[0]->bpjs_kesehatan),
          ), 
         array(
            "view"    => number_format($total_pendapatan),
            "value"   => number_format($total_pendapatan),
          ), 
         array(
            "view"    => number_format($gross),
            "value"   => number_format($gross),
          ),
         array(
            "view"    => number_format($pajak),
            "value"   => number_format($pajak),
          ),
         array(
            "view"    => number_format($denda),
            "value"   => number_format($denda),
          ),
         array(
            "view"    => number_format($total_pph),
            "value"   => number_format($total_pph),
          ),         
        ),
        "select"  => true,
        "id"      => $id,
      );
    return $balik;
  }
}