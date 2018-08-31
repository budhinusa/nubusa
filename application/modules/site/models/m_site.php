<?php
class M_site extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function bandara_info($code){
    $data = $this->global_models->get("site_travel_bandara", array("AirportCode" => $code), "nbs", array(), "AirportName, AirportCity");
    $hasil = array(
      "code"        => $code,
      "title"       => $data[0]->AirportName,
      "city"        => $data[0]->AirportCity,
    );
    return $hasil;
  }
  
  function payment_channel_get(){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM crm_payment_channel AS A"
      . " WHERE A.code LIKE '|OTA|'"
      . " AND A.status = 1"
      . " ORDER BY A.urut ASC"
      . "");
    foreach ($data AS $dt){
      $return[] = array(
        "id"          => $dt->id_crm_payment_channel,
        "title"       => $dt->title,
        "code"        => $dt->code,
        "image"       => site_url("file/index/frm-payment-channel/{$dt->id_crm_payment_channel}"),
      );
    }
    $hasil = array(
      "status"  => 2,
      "data"    => $return
    );
    return $hasil;
  }
  
  function limit_flight_get(&$timelimit, &$total, $reservation){
    $airline = array();
    foreach ($reservation['detail']['flight'] AS $flight){
      if(!in_array($flight[0]['airlinecode'], $airline)){
        $total += $flight[0]['total'];
        $airline[] = $flight[0]['airlinecode'];
      }
      foreach ($flight AS $flg){
        if($timelimit){
          if($timelimit > strtotime($flg['timelimit']))
            $timelimit = strtotime($flg['timelimit']);
        }
        else{
          $timelimit = strtotime($flg['timelimit']);
        }
      }
    }
    $duajam = strtotime("+2 hours");
    $sekarang = strtotime("now");
    $hours2 = $duajam - $sekarang;
    
    $batas = strtotime($reservation['detail']['bookers']['date']);
    $max = $batas + $hours2;
    
    $timelimit = ($timelimit > $max ? $max : $timelimit);
    
    return true;
  }
  
}
?>
