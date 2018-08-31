<?php
class Global_variable{
  function __construct(){
      
  }
  
  function title_name($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Mr")."</label>",
        2 => "<label class='label label-success'>".lang("Mrs")."</label>",
        3 => "<label class='label label-info'>".lang("Ms")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Mr"),
        2 => lang("Mrs"),
        3 => lang("Ms"),
      );
    }
    return $hasil;
  }
  
  function curl_mentah($pst, $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function dropdown_100(){
    for($r = 0 ; $r <= 100 ; $r++){
      $hasil[$r] = $r;
    }
    return $hasil;
  }
  
  function olah_range_tanggal($tanggal){
    $pisah = explode(" - ", $tanggal);
    
    $hasil[0] = $this->olah_tanggal($pisah[0]);
    $hasil[1] = $this->olah_tanggal($pisah[1]);
      
    return $hasil;
  }
  
  function olah_tanggal_range($tanggal, $tanggal2){
    
    $hasil[0] = $this->olah_tanggal2($tanggal);
    $hasil[1] = $this->olah_tanggal2($tanggal2);
//    print $hasil[0];die;
    return $hasil[0]." - ".$hasil[1];
  }
  
  function olah_tanggal2($tanggal){
    $tex = explode(" ", $tanggal);
    $jam = explode(":", $tex[1]);
    $hasil = date("d/m/Y", strtotime($tex[0]));
    if($jam[0] > 12){
      $jam[0] = $jam[0] - 12;
      $title = "PM";
    }
    else{
      $title = "AM";
    }
    $hasil .= " ".$jam[0].":".$jam[1]." ".$title;
    return $hasil;
  }
  
  function olah_tanggal($tanggal){
    $jam1st = explode(" ", $tanggal);
    $menit1st = explode(":", $jam1st[1]);
    if($jam1st[2] == "PM"){
      $pukul1st = $menit1st[0] + 12;
    }
    else{
      $pukul1st = $menit1st[0];
    }
    $jadi_jam1st = $pukul1st.":".$menit1st[1].":00";
    
    $tanggal1st = explode("/", $jam1st[0]);
    $jadi_tanggal1st = "{$tanggal1st[2]}-{$tanggal1st[1]}-{$tanggal1st[0]}";
    
    return $jadi_tanggal1st." ".$jadi_jam1st;
  }
  
  function hari17($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Senin")."</label>",
        2 => "<label class='label label-primary'>".lang("Selasa")."</label>",
        3 => "<label class='label label-primary'>".lang("Rabu")."</label>",
        4 => "<label class='label label-primary'>".lang("Kamis")."</label>",
        5 => "<label class='label label-primary'>".lang("Jumat")."</label>",
        6 => "<label class='label label-primary'>".lang("Sabtu")."</label>",
        7 => "<label class='label label-primary'>".lang("Minggu")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Senin"),
        2 => lang("Selasa"),
        3 => lang("Rabu"),
        4 => lang("Kamis"),
        5 => lang("Jumat"),
        6 => lang("Sabtu"),
        7 => lang("Minggu"),
      );
    }
    return $hasil;
  }
  
  function status($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-success'>".lang("Enable")."</label>",
        2 => "<label class='label label-danger'>".lang("Disable")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Enable"),
        2 => lang("Disable"),
      );
    }
    return $hasil;
  }
  
  function log_type($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-info'>".lang("Create")."</label>",
        2 => "<label class='label label-warning'>".lang("Update")."</label>",
        3 => "<label class='label label-danger'>".lang("Delete")."</label>",
        4 => "<label class='label label-primary'>".lang("Email")."</label>",
        5 => "<label class='label label-success'>".lang("Reset")."</label>",
      );
    }
    return $hasil;
  }
  /**
   * default
   */
  function status_balik($t = NULL){
    if($t){
      $hasil = array(
        2 => "<label class='label label-success'>".lang("Enable")."</label>",
        1 => "<label class='label label-danger'>".lang("Disable")."</label>",
      );
    }
    else{
      $hasil = array(
        2 => lang("Enable"),
        1 => lang("Disable"),
      );
    }
    return $hasil;
  }
  
  function bulan($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-primary'>".lang("Januari")."</label>",
        2 => "<label class='label label-primary'>".lang("Februari")."</label>",
        3 => "<label class='label label-primary'>".lang("Maret")."</label>",
        4 => "<label class='label label-primary'>".lang("April")."</label>",
        5 => "<label class='label label-primary'>".lang("Mei")."</label>",
        6 => "<label class='label label-primary'>".lang("Juni")."</label>",
        7 => "<label class='label label-primary'>".lang("Juli")."</label>",
        8 => "<label class='label label-primary'>".lang("Agustus")."</label>",
        9 => "<label class='label label-primary'>".lang("September")."</label>",
        10 => "<label class='label label-primary'>".lang("Oktober")."</label>",
        11 => "<label class='label label-primary'>".lang("Nopember")."</label>",
        12 => "<label class='label label-primary'>".lang("Desember")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Januari"),
        2 => lang("Februari"),
        3 => lang("Maret"),
        4 => lang("April"),
        5 => lang("Mei"),
        6 => lang("Juni"),
        7 => lang("Juli"),
        8 => lang("Agustus"),
        9 => lang("September"),
        10 => lang("Oktober"),
        11 => lang("Nopember"),
        12 => lang("Desember"),
      );
    }
    return $hasil;
  }
  
  function nomor_format(){
    return array(
      "frm_journal"      => array(
        'code'  => "FRM-[yy][mm]-[#####]", 
        'no'    => 2,
        'reset' => 0
        ),
      
      "task"      => array(
        'code'  => "TS-[#####]-[yy][mm][dd]", 
        'no'    => 4,
        'reset' => 0
        ),
      "hrm_bs"      => array(
        'code'  => "BS-[yy][mm]-[#####]", 
        'no'    => 5,
        'reset' => 2
        ),
      "hrm_bs_closing" => array(
        'code'  => "BSC-[yy][mm]-[#####]", 
        'no'    => 5,
        'reset' => 2
        ),
      "job_request" => array(
        'code'  => "JR-[yy][mm][dd]-[#####]", 
        'no'    => 4,
        'reset' => 0
        ),
      
      "hrm_attendance_surat_cuti" => array(
        'code'  => "SC-[yy][mm][dd]-[#####]", 
        'no'    => 4,
        'reset' => 0
        ),
				
      "hrm_attendance_surat_cuti_bersama" => array(
        'code'  => "SCB-[yy][mm][dd]-[#####]", 
        'no'    => 4,
        'reset' => 0
        ),
      
      "scm_outlet_mutasi" => array(
        'code'  => "MTS-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "scm_outlet_mutasi_rg" => array(
        'code'  => "MRG-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "scm_procurement_suppliers_hutang" => array(
        'code'  => "APS-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "scm_procurement_request" => array(
        'code'  => "PREQ-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "scm_procurement_request_task" => array(
        'code'  => "TSK-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "scm_procurement_po" => array(
        'code'  => "PO-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      
      "crm_pos_request" => array(
        'code'  => "REQ-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "crm_pos_quotation" => array(
        'code'  => "OF24-[yy]-[#####]", 
        'no'    => 6,
        'reset' => 3
        ),
      "crm_pos_order" => array(
        'code'  => "RS24-[yy]-[#####]", 
        'no'    => 6,
        'reset' => 3
        ),
      
      "crm_payment" => array(
        'code'  => "INV-AVTR-[yy]-[#####]", 
        'no'    => 6,
        'reset' => 3
        ),
      "site_transport_order_payment_spj" => array(
        'code'  => "PSPJ-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "crm_payment_bill" => array(
        'code'  => "PB-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),
      "crm_payment_bill_out" => array(
        'code'  => "PBO-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),

        "crm_payment_refund" => array(
        'code'  => "RF-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),

      "site_transport_spj" => array(
        'code'  => "SPJ-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ),

      "site_umroh_products" => array(
        'code'  => "UMR-[yy][mm]-[#####]", 
        'no'    => 4,
        'reset' => 2
        ),
      "site_umroh_products_schedules" => array(
        'code'  => "SC-[yy][mm]-[#####]", 
        'no'    => 5,
        'reset' => 2
        ),
      "site_transport_po" => array(
        'code'  => "PO-[yy][mm]-[#####]", 
        'no'    => 5,
        'reset' => 2 
        ),
      "site_transport_spj_maintenance" => array(
        'code'  => "SPJM-[yy][mm][dd]-[#####]", 
        'no'    => 6,
        'reset' => 2
        ), 
      
      "site_pameran_ticket_int_book" => array(
        'code'  => "TCK-[yy][mm][dd]-[#####]", 
        'no'    => 3,
        'reset' => 2
        ),
      
      "car_spj"      => array(
        'code'  => "SPJ-[yy][mm]-[#####]", 
        'no'    => 2,
        'reset' => 0
        ),
      
    );
  }
  
  function file_path(){
    return array(
      "hrmdevelopment_job_request" => array(
        "table"         => "hrm_dev_job_request_file",
        "field"         => "title",
        "path"          => "hrm/development/job-request/"
      ),
      "hrmdevelopment_tasks" => array(
        "table"         => "hrm_dev_tasks_file",
        "field"         => "title",
        "path"          => "hrm/development/tasks/"
      ),
      "hrmdevelopment_projects" => array(
        "table"         => "hrm_dev_projects_file",
        "field"         => "title",
        "path"          => "hrm/development/projects/"
      ),
      "hrmemployee_registrasi" => array(
        "table"         => "hrm_registrasi_files",
        "field"         => "file",
        "path"          => "hrm/employee/registrasi/"
      ),
      
      "hrmemployee_employee" => array(
        "table"         => "hrm_employee_biodata",
        "field"         => "avatar",
        "path"          => "hrm/employee/registrasi/"
      ),
      
      "scminventory_brand" => array(
        "table"         => "scm_inventory_brand",
        "field"         => "picture",
        "path"          => "scm/inventory/brand/"
      ),
      "scminventory" => array(
        "table"         => "scm_inventory_file",
        "field"         => "title",
        "path"          => "scm/inventory/master/"
      ),
			"sitetour" => array(
        "table"         => "crm_pos_products_file",
        "field"         => "title",
        "path"          => "sitetour"
      ),
			"site_tour_slideshow" => array(
        "table"         => "site_tour_slideshow",
        "field"         => "file",
        "path"          => "slideshow/"
      ),
			"cms_page" => array(
        "table"         => "cms_page",
        "field"         => "file",
        "path"          => "cms/page/"
      ),
			"cms_article" => array(
        "table"         => "cms_article",
        "field"         => "file",
        "path"          => "cms/article/"
      ),
			"cms_gallery" => array(
        "table"         => "cms_gallery",
        "field"         => "file",
        "path"          => "cms/gallery/"
      ),
      
      "cms_banner_promo" => array(
        "table"         => "cms_banner_promo",
        "field"         => "file",
        "path"          => "cms/banner-promo/"
      ),
			
			"cms_service" => array(
        "table"         => "cms_service",
        "field"         => "file",
        "path"          => "cms/service/"
      ),
        
			"crm_pos_products" => array(
        "table"         => "crm_pos_products_file",
        "field"         => "title",
        "path"          => "crm/pos/products/"
      ),
			
			"crm_pos_products_self" => array(
        "table"         => "crm_pos_products",
        "field"         => "picture",
        "path"          => "crm/pos/products/"
      ),
			
			"siteumroh_product_pic" => array(
        "table"         => "site_umroh_products",
        "field"         => "pic",
        "path"          => "umroh"
      ),
			"siteumroh_product_pic_promo" => array(
        "table"         => "site_umroh_products",
        "field"         => "pic_promo",
        "path"          => "umroh"
      ),
			
			"sitepameran_promo_ticket_sof" => array(
        "table"         => "site_pameran_ticket_int_book_payment",
        "field"         => "sof",
        "path"          => "site/ticket/promo/payment"
      ),
			"sitepameran_promo_ticket_voucher" => array(
        "table"         => "site_pameran_ticket_int_book_payment",
        "field"         => "voucher",
        "path"          => "site/ticket/promo/payment"
      ),
			"sitepameran_promo_ticket_cc_depan" => array(
        "table"         => "site_pameran_ticket_int_book_payment",
        "field"         => "cc_depan",
        "path"          => "site/ticket/promo/payment"
      ),
			"sitepameran_promo_ticket_cc_belakang" => array(
        "table"         => "site_pameran_ticket_int_book_payment",
        "field"         => "cc_belakang",
        "path"          => "site/ticket/promo/payment"
      ),
			"sitepameran_promo_ticket_ktp" => array(
        "table"         => "site_pameran_ticket_int_book_payment",
        "field"         => "ktp",
        "path"          => "site/ticket/promo/payment"
      ),
			
			"hrm_employee_import_log" => array(
        "table"         => "hrm_employee_import_log",
        "field"         => "file",
        "path"          => "import/"
      ),
			
			"hrm_attendance_cuti_import_log" => array(
        "table"         => "hrm_attendance_cuti_import_log",
        "field"         => "file",
        "path"          => "import/"
      ),
      
			"frm_payment_channel" => array(
        "table"         => "crm_payment_channel",
        "field"         => "file",
        "path"          => "frm/payment/channel/"
      ),
      
			"site_ticket_airline" => array(
        "table"         => NULL,
        "field"         => NULL,
        "path"          => "site/ticket/airline/"
      ),
	  
	  		"m_users" => array(
        "table"         => "m_users",
        "field"         => "signature",
        "path"          => "users/signature/",
		"field_id"		=> "id_users"
      ),
	  
	  "crmtrans_import_log" => array(
        "table"         => "crmtrans_import_log",
        "field"         => "file",
        "path"          => "import/"
      ),
		
		"hrm_rec_applicant_file" => array(
        "table"         => "hrm_rec_applicant_file",
        "field"         => "title",
        "path"          => "hrm/recruitment/applicant/"
      ),
		
      "crmtrans_spj" => array(
        "table"         => "site_transport_spj",
        "field"         => "itinerary",
        "path"          => "crm/transport/spj/"
      ),
			
			"hrm_legal_surat_file" => array(
        "table"         => "hrm_legal_surat_file",
        "field"         => "title",
        "path"          => "hrm/archives/surat/legal/"
      ),
			
			"hrm_legal_surat_kuasa_file" => array(
        "table"         => "hrm_legal_surat_kuasa_file",
        "field"         => "title",
        "path"          => "hrm/archives/surat/kuasa/"
      ),
			
			"hrm_legal_surat_direksi_file" => array(
        "table"         => "hrm_legal_surat_direksi_file",
        "field"         => "title",
        "path"          => "hrm/archives/surat/direksi/"
      ),
			
			"hrm_legal_agreement_file" => array(
        "table"         => "hrm_legal_agreement_file",
        "field"         => "title",
        "path"          => "hrm/archives/surat/agreement/"
      ),
			
			"site_umroh_products_schedules_hotel_pictures" => array(
        "table"         => "site_umroh_products_schedules_hotel_pictures",
        "field"         => "title",
        "path"          => "umroh/hotel"
      ),
      
    );
  }
        
  function option($t = NULL){
    if($t){
      $hasil = array(
        1 => "<label class='label label-success'>".lang("Yes")."</label>",
        2 => "<label class='label label-danger'>".lang("No")."</label>",
      );
    }
    else{
      $hasil = array(
        1 => lang("Yes"),
        2 => lang("No"),
      );
    }
    return $hasil;
  }
  
}



?>
