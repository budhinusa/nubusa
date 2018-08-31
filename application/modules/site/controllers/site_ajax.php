<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_ajax extends MX_Controller {
    
  function __construct() {
  }
  
  function html(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://antavaya.com/Flight/Passenger");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $kirim);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    print "<textarea>";
    print $hasil_1;
    print "</textarea>";
  }
  
  function ajax($key){
	  $pst = $this->input->post();
    if($key == "AirportPopular" AND $pst['isOrigin'] == 0){
      $hasil = json_decode('[{"TbsAirportId":3,"AirportCode":"DPS","AirportName":"Ngurah Rai (Bali)","AirportKeyword":"denpasar, ngurah rai, bali","AirportCountry":"","AirportCity":"Denpasar","AirportAddress":"Denpasar","AirportDescription":"Bali","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":1,"AirportCode":"CGK","AirportName":"Soekarno Hatta","AirportKeyword":"tangerang, cengkareng, jakarta, soekarno hatta","AirportCountry":"","AirportCity":"JAKARTA","AirportAddress":"Cengkareng","AirportDescription":"Jakarta","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":7,"AirportCode":"KNO","AirportName":"Kuala Namu Airport","AirportKeyword":"medan, kualanamu","AirportCountry":"","AirportCity":"MEDAN KUALA NAMU","AirportAddress":"Medan","AirportDescription":"Medan","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":6,"AirportCode":"JOG","AirportName":"Adisutjipto Airport","AirportKeyword":"jogjakarta, yogyakarta, adi sucipto","AirportCountry":"","AirportCity":"YOGYAKARTA","AirportAddress":"Jogjakarta","AirportDescription":"Jogjakarta","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":9,"AirportCode":"PDG","AirportName":"Minangkabau International Airport","AirportKeyword":"padang, bandar udara tabing","AirportCountry":"","AirportCity":"PADANG","AirportAddress":"Padang","AirportDescription":"Padang","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":93,"AirportCode":"UPG","AirportName":"Hasanudin Airport","AirportKeyword":"hasanudin, makassar","AirportCountry":"","AirportCity":"MAKASSAR","AirportAddress":"Makassar","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":19,"AirportCode":"BDJ","AirportName":"Syamsudin Noor Airport","AirportKeyword":"syamsudin noor, banjarmasin","AirportCountry":"","AirportCity":"BANJARMASIN","AirportAddress":"Kalimantan","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":5,"AirportCode":"SUB","AirportName":"Juanda Airport","AirportKeyword":"surabaya, juanda","AirportCountry":"","AirportCity":"SURABAYA","AirportAddress":"Surabaya","AirportDescription":"Surabaya","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":62,"AirportCode":"PLM","AirportName":"Mahmud Badaruddin II Airport","AirportKeyword":"sultan mahmud badaruddin II, palembang, sultan mah","AirportCountry":"","AirportCity":"PALEMBANG","AirportAddress":"Palembang","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":526,"AirportCode":"SIN","AirportName":"Changi Intl","AirportKeyword":"Changi Airport Intl, Singapore","AirportCountry":"","AirportCity":"Singapore","AirportAddress":"Singapore","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false}]');
	}
    if($key == "AirportPopular" AND $pst['isOrigin'] == 1){
      $hasil = json_decode('[{"TbsAirportId":1,"AirportCode":"CGK","AirportName":"Soekarno Hatta","AirportKeyword":"tangerang, cengkareng, jakarta, soekarno hatta","AirportCountry":"","AirportCity":"JAKARTA","AirportAddress":"Cengkareng","AirportDescription":"Jakarta","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":3,"AirportCode":"DPS","AirportName":"Ngurah Rai (Bali)","AirportKeyword":"denpasar, ngurah rai, bali","AirportCountry":"","AirportCity":"Denpasar","AirportAddress":"Denpasar","AirportDescription":"Bali","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":7,"AirportCode":"KNO","AirportName":"Kuala Namu Airport","AirportKeyword":"medan, kualanamu","AirportCountry":"","AirportCity":"MEDAN KUALA NAMU","AirportAddress":"Medan","AirportDescription":"Medan","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":6,"AirportCode":"JOG","AirportName":"Adisutjipto Airport","AirportKeyword":"jogjakarta, yogyakarta, adi sucipto","AirportCountry":"","AirportCity":"YOGYAKARTA","AirportAddress":"Jogjakarta","AirportDescription":"Jogjakarta","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":16,"AirportCode":"BPN","AirportName":"Sepingan Airport","AirportKeyword":"sepinggan, balikpapan","AirportCountry":"","AirportCity":"BALIKPAPAN","AirportAddress":"Kalimantan","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":9,"AirportCode":"PDG","AirportName":"Minangkabau International Airport","AirportKeyword":"padang, bandar udara tabing","AirportCountry":"","AirportCity":"PADANG","AirportAddress":"Padang","AirportDescription":"Padang","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":93,"AirportCode":"UPG","AirportName":"Hasanudin Airport","AirportKeyword":"hasanudin, makassar","AirportCountry":"","AirportCity":"MAKASSAR","AirportAddress":"Makassar","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":8,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":21,"AirportCode":"BTH","AirportName":"Hang Nadim Airport","AirportKeyword":"hang nadim, batam","AirportCountry":"","AirportCity":"BATAM","AirportAddress":"Sumatera","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":2,"AirportCode":"HLP","AirportName":"Halim Perdana Kusuma","AirportKeyword":"Jakarta, Halim, Cawang","AirportCountry":"","AirportCity":"Jakarta, Halim","AirportAddress":"Jakarta, Halim, Cawang","AirportDescription":"Jakarta","AirportLatitude":0,"AirportLongitude":0,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false},{"TbsAirportId":62,"AirportCode":"PLM","AirportName":"Mahmud Badaruddin II Airport","AirportKeyword":"sultan mahmud badaruddin II, palembang, sultan mah","AirportCountry":"","AirportCity":"PALEMBANG","AirportAddress":"Palembang","AirportDescription":"","AirportLatitude":-99,"AirportLongitude":-99,"AirportLocale":7,"Version":-99,"CreateDate":"\/Date(-2209014000000)\/","CreateByUserId":-99,"UpdateDate":"\/Date(-2209014000000)\/","UpdateByUserId":-99,"IsActive":false,"IsDeleted":false,"IsNeedApproval":false}]');
    }
    if($key == "AirportByKeyword"){
      $hasil = $this->global_models->get("site_travel_bandara");
    }
	
	print json_encode($hasil);die;
  }
  
  function promo_ticket_get(){
    $pst = $this->input->post();
      
    foreach ($data AS $da){
      $button = ""
        . "<button class='btn btn-success btn-sm location-check' isi='{$da->id_hrm_registrasi}'><i class='fa fa-check'></i></button>"
        . "";
      
      $hasil['data'][] = array(
        "data"    => array(
          array(
            "view"    => 1,
            "value"   => 1
          ),
          array(
            "view"    => $da->nik,
            "value"   => $da->nik
          ),
          array(
            "view"    => $da->name,
            "value"   => $da->name
          ),
          array(
            "view"    => $da->cabang."<br />".$da->department,
            "value"   => $da->cabang."<br />".$da->department,
          ),
          array(
            "view"    => $status[$da->status],
            "value"   => $da->status,
          ),
          array(
            "view"    => $button,
            "value"   => 0
          ),
        ),
        "select"  => false,
        "id"      => $da->id_hrm_registrasi
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
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */