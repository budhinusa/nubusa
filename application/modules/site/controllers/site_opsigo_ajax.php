<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_opsigo_ajax extends MX_Controller {
    
  function __construct() {
    $this->load->model('site/m_site');
  }
  
  function flight_get(){
    $pst = $this->input->post();
    $class_pilih = ($pst['class'] ? $pst['class'] : "fancy-nbs");
    
    $this->load->model("site/m_opsigo");
    $token = $this->m_opsigo->token();
    
    $route = array(
      "origin"      => $pst['asal'],
      "destination" => $pst['tujuan'],
    );
    $pax = array(
      "adult"   => $pst['adl'],
      "child"   => $pst['chd'],
      "infant"  => $pst['inf'],
    );
    if($token['status'] == 2){
      $availability = $this->m_opsigo->availability($token['data']['token'], $route, $pax, 2, $pst['type'], $pst["tgl"]);
    }
//    $this->debug($pst);
//    $this->debug($token);
//    $this->debug($route);
//    $this->debug($pax);
//    $this->debug($availability, true);
    $url = base_url()."themes/antavaya/";
    
    $this->load->model("site/m_sitediscount");
    $this->load->model("site/m_site");
    $payment_channel = $this->m_site->payment_channel_get();
//    foreach ($payment_channel['data'] AS $pc){
//      $whitelist[$pc['id']] = $pc['title'];
//    }
    $discount_depan = $this->m_sitediscount->discount_depan();
//    $this->debug($payment_channel);
//    $this->debug($whitelist);
//    $this->debug($availability, true);
    
    if($availability['status'] == 2){
      foreach ($availability['data'] AS $key => $ava){
        $harga_tampil = 0;
        $flight_info = array();
        $ol = $table_info = "";
        foreach ($ava['flight'] AS $key_av => $av){
          $dari = $this->m_site->bandara_info($av['route']['origin']);
          $ke = $this->m_site->bandara_info($av['route']['destination']);
          if($key_av == 0){
            $awal  = $av['route']['date']['departure'];
            $awal_time  = strtotime($av['route']['date']['departure']);
            
            $ol .= ""
              . "<ol class='list-inline'>"
                . "<li class='flight-logo'>"
                  . "<img style='height: 35px' src='{$av['info']['image']}' alt=''>"
                  . "<div class='caption hidden'>{$av['info']['name']}</div>"
                . "</li>"
                . "<li class='flight-code' data-seat-avail='{$av['class'][0]['seat']}'>"
                  . "{$av['info']['number']} ({$av['class'][0]['code']})"
//                  . "-{$av['class'][0]['seat']}"
                . "</li>"
                . "<li>"
  //                . "<a href='#refund-depart-garuda-7-0' class='flight-label pull-right'><span class='label label-success'>REFUNDABLE</span></a>"
                . "</li>"
              . "</ol>";
                  
            $table_info .= ""
              . "<table class='table table-transparent'>"
                . "<tbody>"
                  . "<tr>"
                    . "<td class='td-flight-takeoff'>"
                      . "<h4 class='sortDepart'>"
                        . "<span class='takeoff'>".date("H:i", strtotime($av['route']['date']['departure']))."</span>"
                        . "<span class='landing'>- ".date("H:i", strtotime($av['route']['date']['arrive']))."</span>"
                      . "</h4>"
                      . "<p class='airport airport-origin-0'>{$dari['city']} ({$av['route']['origin']}) {$dari['title']}</p>"
                      . "<p class='flight-code' data-seat-avail='{$av['class'][0]['seat']}'>{$av['info']['number']}"
//                        . " ({$av['class'][0]['seat']})"
                      . "</p>"
                      . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                    . "</td>"
                    . "<td class='td-flight-landing'>"
                      . "<h4 class='sortReturn'>".date("H:i", strtotime($av['route']['date']['arrive']))."</h4>"
                      . "<p class='airport airport-destination-0'>{$ke['city']} ({$av['route']['destination']}) {$ke['title']} </p>"
                    . "</td>"
                  . "</tr>"
                . "</tbody>"
              . "</table>"
              . "";
          }
          else{
            $table_info .= ""
              . "<table class='table table-transparent'>"
                . "<caption>"
                  . "<ol class='list-inline'>"
                    . "<li class='flight-logo'>"
                      . "<img style='height: 35px' src='{$av['info']['image']}' alt=''>"
                      . "<div class='caption hidden'>{$av['info']['name']}</div>"
                    . "</li>"
                    . "<li class='flight-code' data-seat-avail='{$av['class'][0]['seat']}'>"
                      . "{$av['info']['number']} ({$av['class'][0]['code']})"
                    . "</li>"
                    . "<li>"
  //                    . "<a href='#refund-depart-garuda-7-0' class='flight-label pull-right'><span class='label label-success'>REFUNDABLE</span></a>"
                    . "</li>"
                  . "</ol>"
                . "</caption>"
                . "<tbody>"
                  . "<tr>"
                    . "<td class='td-flight-takeoff'>"
                      . "<h4 class='sortDepart'>"
                        . "<span class='takeoff'>".date("H:i", strtotime($av['route']['date']['departure']))."</span>"
                        . "<span class='landing'>- ".date("H:i", strtotime($av['route']['date']['arrive']))."</span>"
                      . "</h4>"
                      . "<p class='airport airport-origin-1'>{$dari['city']} ({$av['route']['origin']}) {$dari['title']}</p>"
                      . "<p class='flight-code' data-seat-avail='{$av['class'][0]['seat']}'>{$av['info']['number']}</p>"
                      . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                    . "</td>"
                    . "<td class='td-flight-landing'>"
                      . "<h4 class='sortReturn'>".date("H:i", strtotime($av['route']['date']['arrive']))."</h4>"
                      . "<p class='airport airport-destination-0'>{$ke['city']} ({$av['route']['destination']}) {$ke['title']}</p>"
                    . "</td>"
                  . "</tr>"
                . "</tbody>"
              . "</table>";
          }
          $akhir = $av['route']['date']['arrive'];
          $akhir_time  = strtotime($av['route']['date']['arrive']);
          
          $flight_info[$key_av] = array(
            "number"          => $av['info']['number'],
            "flightid"        => $av['info']['id'],
            "class"           => $av['class'][0]['code'],
            "classname"       => $av['class'][0]['category'],
            "classid"         => $av['class'][0]['id'],
            "flightname"      => $av['info']['name'],
            "flightimage"     => $av['info']['image'],
            "flighttypegds"   => $av['info']['type'],
            "departuredate"   => $av['route']['date']['departure'],
            "arrivaldate"     => $av['route']['date']['arrive'],
            "departure"       => $av['route']['origin'],
            "arrival"         => $av['route']['destination'],
            "seat"            => $av['class'][0]['seat'],
            "fare"            => $av['class'][0]['fare'],
            "tax"             => $av['class'][0]['tax'],
            "flightnumber"    => $av['info']['number'],
            "flightclass"     => $av['class'][0]['code'],
            "flighttype"      => $pst['type'],
            "flightdate"      => $av['route']['date']['departure'],
          );
          
          $harga_tampil += $av['info']['fare'];
          
        }
        
        $awal_date  = date_create($awal);
        $akhir_date = date_create($akhir);
        $diff  = date_diff( $awal_date, $akhir_date );
        $selisih['string']  = ($diff->d > 0 ? " {$diff->d}d":"").($diff->h > 0 ? " {$diff->h}h":"").($diff->i > 0 ? " {$diff->i}m":"");
        $selisih['time'] = $akhir_time - $awal_time;
        
        $transit = ($ava['transit'] > 0 ? "{$ava['transit']} ".lang("Transit"): lang("Langsung"));
        
        $flight_info[$key_av]['transit'] = array(
          "transit"     => $ava['transit'],
          "string"      => $transit
        );
        $flight_info[$key_av]['durasi'] = $selisih;
        
        $price  = array(
          'normal'          => number_format($harga_tampil),
        );
        
        foreach ($payment_channel['data'] AS $pc){
          $whitelist[$pc['id']] = $pc['title'];
        }
        if($discount_depan['status'] == 2){
          foreach ($discount_depan['data']['discount'] AS $disc){
            if($disc['is_payment_channel'] == 2){
              $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
            }
            else{
              foreach ($disc['payment_channel'] AS $dpc){
                if($whitelist[$dpc['id']]){
                  $harga_temp = $harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']);
                  $price['tambahan'] .= ""
                    . "<dt>{$whitelist[$dpc['id']]}</dt>"
                    . "<dd>".number_format($harga_temp)."</dd>"
                    . "";
                  unset($whitelist[$dpc['id']]);
                }
              }
            }
          }
        }
        
        $view = <<<EOD
          <div class="panel panel-white panel-flight">
            <div class="panel-heading">
              {$ol}
              <div class="pull-right share">
                <div class="socmed-toggle">
                  <div class="btn-group dropup">
                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                      <div class="dropdown-menu">
                        <ol class="socmed-rounded-sm list-inline">
                          <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/Flight?journey=CGK.SIN&amp;date=23-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=55&amp;y=64" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook"></i></a>
                          </li>
                          <li>
                            <a href="http://twitter.com/home?status=http://antavaya.com/Flight?journey=CGK.SIN&amp;date=23-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=55&amp;y=64" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter"></i></a>
                          </li>
                          <li>
                            <a href="https://plus.google.com/share?url=http://antavaya.com/Flight?journey=CGK.SIN&amp;date=23-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=55&amp;y=64" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus"></i></a>
                          </li>
                        </ol>
                      </div>
                    </div>
                  </div><a href="#socmed-9" class="btn mobile-opt-toggle"><span class="fa fa-share-alt"></span></a>
                </div>
              </div>
              <div class="panel-body">
                <table class="table table-transparent">
                  <tbody>
                    <tr>
                      <td width="40%" class="td-flight-lists">
                        {$table_info}
                      </td>
                      <td width="50%" class="td-flight-prices">
                        <div class="sortPrice hidden">4389660</div>
                        <div class="sortDuration hidden">480</div>
                        <dl class="prices">
                          <dt>Harga</dt>
                          <dd class="large">IDR <span>{$price['normal']}</span></dd>
                          {$price['tambahan']}
                        </dl>
                      </td>
                      <td width="10%" class="td-leave">
                        <input type="image" src="{$url}assets/images/icons/btn-pilih-pergi.png" isitype="{$pst['type']}" isi="{$key}" alt="" class="btn-leave {$class_pilih}">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="panel-footer">
                <ol class="undefined list-inline depart-fitur">
                  <li>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="Tiket kelas EKONOMI">EKONOMI</div>
                  </li>
                  <li>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="">{$transit}</div>
                  </li>
                  <li>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="{$selisih['string']}"> {$selisih['string']} </div>
                  </li>
                  <li>
                    <div data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga barang sudah termasuk bagasi 20 Kg"><span class="fa fa-suitcase"></span> 20 Kg</div>
                  </li>
                  <li>
                    <div data-toggle="tooltip" data-placement="top" title="Harga sudah termasuk makan"><span class="fa fa-cutlery"></span></div>
                  </li>
                </ol>
              </div>
            </div>
EOD;
        
        $hasil['data'][$key] = array(
          "data"    => array(
            array(
              "view"    => $view,
              "value"   => 1
            ),
            array(
              "view"    => "",
              "value"   => $harga_tampil
            ),
            array(
              "view"    => "",
              "value"   => $selisih['time']
            ),
            array(
              "view"    => "",
              "value"   => $awal_time
            ),
            array(
              "view"    => "",
              "value"   => $akhir_time
            ),
          ),
          "select"  => false,
          "id"      => $key
        );
        $hasil['isi'][$key] = array(
          "harga"             => $harga_tampil,
          "flight"            => $flight_info,
        );
      }
    }
    else{
      if($availability['update'] == 1){
        $hasil = array(
          "status"      => 4,
          "requestid"   => $availability["requestid"]
        );
      }
      else{
        $hasil['status'] = 3;
        $hasil['note'] = $availability;
      }
    }
    
    $hasil['debug'] = $availability;
      
    print json_encode($hasil);
    die;
  }
  
  function reservation_available(){
    $pst = $this->input->post();
    
//    $pst = array(
//      "asal"      => "CGK",
//      "tujuan"    => "DPS",
//      "adl"       => 1,
//      "chd"       => 0,
//      "inf"       => 0,
//      "type"      => 2,
//      "tgl"       => "2017-12-27",
//      "flightnumber" => "ID 6196",
//    );
    
    $this->load->model("site/m_opsigo");
    
    $token = $this->m_opsigo->token();
    
    $route = array(
      "origin"      => $pst['asal'],
      "destination" => $pst['tujuan'],
    );
    $route2 = array(
      "destination"      => $pst['asal'],
      "origin" => $pst['tujuan'],
    );
    $pax = array(
      "adult"   => $pst['adl'],
      "child"   => $pst['chd'],
      "infant"  => $pst['inf'],
    );
    $pst['type2'] = ($pst['type2'] ? $pst['type2'] : $pst['type']);
    if($token['status'] == 2){
      if($pst['type'])
        $availability = $this->m_opsigo->availability($token['data']['token'], $route, $pax, 1, $pst['type'], $pst["tgl"]);
      if($pst["return"] AND $pst['type2'])
        $availability2 = $this->m_opsigo->availability($token['data']['token'], $route2, $pax, 1, $pst['type2'], $pst["return"]);
    }
    
    if($availability['status'] == 2 OR $availability2['status'] == 2){
//      if(!$pst['type2'] OR $availability2['status'] == 2){
        $kunci = $kunci2 = array();
        foreach ($availability['data'] AS $data){
          foreach ($data['flight'] AS $flight){
            if($pst['flightnumber'] == $flight['info']['number']){
              $kunci = $data;
              break;
            }
          }
          if($kunci)
            break;
        }

        foreach ($availability2['data'] AS $data2){
          foreach ($data2['flight'] AS $flight2){
            if($pst['flightnumber2'] == $flight2['info']['number']){
              $kunci2 = $data2;
              break;
            }
          }
          if($kunci2)
            break;
        }

        $class = $class2 = array();
        foreach ($kunci['flight'] AS $untuk_flight){
          foreach ($untuk_flight['class'] AS $untuk_class){
            if($untuk_class['seat'] > 1){
              $class[] = array(
                "class"     => $untuk_class,
                "flight"    => $untuk_flight['info'],
                "route"     => $untuk_flight['route']
              );
              break;
            }
          }
        }
        
        foreach ($kunci2['flight'] AS $untuk_flight2){
          foreach ($untuk_flight2['class'] AS $untuk_class2){
            if($untuk_class2['seat'] > 1){
              $class2[] = array(
                "class"     => $untuk_class2,
                "flight"    => $untuk_flight2['info'],
                "route"     => $untuk_flight2['route']
              );
              break;
            }
          }
        }

        $token = $this->m_opsigo->token();

        $route = array(
          "origin"      => $pst['asal'],
          "destination" => $pst['tujuan'],
        );
//        print_r($availability2);
//        print_r($flight2);
//        print_r($class);
//        print_r($class2);
//        die;
        if($token['status'] == 2){
          $reservation = $this->m_opsigo->reservation_update_class($token['data']['token'], $pst['code'], $class, $class2);
        }
        if($reservation['status'] == 2){
          $hasil = array(
            "status"    => 2,
            "flight"    => array(
              $class,
              $class2,
            ),
            "debug"     => $reservation,
          );
        }
        else{
          $hasil = array(
            "status"    => 3,
            "debug"     => $availability
          );
        }
    }
    else{
      $hasil = array(
        "status"    => 5,
      );
    }
//    $this->debug($hasil, true);
    print json_encode($hasil);
    die;
  }
  
  function flight_cek(){
    $pst = $this->input->post();
    
    $requestid = $pst['requestid'];
    $ticket = $this->global_models->get_field("site_ticket_available_progress", "id_site_ticket_available_progress", array("id_site_ticket_available_progress" => $requestid, "issuccess" => 1));
    if($ticket){
      $hasil['status'] = 2;
    }
    else{
      $hasil['status'] = 3;
    }
    
    print json_encode($hasil);
    die;
  }
  
  function reservation_cek(){
    $pst = $this->input->post();
    $this->load->model("site/m_opsigo");
    $reservation = $this->m_opsigo->reservation_cek($pst['code']);
//    $this->debug($reservation, true);
    
    if($reservation['status'] == 2 OR $reservation['status'] == 4){
      $hasil = array(
        "status"      => 2,
        "data"        => array(
          "progress"    => $reservation['progress']
        )
      );
    }
    else{
      $hasil['status'] = 3;
    }
    
    print json_encode($hasil);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */