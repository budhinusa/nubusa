<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_data_ajax extends MX_Controller {
  
  var $url_garuda     = SERVERGA;
  var $logo_garuda    = "airline-7-GA.png";
    
  function __construct() {
    $this->load->model('site/m_site');
  }
  
  function garuda_book(){
    $pst = $this->input->post();
    
    $kode = $pst['kode'];
    $book         = $this->global_models->get_query("SELECT A.*"
      . " ,B.name, B.email, B.telp"
      . " FROM site_travel_book AS A"
      . " LEFT JOIN crm_customer AS B ON B.id_crm_customer = A.id_crm_customer"
      . " WHERE A.number = '{$kode}'");
    $flight       = $this->global_models->get_query("SELECT A.id_site_travel_book_flight, A.departure, A.arrival, A.departuredate, A.arrivaldate, A.seat, A.sort, A.flightnumber, A.flightclass, A.airline, A.total, A.rincian"
      . " FROM site_travel_book_flight AS A"
      . " WHERE A.id_site_travel_book = '{$book[0]->id_site_travel_book}'"
      . " ORDER BY A.sort ASC");
    $passangers   = $this->global_models->get_query("SELECT A.*"
      . " FROM site_travel_book_passangers AS A"
      . " WHERE A.id_site_travel_book = '{$book[0]->id_site_travel_book}'"
      . " ORDER BY A.type ASC");
      
    foreach ($passangers AS $pax){
      if($pax->type == 1){
        $seat[] = array(
          "type"          => 1,
          "FirstName"     => $pax->firstname,
          "LastName"      => $pax->lastname,
        );
      }
      else if($pax->type == 2){
        $seat[] = array(
          "type"          => 2,
          "FirstName"     => $pax->firstname,
          "LastName"      => $pax->lastname,
          "BirthDate"     => $pax->birthdate,
        );
      }
      else{
        $add[] = array(
          "type"          => 3,
          "FirstName"     => $pax->firstname,
          "LastName"      => $pax->lastname,
          "BirthDate"     => $pax->birthdate,
          "assoc"         => $pax->assoc,
        );
      }
    }
    
    foreach ($flight AS $fl){
      $flight_detail[] = array(
        'departure'       => $fl->departure,
        'arrival'         => $fl->arrival,
        'departuredate'   => date("Y-m-d", strtotime($fl->departuredate)),
        'flightnumber'    => $fl->flightnumber,
        'flightclass'     => $fl->flightclass,
      );
    }
    
    $kirim = array(
      "book"	=> $flight_detail,
      "pesan"	=> array(
        "nama"              => $book[0]->name,
        "telp"              => $book[0]->telp,
        "email"             => $book[0]->email,
      ),
      "pax"	=> array(
        "seat"          => $seat,
        "additional"		=> $add,
      )
    );
    
//    $this->debug($kirim, true);

    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, $this->url_garuda."booking");

    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';

    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch1, CURLOPT_POST, 1);
    curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil = curl_exec($ch1);
    curl_close($ch1);
    $data = json_decode($hasil);

//    $ch1 = curl_init();
//    curl_setopt($ch1, CURLOPT_URL, $this->url_garuda."json/ga/detailserver/");
//
//    $headers = array();
//    $headers[] = 'username: internal';
//    $headers[] = 'sandi: data';
//    $headers[] = 'Content-Type: application/json';
//
//    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);
//
//    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true); 
//    curl_setopt($ch1, CURLOPT_POST, 1);
//    curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($kirim));
//    $hasil = curl_exec($ch1);
//    curl_close($ch1);
//    $data = json_decode($hasil);
//    
//    $this->debug($hasil);
//    $this->debug($data, true);
    
    if($data->status->code == 2){
      $balik = 2;
      foreach ($data->data AS $dt){
        if(!$dt->book->code){
          $balik = 3;
          break;
        }
      }
    }
    else{
      $balik = 3;
    }
    
    if($balik == 2){
      $this->global_models->update("site_travel_book", array("id_site_travel_book" => $book[0]->id_site_travel_book), array("pnrid" => $data->status->id));
    }
    
    print $balik;
    die;
  }
  
  function diskon($persen, $nilai){
    $diskon = $persen/100 * $nilai;
    $hasil = array(
      "diskon"      => $diskon,
      "result"      => ($nilai - $diskon)
    );
    return $hasil;
  }
  
  function garuda_get(){
    $pst = $this->input->post();
    $tanggal = $pst['tgl'];
    $class_pilih = ($pst['class'] ? $pst['class'] : "fancy-nbs");
    
    $kirim = array(
      "DepartureDate"       => $tanggal,
      "Departure"           => $pst['asal'],
      "Arrival"             => $pst['tujuan'],
      "Adult"               => $pst['adl'],
      "Child"               => $pst['chd'],
      "Infant"              => $pst['inf'],
    );
    $bandara = $this->global_models->get("site_travel_bandara", array("status" => 3));
    foreach ($bandara AS $bd){
      $inter[] = $bd->AirportCode;
    }

    if(in_array($pst['asal'], $inter) OR in_array($pst['tujuan'], $inter)){
      $kirim["International"]       = 2;
    }
//    $this->debug($kirim, true);
    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $this->url_garuda."flight-get");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($hasil_1);
