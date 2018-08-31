<?php
class Global_fungsi{
  function __construct(){
      
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
  
	/**
   * @author Andi Wibowo
   * @param [yy] : tahun
   * @param [mm] : bulan
   * @param [dd] : hari
   * @param [####] : digit angka
   * @param reset : 0 per hari, 1 week, 2 month, 3 year
   * @param no : berapa banyak 0 dibelakang angka
   * @abstract wajib field count 'urut', nomor dengan field 'no'
   * @abstract jika ingin merubah format silahkan disini
   */
  function nomor_format(){
    return array(
      "task"      => array(
        'code'  => "TS-[#####]-[yy][mm][dd]", 
        'no'    => 4,
        'reset' => 0
        ),
      "job_request" => array(
        'code'  => "JR-[yy][mm][dd]-[#####]", 
        'no'    => 4,
        'reset' => 0
        ),
      
      "scm_outlet_mutasi" => array(
        'code'  => "MTS-[#####]", 
        'no'    => 6,
        'reset' => 0
        ),
      "scm_outlet_mutasi_rg" => array(
        'code'  => "MRG-[#####]", 
        'no'    => 6,
        'reset' => 0
        ),
    );
  }
  
  function diskon($persen, $nilai){
    $diskon = $persen/100 * $nilai;
    $hasil = array(
      "diskon"      => $diskon,
      "result"      => ($nilai - $diskon)
    );
    return $hasil;
  }
  
  function time_1day(){
    $day1st   = strtotime("2017-12-25 01:00:00");
    $day12nd  = strtotime("2017-12-26 01:00:00");
    $hasil    = $day12nd - $day1st;
    return $hasil;
  }
  
   function terbilang2($x, $style=3) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $hasil = ucwords(trim($this->kekata($x)));
    }      
    return $hasil;
}

  function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
  
}
?>