//    $this->debug($hasil_1);
//    $this->debug($data);
    $url = base_url()."themes/antavaya/";
    
    foreach($data->data AS $ky => $dt){
      if($dt->harga_tampil > 0){
        $id = "GA{$ky}";
        $ol = $table_info = "";
        $reg = $this->diskon(2, $dt->harga_tampil);
        $inf1 = $this->diskon(2, $dt->harga_tampil);
        $inf2 = $this->diskon(1, $inf1['result']);
        $price  = array(
          'normal'          => number_format($dt->harga_tampil),
          'reguler'         => number_format($reg['result']),
          'infinite'        => number_format($inf2['result']),
        );
        $flight_info = array();
        foreach($dt->role AS $key => $role){
          $flight_info[] = array(
            "number"          => $role->flight,
            "departuredate"   => $role->departure,
            "arrivaldate"     => $role->arrive,
            "departure"       => $role->dari,
            "arrival"         => $role->ke,
            "seat"            => $role->seat,
            "flightnumber"    => $role->book->flightnumber,
            "flightclass"     => $role->book->flightclass,
            "flightdate"      => $role->book->departuredate,
          );

          $dari = $this->m_site->bandara_info($role->dari);
          $ke = $this->m_site->bandara_info($role->ke);

          if($key > 0){
            $akhir = $role->arrive;
            $akhir_time  = strtotime($role->arrive);

            $table_info .= ""
              . "<table class='table table-transparent'>"
                . "<caption>"
                  . "<ol class='list-inline'>"
                    . "<li class='flight-logo'>"
                      . "<img src='{$url}assets/images/icons/{$this->logo_garuda}' alt=''>"
                      . "<div class='caption hidden'>garuda-indonesia</div>"
                    . "</li>"
                    . "<li class='flight-code' data-seat-avail='{$role->seat}'>"
                      . "{$role->flight} ({$role->class})"
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
                        . "<span class='takeoff'>".date("H:i", strtotime($role->departure))."</span>"
                        . "<span class='landing'>- ".date("H:i", strtotime($role->arrive))."</span>"
                      . "</h4>"
                      . "<p class='airport airport-origin-1'>{$dari['city']} ({$dari['code']}) <br />{$dari['title']}</p>"
                      . "<p class='flight-code' data-seat-avail='{$role->seat}'>{$role->flight}</p>"
                      . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                    . "</td>"
                    . "<td class='td-flight-landing'>"
                      . "<h4 class='sortReturn'>".date("H:i", strtotime($role->arrive))."</h4>"
                      . "<p class='airport airport-destination-0'> {$ke['city']} ({$ke['code']}) <br />{$ke['title']} </p>"
                    . "</td>"
                  . "</tr>"
                . "</tbody>"
              . "</table>";
          }
          else{
            $awal  = $role->departure;
            $awal_time  = strtotime($role->departure);
            $akhir = $role->arrive;
            $akhir_time  = strtotime($role->arrive);

            $ol .= ""
              . "<ol class='list-inline'>"
                . "<li class='flight-logo'>"
                  . "<img src='{$url}assets/images/icons/{$this->logo_garuda}' alt=''>"
                  . "<div class='caption hidden'>garuda-indonesia</div>"
                . "</li>"
                . "<li class='flight-code' data-seat-avail='{$role->seat}'>"
                  . "{$role->flight} ({$role->class})"
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
                        . "<span class='takeoff'>".date("H:i", strtotime($role->departure))."</span>"
                        . "<span class='landing'>- ".date("H:i", strtotime($role->arrive))."</span>"
                      . "</h4>"
                      . "<p class='airport airport-origin-0'>{$dari['city']} ({$dari['code']}) <br />{$dari['title']}</p>"
                      . "<p class='flight-code' data-seat-avail='{$role->seat}'>{$role->flight}</p>"
                      . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                    . "</td>"
                    . "<td class='td-flight-landing'>"
                      . "<h4 class='sortReturn'>".date("H:i", strtotime($role->arrive))."</h4>"
                      . "<p class='airport airport-destination-0'> {$ke['city']} ({$ke['code']}) <br />{$ke['title']} </p>"
                    . "</td>"
                  . "</tr>"
                . "</tbody>"
              . "</table>"
              . "";
          }
        }
        $transit = ($dt->stop > 0 ? "{$dt->stop} ".lang("Transit"): lang("Langsung"));
        $awal_date  = date_create($awal);
        $akhir_date = date_create($akhir);
        $diff  = date_diff( $awal_date, $akhir_date );
        $selisih['string']  = ($diff->d > 0 ? " {$diff->d}d":"").($diff->h > 0 ? " {$diff->h}h":"").($diff->i > 0 ? " {$diff->i}m":"");
        $selisih['time'] = $akhir_time - $awal_time;
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
                          <dt>KK Bank Mega</dt>
                          <dd>{$price['reguler']}</dd>
                          <dt>KK Mega Inﬁnite</dt>
                          <dd>{$price['infinite']}</dd>
                        </dl>
                      </td>
                      <td width="10%" class="td-leave">
                        <input type="image" src="{$url}assets/images/icons/btn-pilih-pergi.png" isi="{$ky}" alt="" class="btn-leave {$class_pilih}">
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
        $hasil['data'][$ky] = array(
          "data"    => array(
            array(
              "view"    => $view,
              "value"   => 1
            ),
            array(
              "view"    => "",
              "value"   => $dt->harga_tampil
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
          "id"      => $id
        );
        $hasil['isi'][$ky] = array(
          "harga"             => $dt->total_harga,
          "flight"            => $flight_info,
        );
      }
    }
    $hasil['status']  = 2;
    print json_encode($hasil);
    die;
  }
  
  function garuda_get_faredetail(){
    $pst = $this->input->post();
//    $tanggal = $pst['tgl'];
    $class_pilih = ($pst['class'] ? $pst['class'] : "fancy-nbs");
    $ky = $pst['key'];
    $url = base_url()."themes/antavaya/";
//    $this->debug(json_decode($pst['data']), true);
    $data = json_decode($pst['data']);
//    $this->debug($data, true);
    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';
    
    $flight = array();
    foreach ($data->Flight AS $flg){
      $flight[] = array(
        "class"         => $flg->Class,
        "departuredate"	=> $flg->DepartureDate,
        "arrivaldate"   => $flg->ArrivalDate,
        "departure"     => $flg->Departure,
        "arrival"       => $flg->Arrival,
        "number"        => $flg->Number,
      );
    }
    
    $kirim = array(
      "pax"       	=> array(
        "adult"			=> $pst['adl'],
        "child"			=> $pst['chd'],
        "infant"		=> $pst['inf'],
      ),
      "flight"        => $flight,
    );
    if($pst['reqtxnid']){
      $kirim['ReqTxnID'] = $pst['reqtxnid'];
      $kirim['SessionId'] = $pst['sessionid'];
      $kirim['SequenceNumber'] = $pst['sequencenumber'];
      $kirim['SecurityToken'] = $pst['securitytoken'];
    }
//$this->debug(SERVERGA."json/ga/faredetails");
//$this->debug($kirim, true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, SERVERGA."faredetails");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($hasil_1);
    
//    $this->debug($hasil_1);
//    $this->debug($data, true);
    
//    if($dt->harga_tampil > 0){
    $id = "GA{$pst['key']}";
    $ol = $table_info = "";
    $reg = $this->diskon(2, $data->data[0]->harga_tampil);
    $inf2 = $this->diskon(1, $reg['result']);
    $price  = array(
      'normal'          => number_format($data->data[0]->harga_tampil),
      'reguler'         => number_format($reg['result']),
      'infinite'        => number_format($inf2['result']),
    );
    $flight_info = array();
    foreach($data->data[0]->role AS $key => $role){
      $flight_info[] = array(
        "number"          => $role->flight,
        "departuredate"   => $role->departure,
        "arrivaldate"     => $role->arrive,
        "departure"       => $role->dari,
        "arrival"         => $role->ke,
        "seat"            => $role->seat,
        "flightnumber"    => $role->book->flightnumber,
        "flightclass"     => $role->book->flightclass,
        "flightdate"      => $role->book->departuredate,
      );

      $dari = $this->m_site->bandara_info($role->dari);
      $ke = $this->m_site->bandara_info($role->ke);

      if($key > 0){
        $akhir = $role->arrive;
        $akhir_time  = strtotime($role->arrive);

        $table_info .= ""
          . "<table class='table table-transparent'>"
            . "<caption>"
              . "<ol class='list-inline'>"
                . "<li class='flight-logo'>"
                  . "<img src='{$url}assets/images/icons/{$this->logo_garuda}' alt=''>"
                  . "<div class='caption hidden'>garuda-indonesia</div>"
                . "</li>"
                . "<li class='flight-code' data-seat-avail='{$role->seat}'>"
                  . "{$role->flight} ({$role->class})"
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
                    . "<span class='takeoff'>".date("H:i", strtotime($role->departure))."</span>"
                    . "<span class='landing'>- ".date("H:i", strtotime($role->arrive))."</span>"
                  . "</h4>"
                  . "<p class='airport airport-origin-1'>{$dari['city']} ({$dari['code']}) <br />{$dari['title']}</p>"
                  . "<p class='flight-code' data-seat-avail='{$role->seat}'>{$role->flight}</p>"
                  . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                . "</td>"
                . "<td class='td-flight-landing'>"
                  . "<h4 class='sortReturn'>".date("H:i", strtotime($role->arrive))."</h4>"
                  . "<p class='airport airport-destination-0'> {$ke['city']} ({$ke['code']}) <br />{$ke['title']} </p>"
                . "</td>"
              . "</tr>"
            . "</tbody>"
          . "</table>";
      }
      else{
        $awal  = $role->departure;
        $awal_time  = strtotime($role->departure);
        $akhir = $role->arrive;
        $akhir_time  = strtotime($role->arrive);

        $ol .= ""
          . "<ol class='list-inline'>"
            . "<li class='flight-logo'>"
              . "<img src='{$url}assets/images/icons/{$this->logo_garuda}' alt=''>"
              . "<div class='caption hidden'>garuda-indonesia</div>"
            . "</li>"
            . "<li class='flight-code' data-seat-avail='{$role->seat}'>"
              . "{$role->flight} ({$role->class})"
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
                    . "<span class='takeoff'>".date("H:i", strtotime($role->departure))."</span>"
                    . "<span class='landing'>- ".date("H:i", strtotime($role->arrive))."</span>"
                  . "</h4>"
                  . "<p class='airport airport-origin-0'>{$dari['city']} ({$dari['code']}) <br />{$dari['title']}</p>"
                  . "<p class='flight-code' data-seat-avail='{$role->seat}'>{$role->flight}</p>"
                  . "<a href='#m-detail-2-10' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                . "</td>"
                . "<td class='td-flight-landing'>"
                  . "<h4 class='sortReturn'>".date("H:i", strtotime($role->arrive))."</h4>"
                  . "<p class='airport airport-destination-0'> {$ke['city']} ({$ke['code']}) <br />{$ke['title']} </p>"
                . "</td>"
              . "</tr>"
            . "</tbody>"
          . "</table>"
          . "";
      }
    }
    $transit = ($data->data[0]->stop > 0 ? "{$data->data[0]->stop} ".lang("Transit"): lang("Langsung"));
    $awal_date  = date_create($awal);
    $akhir_date = date_create($akhir);
    $diff  = date_diff( $awal_date, $akhir_date );
    $selisih['string']  = ($diff->d > 0 ? " {$diff->d}d":"").($diff->h > 0 ? " {$diff->h}h":"").($diff->i > 0 ? " {$diff->i}m":"");
    $selisih['time'] = $akhir_time - $awal_time;
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
                          <dt>KK Bank Mega</dt>
                          <dd>{$price['reguler']}</dd>
                          <dt>KK Mega Inﬁnite</dt>
                          <dd>{$price['infinite']}</dd>
                        </dl>
                      </td>
                      <td width="10%" class="td-leave">
                        <input type="image" src="{$url}assets/images/icons/btn-pilih-pergi.png" isi="{$ky}" alt="" class="btn-leave {$class_pilih}">
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
    $hasil['data'] = array(
      "data"    => array(
        array(
          "view"    => $view,
          "value"   => 1
        ),
        array(
          "view"    => "",
          "value"   => $data->data[0]->harga_tampil
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
      "id"      => $id
    );
    $hasil['isi'] = array(
      "harga"             => $data->data[0]->total_harga,
      "flight"            => $flight_info,
    );
    $hasil['status']          = $data->status->code;
    $hasil['ReqTxnID']        = $data->status->session->ReqTxnID;
    $hasil['SessionId']       = $data->status->session->SessionId;
    $hasil['SequenceNumber']  = $data->status->session->SequenceNumber;
    $hasil['SecurityToken']   = $data->status->session->SecurityToken;
//    $hasil['debug']  = $data;
    print json_encode($hasil);
    die;
  }
  
  function ga_logout(){
    $pst = $this->input->post();
//    $tanggal = $pst['tgl'];
    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';
    
    $kirim['ReqTxnID'] = $pst['reqtxnid'];
    $kirim['SessionId'] = $pst['sessionid'];
    $kirim['SequenceNumber'] = $pst['sequencenumber'];
    $kirim['SecurityToken'] = $pst['securitytoken'];
//$this->debug(SERVERGA."json/ga/faredetails");
//$this->debug($kirim, true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, SERVERGA."logout");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($hasil_1);
    
    print "done";
    die;
  }
  
  function garuda_get_availability(){
    $pst = $this->input->post();
    $tanggal = $pst['tgl'];
    
    $kirim = array(
      "DepartureDate"       => $tanggal,
      "Departure"           => $pst['asal'],
      "Arrival"             => $pst['tujuan'],
      "Adult"               => $pst['adl'],
      "Child"               => $pst['chd'],
      "Infant"              => $pst['inf'],
    );
    $bandara = $this->global_models->get("site_travel_bandara", array("status" => 3));
    foreach ($bandara AS $bd){
      $inter[] = $bd->AirportCode;
    }

    if(in_array($pst['asal'], $inter) OR in_array($pst['tujuan'], $inter)){
      $kirim["International"]       = 2;
    }
//    $this->debug($kirim, true);
    
    if($pst['reqtxnid']){
      $kirim['ReqTxnID'] = $pst['reqtxnid'];
      $kirim['SessionId'] = $pst['sessionid'];
      $kirim['SequenceNumber'] = $pst['sequencenumber'];
      $kirim['SecurityToken'] = $pst['securitytoken'];
    }
    
    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $this->url_garuda."flight-availability/{$pst['class_flight']}");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($hasil_1);
//    $this->debug($this->url_garuda."flight-availability/{$pst['class_flight']}");
//    $this->debug($data, true);
    
    foreach ($data->data AS $dt){
      $flight = array();
      foreach ($dt->Flight AS $fl){
        $flight[] = array(
          "DepartureDate"   => "{$fl->DepartureDate} {$fl->DepartureTime}",
          "ArrivalDate"     => "{$fl->ArrivalDate} {$fl->ArrivalTime}",
          "Departure"       => $fl->Departure,
          "Arrival"         => $fl->Arrival,
          "Number"          => $fl->Number,
          "Class"           => $fl->Class[0]->serviceClass,
          "Seat"            => $fl->Class[0]->availabilityStatus,
        );
      }
      $isi[] = array(
        "Departure"       => $dt->Departure,
        "Arrival"         => $dt->Arrival,
        "Stop"            => $dt->Stop,
        "Connection"      => $dt->Connection,
        "Flight"          => $flight,
      );
    }
    
    if($data->status->code == 2){
      $hasil['status']          = 2;
      $hasil['isi']             = $isi;
      $hasil['ReqTxnID']        = $data->status->session->ReqTxnID;
      $hasil['SessionId']       = $data->status->session->SessionId;
      $hasil['SequenceNumber']  = $data->status->session->SequenceNumber;
      $hasil['SecurityToken']   = $data->status->session->SecurityToken;
//      $this->debug($hasil, true);
    }
    else{
      $hasil['status']  = 3;
      $hasil['data']  = $data;
    }
    
    print json_encode($hasil);
    die;
  }
  
  function one_way_popup(){
    $url = base_url()."themes/antavaya/";
    $pst = $this->input->post();
    
    $paket = json_decode($pst['paket']);
    $hari = $this->global_variable->hari17();
    
    $form = ""
      . "{$this->form_eksternal->form_input('adult', $pst['adult'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('child', $pst['child'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('infant', $pst['infant'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_departure', $pst['awal_departure'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_arrival', $pst['awal_arrival'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_departuredate', $pst['awal_departuredate'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_returndate', $pst['awal_returndate'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('type', $pst['type'], "style='display: none'")}"
      . "";
    $terbang = "";
    foreach ($paket->flight AS $flight){
      $departuredate = strtotime($flight->departuredate);
      $arrivaldate = strtotime($flight->arrivaldate);
      $info['departure'] = $this->m_site->bandara_info($flight->departure);
      $info['arrival'] = $this->m_site->bandara_info($flight->arrival);
      $terbang .= ""
        . "<tr>"
          . "<td class='td-plane'>"
            . "<figure><img id='popup-iconmaskapai-pergi' src='{$flight->flightimage}' style='height: 30px' alt='' class='plane-logo'></figure>"
            . "<p class='plane-name'>{$flight->flightname}</p>"
            . "<p id='popup-codemaskapai-pergi' class='plane-code'>{$flight->number}</p>"
          . "</td>"
          . "<td class='td-takeoff'>"
            . "<h4 id='popup-departtime-pergi' class='takeoff-time'>".date("H:i", $departuredate)."</h4>"
            . "<p id='popup-origin-pergi' class='takeoff-port'>{$info['departure']['city']} ({$info['departure']['code']})</p>"
          . "</td>"
          . "<td class='arrow'>"
            . "<img src='{$url}assets/images/icons/arrow-blue-right.png' alt=''>"
          . "</td>"
          . "<td class='td-landing'>"
            . "<h4 id='popup-arrivetime-pergi' class='landing-time'>".date("H:i", $arrivaldate)."</h4>"
            . "<p id='popup-destination-pergi' class='landing-port'>{$info['arrival']['city']} ({$info['arrival']['code']})</p>"
          . "</td>"
        . "</tr>"
        . "";
            
      $form .= ""
        . "{$this->form_eksternal->form_input('departure[]', $flight->departure, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrival[]', $flight->arrival, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('departuredate[]', $flight->departuredate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrivaldate[]', $flight->arrivaldate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('seat[]', $flight->seat, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightnumber[]', $flight->flightnumber, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightclass[]', $flight->flightclass, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightimage[]', $flight->flightimage, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightname[]', $flight->flightname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classname[]', $flight->classname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classid[]', $flight->classid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightid[]', $flight->flightid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttype[]', $flight->flighttype, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttypegds[]', $flight->flighttypegds, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('fare[]', $flight->fare, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('tax[]', $flight->tax, "style='display: none'")}"
        . "";
    }
    
    $firstdeparture = strtotime($paket->flight[0]->departuredate);
    
    $this->load->model("site/m_sitediscount");
    $this->load->model("site/m_site");
    $payment_channel = $this->m_site->payment_channel_get();
    $discount_depan = $this->m_sitediscount->discount_depan();
    foreach ($payment_channel['data'] AS $pc){
      $whitelist[$pc['id']] = array(
        "title" => $pc['title'],
        "image" => $pc['image']
      );
    }
    
    $total = $harga_tampil = $price['normal'] = $paket->harga;
//    $this->debug($harga_tampil);
//    $this->debug($payment_channel);
//    $this->debug($discount_depan);
    if($discount_depan['status'] == 2){
      foreach ($discount_depan['data']['discount'] AS $disc){
        if($disc['is_payment_channel'] == 2){
          $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
        }
        else{
          foreach ($disc['payment_channel'] AS $dpc){
            if($whitelist[$dpc['id']]){
              $harga_discount = ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']);
              $harga_temp = $harga_tampil - $harga_discount;
              $penawaran .= ""
                . "<section class='card'>"
                  . "<div class='media'>"
                    . "<div class='media-left media-top'>"
                      . "<img style='width: 43px' src='{$whitelist[$dpc['id']]['image']}' alt=''>"
                    . "</div>"
                    . "<div class='media-body media-top'>"
                      . "<small>{$disc['title']}</small>"
                    . "</div>"
                  . "</div>"
                  . "<h4 class='popup-harga-final-dm'>IDR ".number_format($harga_temp)."<br><small class='text-danger'>Anda hemat IDR ".number_format($harga_discount)."</small></h4>"
                . "</section>"
                . "";
              unset($whitelist[$dpc['id']]);
            }
          }
        }
      }
    }
//    $this->debug($penawaran, true);
    $html = ""
      . "<div class='panel-heading'>"
        . "<h3 class='panel-title'>Rincian Penerbangan Pergi</h3>"
      . "</div>"
      . "<div class='panel-body'>"
        . "<section id='result-depart-popup'>"
          . "<div class='row'>"
            . "<div class='col-md-3'>"
              . "<p class='title m-0'>Pergi</p>"
              . "<p class='date'>{$hari[date("N", $firstdeparture)]}, ".date("d F Y", $firstdeparture)."</p>"
              . "<p class='total'>{$pst['adult']} Dewasa</p>"
              . "<p class='total'>{$pst['child']} Anak</p>"
              . "<p class='total'>{$pst['infant']} Bayi</p>"
            . "</div>"
            . "<div class='col-md-6 popup-depart-flightdetail' id=''>"
              . "<table class='table table-transparent'>"
                . "<tbody>"
                  . "{$terbang}"
                . "</tbody>"
              . "</table>"
            . "</div>"
            . "<div class='col-md-3 item text-right'>"
//              . "<s class='price-b4 popup-harga-pergi-d'>IDR 519,200</s>"
              . "<h4 class='m-0 price-new popup-harga-pergi-v' id=''>IDR ".  number_format($price['normal'])."</h4>"
            . "</div>"
          . "</div>"
          . "<footer class='detail-descript'>"
            . "<ol class='undefined list-inline popup-depart-fitur' id=''>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Tiket kelas EKONOMI'>{$paket->flight[0]->classname}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title=''>{$paket->flight[0]->transit->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Durasi 1 jam 50 menit'>{$paket->flight[0]->durasi->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Harga barang sudah termasuk bagasi 20 Kg'>"
                  . "<span class='fa fa-suitcase'></span> 20 Kg"
                . "</div>"
              . "</li>"
            . "</ol>"
          . "</footer>"
        . "</section>"
      . "</div>"
      . "<div class='panel-footer'>"
        . "<div class='row'>"
          . "<div class='col-sm-6 cards'>"
            . "{$penawaran}"
          . "</div>"
          . "<div class='col-sm-6 text-right'>"
            . "<section class='price-total'>"
              . "<p class='pull-left m-0'>Total Harga</p>"
              . "<h3 class='popup-harga-final-d'>IDR ".number_format($total)."</h3>"
              . "<p class='text-muted'><small><em>Termasuk semua pajak &amp; biaya penerbangan</em></small></p>"
            . "</section>"
          . "</div>"
          . "<div class='col-sm-12 text-right plan-submit'>"
            . "<form method='POST' action='".site_url("site/book")."'>"
              . "{$form}"
              . "<input type='submit' value='' id='submit-flight-mobile' class='sprites sprites-btn-pesan-lg'>"
            . "</form>"
          . "</div>"
        . "</div>"
      . "</div>";
    
    print $html;die;
  }
  function round_trip_detail_pergi(){
    $url = base_url()."themes/antavaya/";
    $pst = $this->input->post();
    
    $paket = json_decode($pst['paket']);
    $hari = $this->global_variable->hari17();
//    $this->debug($paket, true);
    
    $tablekedua = "";
    if($paket->flight[1]){
      for($tr = 1 ; $tr < count($paket->flight) ; $tr++){
        $info['departure'] = $this->m_site->bandara_info($paket->flight[$tr]->departure);
        $info['arrival'] = $this->m_site->bandara_info($paket->flight[$tr]->arrival);
        $departuretime = strtotime($paket->flight[$tr]->departuredate);
        $arrivaltime = strtotime($paket->flight[$tr]->arrivaldate);
        
        $akhir = $paket->flight[$tr]->arrivaldate;
        
        $tablekedua = ""
          . "<table class='table table-transparent'>"
            . "<caption>"
              . "<ol class='list-inline'>"
                . "<li class='flight-logo'>"
                  . "<img src='{$paket->flight[$tr]->flightimage}' alt='' style='height: 30px'>"
                  . "<div class='caption hidden'>{$paket->flight[$tr]->flightname}</div>"
                . "</li>"
                . "<li class='flight-code' data-seat-avail='6'>{$paket->flight[$tr]->number}</li>"
              . "</ol>"
            . "</caption>"
            . "<tbody>"
              . "<tr>"
                . "<td class='td-flight-takeoff'>"
                  . "<h4 class='sortDepart'><span class='takeoff'>".date("H:i", $departuretime)." </span><span class='landing'>- ".date("H:i", $arrivaltime)."</span></h4>"
                  . "<p class='airport airport-origin-1'>{$info["departure"]['city']} ({$info["departure"]['code']})</p>"
                  . "<p class='flight-code' data-seat-avail='6'>{$paket->flight[$tr]->number}</p>"
                  . "<a href='#m-detail-4-1' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                . "</td>"
                . "<td class='td-flight-landing'>"
                  . "<h4 class='sortReturn'>".date("H:i", $arrivaltime)."</h4>"
                  . "<p class='airport airport-destination-1'>{$info["arrival"]['city']} ({$info["arrival"]['code']})</p>"
                . "</td>"
              . "</tr>"
            . "</tbody>"
          . "</table>"
          . "";
      }
    }
    
    $awal = $paket->flight[0]->departuredate;
    
    $info['departure'] = $this->m_site->bandara_info($paket->flight[0]->departure);
    $info['arrival'] = $this->m_site->bandara_info($paket->flight[0]->arrival);
    $departuretime = strtotime($paket->flight[0]->departuredate);
    $arrivaltime = strtotime($paket->flight[0]->arrivaldate);
    
    $reg = $this->diskon(2, $paket->harga);
    $inf = $this->diskon(1, $reg['result']);
    
    $awal_date  = date_create($awal);
    $akhir_date = date_create($akhir);
    $diff  = date_diff( $awal_date, $akhir_date );
    $selisih['string']  = ($diff->d > 0 ? " {$diff->d}d":"").($diff->h > 0 ? " {$diff->h}h":"").($diff->i > 0 ? " {$diff->i}m":"");
    
    $html = ""
        . "<div class='panel-heading'>"
          . "<ol class='list-inline'>"
            . "<li class='flight-logo'>"
              . "<img src='{$paket->flight[0]->flightimage}' style='height: 30px' alt=''>"
              . "<div class='caption hidden'>{$paket->flight[$tr]->flightname}</div>"
            . "</li>"
            . "<li class='flight-code' data-seat-avail='6'>{$paket->flight[0]->number}</li>"
          . "</ol>"
          . "<div class='pull-right share'>"
            . "<div class='socmed-toggle'>"
              . "<div class='btn-group dropup'>"
                . "<div data-toggle='dropdown' class='btn dropdown-toggle'><span class='fa fa-share-alt'></span>"
              . "</div>"
              . "<div class='dropdown-menu'>"
                . "<ol class='socmed-rounded-sm list-inline'>"
                  . "<li><a href='https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/Flight?journey=PLM.DPS&amp;date=29-03-2017.18-04-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=60&amp;y=40' onclick='window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;'><i class='sprites sprites-facebook'></i></a></li>"
                  . "<li><a href='http://twitter.com/home?status=http://antavaya.com/Flight?journey=PLM.DPS&amp;date=29-03-2017.18-04-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=60&amp;y=40' onclick='window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;'><i class='sprites sprites-twitter'></i></a></li>"
                  . "<li><a href='https://plus.google.com/share?url=http://antavaya.com/Flight?journey=PLM.DPS&amp;date=29-03-2017.18-04-2017&amp;psgr=1.0.0&amp;ct=EKONOMI&amp;x=60&amp;y=40' onclick='window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;'><i class='sprites sprites-google-plus'></i></a></li>"
                . "</ol>"
              . "</div>"
            . "</div>"
          . "</div>"
          . "<a href='#socmed-0' class='btn mobile-opt-toggle'><span class='fa fa-share-alt'></span></a>"
        . "</div>"
      . "</div>"
      . "<div class='panel-body'>"
        . "<table class='table table-transparent'>"
          . "<tbody>"
            . "<tr>"
              . "<td width='40%' class='td-flight-lists'>"
                . "<table class='table table-transparent'>"
                  . "<tbody>"
                    . "<tr>"
                      . "<td class='td-flight-takeoff'>"
                        . "<h4 class='sortDepart'><span class='takeoff'>".date("H:i", $departuretime)." </span><span class='landing'>- ".date("H:i", $arrivaltime)."</span></h4>"
                        . "<p class='airport airport-origin-0'>{$info['departure']['city']} ({$info['departure']['code']})</p>"
                        . "<p class='flight-code' data-seat-avail='6'>{$paket->flight[0]->number}</p>"
                        . "<a href='#m-detail-4-1' class='mobile-opt-toggle btn-detail'>Lihat Detil</a>"
                      . "</td>"
                      . "<td class='td-flight-landing'>"
                        . "<h4 class='sortReturn'>".date("H:i", $arrivaltime)."</h4>"
                        . "<p class='airport airport-destination-0'>{$info['arrival']['city']} ({$info['arrival']['code']})</p>"
                      . "</td>"
                    . "</tr>"
                  . "</tbody>"
                . "</table>"
                . "{$tablekedua}"
              . "</td>"
              . "<td width='50%' class='td-flight-prices'>"
                . "<div class='sortPrice hidden'>1166614.02</div>"
                . "<div class='sortDuration hidden'>435</div>"
                . "<dl class='prices'>"
                  . "<dt>Harga</dt>"
                    . "<dd class='large'>IDR <span>".number_format($paket->harga)."</span></dd>"
                  . "<dt>KK Bank Mega</dt>"
                    . "<dd>".number_format($reg['result'])."</dd>"
                  . "<dt>KK Mega Inﬁnite</dt>"
                    . "<dd>".number_format($inf['result'])."</dd>"
                . "</dl>"
              . "</td>"
              . "<td width='10%' class='td-leave'>"
                . "<input type='image' src='{$url}assets/images/icons/btn-pilih-pergi.png' alt='' class='btn-leave select-pergi'>"
              . "</td>"
            . "</tr>"
          . "</tbody>"
        . "</table>"
      . "</div>"
      . "<div class='panel-footer'>"
        . "<ol class='undefined list-inline depart-fitur'>"
          . "<li>"
            . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Tiket kelas EKONOMI'>{$paket->flight[0]->classname}</div>"
          . "</li>"
          . "<li>"
            . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title=''>{$paket->flight[(count($paket->flight) - 1)]->transit->string}</div>"
          . "</li>"
          . "<li>"
            . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Durasi 7 jam 15 menit'>{$paket->flight[(count($paket->flight) - 1)]->durasi->string}</div>"
          . "</li>"
          . "<li>"
            . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Harga barang sudah termasuk bagasi 20 Kg'><span class='fa fa-suitcase'></span> 20 Kg</div>"
          . "</li>"
        . "</ol>"
      . "</div>"
      . "";
    
    print $html;die;
  }
  
  function round_trip_popup(){
    $url = base_url()."themes/antavaya/";
    $pst = $this->input->post();
    
    $paket = json_decode($pst['paket']);
    $paket2 = json_decode($pst['paket2']);
    $hari = $this->global_variable->hari17();
    
    $form = ""
      . "{$this->form_eksternal->form_input('adult', $pst['adult'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('child', $pst['child'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('infant', $pst['infant'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_departure', $pst['awal_departure'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_arrival', $pst['awal_arrival'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_departuredate', $pst['awal_departuredate'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('awal_returndate', $pst['awal_returndate'], "style='display: none'")}"
      . "{$this->form_eksternal->form_input('type', $pst['type'], "style='display: none'")}"
      . "";
    $terbang = $terbang2 = "";
    foreach ($paket->flight AS $flight){
      $departuredate = strtotime($flight->departuredate);
      $arrivaldate = strtotime($flight->arrivaldate);
      $info['departure'] = $this->m_site->bandara_info($flight->departure);
      $info['arrival'] = $this->m_site->bandara_info($flight->arrival);
      $terbang .= ""
        . "<tr>"
          . "<td class='td-plane'>"
            . "<figure><img id='popup-iconmaskapai-pergi' src='{$flight->flightimage}' style='height: 30px' alt='' class='plane-logo'></figure>"
            . "<p class='plane-name'>{$flight->flightname}</p>"
            . "<p id='popup-codemaskapai-pergi' class='plane-code'>{$flight->number}</p>"
          . "</td>"
          . "<td class='td-takeoff'>"
            . "<h4 id='popup-departtime-pergi' class='takeoff-time'>".date("H:i", $departuredate)."</h4>"
            . "<p id='popup-origin-pergi' class='takeoff-port'>{$info['departure']['city']} ({$info['departure']['code']})</p>"
          . "</td>"
          . "<td class='arrow'>"
            . "<img src='{$url}assets/images/icons/arrow-blue-right.png' alt=''>"
          . "</td>"
          . "<td class='td-landing'>"
            . "<h4 id='popup-arrivetime-pergi' class='landing-time'>".date("H:i", $arrivaldate)."</h4>"
            . "<p id='popup-destination-pergi' class='landing-port'>{$info['arrival']['city']} ({$info['arrival']['code']})</p>"
          . "</td>"
        . "</tr>"
        . "";
            
      $form .= ""
        . "{$this->form_eksternal->form_input('departure[]', $flight->departure, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrival[]', $flight->arrival, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('departuredate[]', $flight->departuredate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrivaldate[]', $flight->arrivaldate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('seat[]', $flight->seat, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightnumber[]', $flight->flightnumber, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightclass[]', $flight->flightclass, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightimage[]', $flight->flightimage, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightname[]', $flight->flightname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classname[]', $flight->classname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classid[]', $flight->classid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightid[]', $flight->flightid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttype[]', $flight->flighttype, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttypegds[]', $flight->flighttypegds, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('fare[]', $flight->fare, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('tax[]', $flight->tax, "style='display: none'")}"
        . "";
    }
    foreach ($paket2->flight AS $flight2){
      $departuredate2 = strtotime($flight->departuredate);
      $arrivaldate2 = strtotime($flight->arrivaldate);
      $info2['departure'] = $this->m_site->bandara_info($flight2->departure);
      $info2['arrival'] = $this->m_site->bandara_info($flight2->arrival);
      $terbang2 .= ""
        . "<tr>"
          . "<td class='td-plane'>"
            . "<figure><img id='popup-iconmaskapai-pergi' src='{$flight2->flightimage}' style='height: 30px' alt='' class='plane-logo'></figure>"
            . "<p class='plane-name'>{$flight2->flightname}</p>"
            . "<p id='popup-codemaskapai-pergi' class='plane-code'>{$flight2->number}</p>"
          . "</td>"
          . "<td class='td-takeoff'>"
            . "<h4 id='popup-departtime-pergi' class='takeoff-time'>".date("H:i", $departuredate2)."</h4>"
            . "<p id='popup-origin-pergi' class='takeoff-port'>{$info2['departure']['city']} ({$info2['departure']['code']})</p>"
          . "</td>"
          . "<td class='arrow'>"
            . "<img src='{$url}assets/images/icons/arrow-blue-right.png' alt=''>"
          . "</td>"
          . "<td class='td-landing'>"
            . "<h4 id='popup-arrivetime-pergi' class='landing-time'>".date("H:i", $arrivaldate2)."</h4>"
            . "<p id='popup-destination-pergi' class='landing-port'>{$info2['arrival']['city']} ({$info2['arrival']['code']})</p>"
          . "</td>"
        . "</tr>"
        . "";
            
      $form .= ""
        . "{$this->form_eksternal->form_input('departure2[]', $flight2->departure, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrival2[]', $flight2->arrival, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('departuredate2[]', $flight2->departuredate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('arrivaldate2[]', $flight2->arrivaldate, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('seat2[]', $flight2->seat, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightnumber2[]', $flight2->flightnumber, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightclass2[]', $flight2->flightclass, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightimage2[]', $flight2->flightimage, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightname2[]', $flight2->flightname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classname2[]', $flight2->classname, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('classid2[]', $flight2->classid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flightid2[]', $flight2->flightid, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttype2[]', $flight2->flighttype, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('flighttypegds2[]', $flight2->flighttypegds, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('fare2[]', $flight2->fare, "style='display: none'")}"
        . "{$this->form_eksternal->form_input('tax2[]', $flight2->tax, "style='display: none'")}"
        . "";
    }
    $total = $harga_tampil = $price['normal'] = $paket->harga + $paket2->harga;
    
    $reg = $this->diskon(1, $total);
    $inf1 = $this->diskon(2, $total);
    $inf2 = $this->diskon(1, $inf1['result']);
    
    $firstdeparture = strtotime($paket->flight[0]->departuredate);
    $firstdeparture2 = strtotime($paket2->flight[0]->departuredate);
    
    
    $this->load->model("site/m_sitediscount");
    $this->load->model("site/m_site");
    $payment_channel = $this->m_site->payment_channel_get();
    $discount_depan = $this->m_sitediscount->discount_depan();
    foreach ($payment_channel['data'] AS $pc){
      $whitelist[$pc['id']] = array(
        "title" => $pc['title'],
        "image" => $pc['image']
      );
    }
//    $this->debug($harga_tampil);
//    $this->debug($payment_channel);
//    $this->debug($discount_depan);
    if($discount_depan['status'] == 2){
      foreach ($discount_depan['data']['discount'] AS $disc){
        if($disc['is_payment_channel'] == 2){
          $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
        }
        else{
          foreach ($disc['payment_channel'] AS $dpc){
            if($whitelist[$dpc['id']]){
              $harga_discount = ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']);
              $harga_temp = $harga_tampil - $harga_discount;
              $penawaran .= ""
                . "<section class='card'>"
                  . "<div class='media'>"
                    . "<div class='media-left media-top'>"
                      . "<img style='width: 43px' src='{$whitelist[$dpc['id']]['image']}' alt=''>"
                    . "</div>"
                    . "<div class='media-body media-top'>"
                      . "<small>{$disc['title']}</small>"
                    . "</div>"
                  . "</div>"
                  . "<h4 class='popup-harga-final-dm'>IDR ".number_format($harga_temp)."<br><small class='text-danger'>Anda hemat IDR ".number_format($harga_discount)."</small></h4>"
                . "</section>"
                . "";
              unset($whitelist[$dpc['id']]);
            }
          }
        }
      }
    }
    
    $html = ""
      . "<div class='panel-heading'>"
        . "<h3 class='panel-title'>Rincian Penerbangan Pergi Pulang</h3>"
      . "</div>"
      . "<div class='panel-body'>"
        . "<section id='result-depart-popup'>"
          . "<div class='row'>"
            . "<div class='col-md-3'>"
              . "<p class='title m-0'>Pergi</p>"
              . "<p class='date'>{$hari[date("N", $firstdeparture)]}, ".date("d F Y", $firstdeparture)."</p>"
              . "<p class='total'>{$pst['adult']} Dewasa</p>"
              . "<p class='total'>{$pst['child']} Anak</p>"
              . "<p class='total'>{$pst['infant']} Bayi</p>"
            . "</div>"
            . "<div class='col-md-6 popup-depart-flightdetail' id=''>"
              . "<table class='table table-transparent'>"
                . "<tbody>"
                  . "{$terbang}"
                . "</tbody>"
              . "</table>"
            . "</div>"
            . "<div class='col-md-3 item text-right'>"
//              . "<s class='price-b4 popup-harga-pergi-d'>IDR 519,200</s>"
              . "<h4 class='m-0 price-new popup-harga-pergi-v' id=''>IDR ".  number_format($paket->harga)."</h4>"
            . "</div>"
          . "</div>"
          . "<footer class='detail-descript'>"
            . "<ol class='undefined list-inline popup-depart-fitur' id=''>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Tiket kelas EKONOMI'>{$paket->flight[(count($paket->flight) - 1)]->classname}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title=''>{$paket->flight[(count($paket->flight) - 1)]->transit->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Durasi 1 jam 50 menit'>{$paket->flight[(count($paket->flight) - 1)]->durasi->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Harga barang sudah termasuk bagasi 20 Kg'>"
                  . "<span class='fa fa-suitcase'></span> 20 Kg"
                . "</div>"
              . "</li>"
            . "</ol>"
          . "</footer>"
        . "</section>"
                    
        . "<section id='result-return-popup'>"
          . "<div class='row'>"
            . "<div class='col-md-3'>"
              . "<p class='title m-0'>Pergi</p>"
              . "<p class='date'>{$hari[date("N", $firstdeparture2)]}, ".date("d F Y", $firstdeparture2)."</p>"
              . "<p class='total'>{$pst['adult']} Dewasa</p>"
              . "<p class='total'>{$pst['child']} Anak</p>"
              . "<p class='total'>{$pst['infant']} Bayi</p>"
            . "</div>"
            . "<div class='col-md-6 popup-depart-flightdetail' id=''>"
              . "<table class='table table-transparent'>"
                . "<tbody>"
                  . "{$terbang2}"
                . "</tbody>"
              . "</table>"
            . "</div>"
            . "<div class='col-md-3 item text-right'>"
//              . "<s class='price-b4 popup-harga-pergi-d'>IDR 519,200</s>"
              . "<h4 class='m-0 price-new popup-harga-pergi-v' id=''>IDR ".  number_format($paket2->harga)."</h4>"
            . "</div>"
          . "</div>"
          . "<footer class='detail-descript'>"
            . "<ol class='undefined list-inline popup-depart-fitur' id=''>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Tiket kelas EKONOMI'>{$paket2->flight[(count($paket2->flight) - 1)]->classname}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title=''>{$paket2->flight[(count($paket2->flight) - 1)]->transit->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Durasi 1 jam 50 menit'>{$paket2->flight[(count($paket2->flight) - 1)]->durasi->string}</div>"
              . "</li>"
              . "<li>"
                . "<div data-toggle='tooltip' data-placement='top' title='' data-original-title='Harga barang sudah termasuk bagasi 20 Kg'>"
                  . "<span class='fa fa-suitcase'></span> 20 Kg"
                . "</div>"
              . "</li>"
            . "</ol>"
          . "</footer>"
        . "</section>"
      . "</div>"
      . "<div class='panel-footer'>"
        . "<div class='row'>"
          . "<div class='col-sm-6 cards'>"
            . $penawaran
          . "</div>"
          . "<div class='col-sm-6 text-right'>"
            . "<section class='price-total'>"
              . "<p class='pull-left m-0'>Total Harga</p>"
              . "<h3 class='popup-harga-final-d'>IDR ".number_format($total)."</h3>"
              . "<p class='text-muted'><small><em>Termasuk semua pajak &amp; biaya penerbangan</em></small></p>"
            . "</section>"
          . "</div>"
          . "<div class='col-sm-12 text-right plan-submit'>"
            . "<form method='POST' action='".site_url("site/book")."'>"
              . "{$form}"
              . "<input type='submit' value='' id='submit-flight-mobile' class='sprites sprites-btn-pesan-lg'>"
            . "</form>"
          . "</div>"
        . "</div>"
      . "</div>";
    
    print $html;die;
  }
  
  function voucher_validation(){
    $pst = $this->input->post();
//    $pst['code'] = "PROMO100";
//    $pst['id_crm_payment_channel'] = "WL3JCKGBQMB76O";
//    $pst['pnrid'] = "4220229";
    $this->load->model("site/m_opsigo");
    $this->load->model("site/m_sitediscount");
    $book = $this->m_opsigo->reservation_cek($pst['pnrid']);
    
    $nilai = 0;
    foreach ($book['detail']['flight'] AS $flight){
      $nilai += $flight[0]['total'];
    }
    $this->global_models->trans_begin();
    $voucher = $this->m_sitediscount->voucher_cek($pst['code'], $pst['id_crm_payment_channel'], $nilai);
    
    if($voucher['status'] == 2){
      $data = array(
        "book"                  => $book,
        "voucher"               => $voucher,
        "nilai"                 => $nilai,
        "id_crm_payment_channel"=> $pst['id_crm_payment_channel'],
      );
//      $this->debug($data, true);
      $voucher_set = $this->m_sitediscount->voucher_set($data);
      if($voucher_set['status'] = 2){
        $return = array(
          "status"  => 2,
          "nilai"   => $nilai,
          "id"      => $voucher_set['id']
        );
      }
      else {
        $return = array(
          "status" => 3
        );
      }
    }
    else{
      $return = array(
        "status" => 3
      );
    }
    $this->global_models->trans_commit();
    print json_encode($return);
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */