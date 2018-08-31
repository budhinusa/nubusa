<?php
class M_opsigo extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  private $server_token   = "https://opsigo-auth.azurewebsites.net/core/connect/token";
  private $grant_type     = "client_credentials";
  private $server         = "https://opsigo-vayaapi-dev.azurewebsites.net";
//  private $server         = "https://opsigo-vayaapi.azurewebsites.net/apiv2";
  private $client_id      = "client-cre-opsigo-vadn";
//  private $client_id      = "client-cre-testopsigo-va";
  private $client_secret  = "5{yar]32>!z+hWYB";
//  private $client_secret  = "V@4p1s3cRet";
  private $scope          = "scope-va-opsigoapi";
//  private $scope          = "scope-opsigoapi";
    
  function detail($token, $pst){
    $url = $this->server."/apiv2/FareDetail";
    $kirim = array(
      "Airline"   => $pst['airline'],
      "Adult"     => $pst['adult'],
      "Child"     => $pst['child'],
      "Infant"    => $pst['infant'],
      "ClassId"   => $pst['classid'],
      "FlightId"  => $pst['flightid'],
      "Fare"      => $pst['fare'],
      "Tax"       => $pst['tax'],
    );
//    print "<pre>";
//    print_r($pst);
//    print "<br />";
//    print_r($kirim);
//    print "<br />";
//    print_r($token);
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
    $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
    $hasil_json = json_decode($hasil);
    
    if($hasil_json){
      $return = array(
        "status"  => 2,
        "data"    => $hasil_json,
      );
    }
    else{
      $return = array(
        "status"  => 3,
        "debug"   => $hasil,
        "note"    => $hasil_json,
      );
    }
    
    return $return;
  }
  
  function availability($token, $route, $pax, $faretype, $airlines, $start_date, $return_date = NULL){
    $url = $this->server."/apiv4/FlightAvailability";
    $fare = array(
      1 => "Default",
      2 => "LowestFare"
    );
    $routes[] = array(
      "Origin"      => $route['origin'],
      "Destination" => $route['destination'],
      "DepartDate"  => $start_date,
    );
    if($return_date){
      $routes[] = array(
        "Origin"      => $route['destination'],
        "Destination" => $route['origin'],
        "DepartDate"  => $return_date,
      );
    }
    
    $this->generate_id($requestid);
    
    $kirim = array(
      "Routes"                      => $routes,
      "Adult"                       => $pax['adult'],
      "Child"                       => $pax['child'],
      "Infant"                      => $pax['infant'],
      "FareType"                    => $fare[$faretype],
      "PreferredAirlines"           => array($airlines),
      "RequestId"                   => $requestid,
      "EmptyPerAirlineCallbackUrl"  => site_url("site/available-flight/{$requestid}"),
    );
    
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
    $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
    $hasil_json = json_decode($hasil);
    
    if($hasil_json){
      $data = array();
      foreach ($hasil_json->Schedules[0] AS $key => $hj){
        if($key == "Flights"){
          foreach ($hj AS $flg){
            $flight = array();
            $class = array();
            if($flg->ClassObjects){
              foreach ($flg->ClassObjects AS $cls){
                $class[] = array(
                  "id"        => $cls->Id,
                  "code"      => $cls->Code,
                  "category"  => $cls->Category,
                  "seat"      => $cls->Seat,
                  "fare"      => $cls->Fare,
                  "tax"       => $cls->Tax,
                  "farecode"  => $cls->FareBasisCode,
                );
              }
              $flight[] = array(
                "class"   => $class,
                "info"    => array(
                  "id"      => $flg->Id,
                  "airline" => $flg->Airline,
                  "image"   => $flg->AirlineImageUrl,
                  "name"    => $flg->AirlineName,
                  "number"  => $flg->Number,
                  "fare"    => $flg->Fare,
                  "type"    => $flg->FlightType,
                ),
                "route"   => array(
                  "origin"      => $flg->Origin,
                  "destination" => $flg->Destination,
                  "date"        => array(
                    "departure"   => $flg->DepartDate." ".$flg->DepartTime,
                    "arrive"      => $flg->ArriveDate." ".$flg->ArriveTime
                  )
                ),
              );
            }
            if($flg->ConnectingFlights){
              foreach ($flg->ConnectingFlights AS $conn){
                $class = array();
                foreach ($conn->ClassObjects AS $cls){
                  $class[] = array(
                    "id"        => $cls->Id,
                    "code"      => $cls->Code,
                    "category"  => $cls->Category,
                    "seat"      => $cls->Seat,
                    "fare"      => $cls->Fare,
                    "tax"       => $cls->Tax,
                    "farecode"  => $cls->FareBasisCode,
                  );
                }
                $flight[] = array(
                  "class"   => $class,
                  "info"    => array(
                    "id"      => $conn->Id,
                    "airline" => $conn->Airline,
                    "image"   => $conn->AirlineImageUrl,
                    "name"    => $conn->AirlineName,
                    "number"  => $conn->Number,
                    "fare"    => $conn->Fare,
                    "type"    => $conn->FlightType,
                  ),
                  "route"   => array(
                    "origin"      => $conn->Origin,
                    "destination" => $conn->Destination,
                    "date"        => array(
                      "departure"   => $conn->DepartDate." ".$conn->DepartTime,
                      "arrive"      => $conn->ArriveDate." ".$conn->ArriveTime
                    )
                  ),
                );
              }
            }
            if($flight){
              $paket = array(
                "transit"     => $flg->TotalTransit,
                "flight"      => $flight,
              );
              $data[] = $paket;
            }
          }
        }
      }
      if($data){
        $return = array(
          "status"  => 2,
          "data"    => $data,
//          "opsigo"  => array(
//            "gdstype"     => $data
//          ),
          "update"  => $hasil_json->Schedules[0]->HaveUpdate,
//          "debug"   => $hasil,
//          "note"    => $hasil_json,
        );
      }
      else{
        if($hasil_json->Schedules[0]->HaveUpdate == 1){
          $kirim = array(
            "id_site_ticket_available_progress"        => $requestid,
            "create_date"                              => date("Y-m-d H:i:s"),
          );
          $this->global_models->insert("site_ticket_available_progress", $kirim);
        }
        $return = array(
          "status"  => 3,
          "note"    => $hasil_json,
          "debug"   => $kirim,
          "update"  => $hasil_json->Schedules[0]->HaveUpdate,
          "requestid" => $requestid,
        );
      }
    }
    else{
      if($hasil_json->Schedules[0]->HaveUpdate == 1){
        $kirim = array(
          "id_site_ticket_available_progress"        => $requestid,
          "create_date"                              => date("Y-m-d H:i:s"),
        );
        $this->global_models->insert("site_ticket_available_progress", $kirim);
      }
      $return = array(
        "status"  => 3,
        "note"    => $hasil_json,
        "debug"   => $kirim,
        "update"  => $hasil_json->Schedules[0]->HaveUpdate,
        "requestid" => $requestid,
      );
    }
    
    return $return;
  }
  
  function reservation($contact, $book, $type = 1){
    $id_crm_customer = $this->global_models->get_field("crm_customer", "id_crm_customer", array("email" => $contact['email']));
    if($id_crm_customer){
      $kirim_customer = array(
        "code"            => "OTA",
        "title"           => $contact['title'],
        "name"            => $contact['firstname']." ".$contact['lastname'],
        "telp"            => $contact['hp'],
        "telp_home"       => $contact['telp'],
        "update_by_users" => $this->session->userdata("id"),
      );
      $this->global_models->update("crm_customer", array("id_crm_customer" => $id_crm_customer), $kirim_customer);
    }
    else{
      $this->global_models->generate_id($id_crm_customer, "crm_customer");
      $kirim_customer = array(
        "id_crm_customer" => $id_crm_customer,
        "code"            => "OTA",
        "title"           => $contact['title'],
        "name"            => $contact['firstname']." ".$contact['lastname'],
        "telp"            => $contact['hp'],
        "telp_home"       => $contact['telp'],
        "email"           => $contact['email'],
        "create_by_users" => $this->session->userdata("id"),
        "create_date"     => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("crm_customer", $kirim_customer);
    }
//    book
    $this->global_models->generate_id($id_site_ticket_reservation, "site_ticket_reservation");
    $this->generate_code($code);
    $kirim_book = array(
      "id_site_ticket_reservation"  => $id_site_ticket_reservation,
      "id_crm_customer"             => $id_crm_customer,
      "tanggal"                     => date("Y-m-d H:i:s"),
      "code"                        => $code,
      "type"                        => $type,
      "origin"                      => $book['origin'],
      "destination"                 => $book['destination'],
      "adult"                       => $book['adult'],
      "child"                       => $book['child'],
      "infant"                      => $book['infant'],
      "departuredate"               => $book['departuredate'],
      "returndate"                  => $book['returndate'],
      "status"                      => 1,
      "create_by_users"             => $this->session->userdata("id"),
      "create_date"                 => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("site_ticket_reservation", $kirim_book);
    
    $return = array(
      "status"      => 2,
      "reservation" => array(
        "id"          => $id_site_ticket_reservation,
        "code"        => $code,
      ),
      "customer"    => array(
        "id"          => $id_crm_customer
      ),
    );
    
    return $return;
  }
  
  function generate_code(&$code){
    $this->load->helper('string');
    $num = rand(1,7);
    $code = random_string('numeric', $num);
    $code = str_pad($code, 7, "0", STR_PAD_LEFT);
    $cek = $this->global_models->get_field("site_ticket_reservation", "code", array("code" => $code));
    if($cek OR $code == "0000000"){
      $this->generate_code($code);
    }
  }
  
  function reservation_detail_get($code){
    $book = $this->global_models->get("site_ticket_reservation", array("code" => $code));
    $flight1 = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_flight AS A"
      . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
      . " AND A.type = 1"
      . " AND A.status = 1"
      . " ORDER A.urut ASC"
      . "");
    $flight2 = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_flight AS A"
      . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
      . " AND A.type = 2"
      . " AND A.status = 1"
      . " ORDER A.urut ASC"
      . "");
    $pax = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_pax AS A"
      . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
      . " ORDER BY A.urut ASC");
      
    $return = array(
      "status"    => 2,
    );
      
    return $return;
  }
  
  function reservation_detail($code){
    $book = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_progress AS A"
      . " WHERE A.id_site_ticket_reservation = (SELECT B.id_site_ticket_reservation FROM site_ticket_reservation AS B WHERE B.code = '{$code}')"
      . " AND A.status = 1"
      . " GROUP BY A.order"
      . " ORDER BY A.order ASC, A.progress DESC");
      
    $token = $this->token();
    
    if($token['status'] == 2){
      foreach ($book AS $bk){
        $detail[] = $this->reservation_detail_pnrid($token['data']['token'], $bk->pnrid);
      }
    }
    return $detail;
  }
  
  function reservation_detail_pnrid($token, $pnrid){
    $url = $this->server."/apiv3/GetRsvById?id={$pnrid}";
    
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
//    $hasil = $this->curl_mentah($url, array(), $header, TRUE);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $hasil = curl_exec($ch);
    curl_close($ch);
    
    $hasil_json = json_decode($hasil);
    
    if($hasil_json->BookingCode){
      $pax = $bill = $flight = array();
      foreach ($hasil_json->Passengers AS $pas){
        $pax[] = array(
          "urut"      => $pas->Index,
          "type"      => $pas->Type,
          "title"     => $pas->Title,
          "firstname" => $pas->FirstName,
          "lastname"  => $pas->LastName,
          "birthdate" => $pas->BirthDate,
          "gender"    => $pas->Gender,
          "telp"      => $pas->MobilePhone,
          "telp_home" => $pas->HomePhone,
          "nationality"   => $pas->Nationality,
          "ticketnumber"  => $pas->TicketNumber,
          "passport"  => array(
            "number"    => $pas->Passport->Number,
            "origin"    => $pas->Passport->OriginCountry,
            "firstname" => $pas->Passport->FirstName,
            "lastname"  => $pas->Passport->LastName,
            "expire"    => $pas->Passport->Expire,
          )
        );
      }
      
      foreach ($hasil_json->Payments AS $pay){
        if($pay->Code == "NTA"){
          $nta = array(
            "title"       => $pay->Title,
            "amount"      => $pay->Amount,
            "currency"    => $pay->Currency,
          );
        }
        else if($pay->Code == "TOTAL"){
          $total = array(
            "title"       => $pay->Title,
            "amount"      => $pay->Amount,
            "currency"    => $pay->Currency,
          );
        }
        else{
          $bill[] = array(
            "title"       => $pay->Title,
            "amount"      => $pay->Amount,
            "currency"    => $pay->Currency,
          );
        }
      }
      
      foreach ($hasil_json->FlightDetails AS $fl){
        $flight[] = array(
          "airline"       => $fl->Airline,
          "number"        => $fl->FlightNumber,
          "code"          => $fl->CarrierCode,
          "origin"        => $fl->Origin,
          "destination"   => $fl->Destination,
          "departuredate" => $fl->DepartDate." ".$fl->DepartTime,
          "arrivedate"    => $fl->ArriveDate." ".$fl->ArriveTime,
          "class"         => $fl->Class,
        );
      }
      
      $return = array(
        "status"      => 2,
        "book"        => array(
          "id"          => $hasil_json->Id,
          "code"        => $hasil_json->BookingCode,
          "timelimit"   => $hasil_json->TimeLimit,
          "date"        => $hasil_json->Created,
          "note"        => $hasil_json->Status,
        ),
        "bookers"     => array(
          "title"       => $hasil_json->Contact->Title,
          "firstname"   => $hasil_json->Contact->FirstName,
          "lastname"    => $hasil_json->Contact->LastName,
          "email"       => $hasil_json->Contact->Email,
          "telp_home"   => $hasil_json->Contact->HomePhone,
          "telp"        => $hasil_json->Contact->MobilePhone,
        ),
        "passangers"  => $pax,
        "bill"        => $bill,
        "flight"      => $flight,
        "total"       => $total,
        "nta"         => $nta,
        "debug"       => $hasil_json
      );
    }
    else{
      $return = array(
        "status"  => 3,
        "book"        => array(
          "id"          => $hasil_json->Id,
          "code"        => $hasil_json->BookingCode,
          "timelimit"   => $hasil_json->TimeLimit,
          "date"        => $hasil_json->Created,
          "note"        => $hasil_json->Status,
        ),
        "note"    => $hasil_json,
      );
    }
    
    return $return;
  }
  
  function reservation_cek($code){
    $book = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_progress AS A"
      . " WHERE A.id_site_ticket_reservation = (SELECT B.id_site_ticket_reservation FROM site_ticket_reservation AS B WHERE B.code = '{$code}')"
      . " AND A.status = 1"
      . " AND A.order IN (1,2)"
//      . " AND A.progress > 0"
//      . " GROUP BY A.order"
      . " ORDER BY A.progress DESC"
//      . " ORDER BY RAND()"
      . " LIMIT 0,1"
      . "");
      
    $book2 = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_progress AS A"
      . " WHERE A.id_site_ticket_reservation = (SELECT B.id_site_ticket_reservation FROM site_ticket_reservation AS B WHERE B.code = '{$code}')"
      . " AND A.status = 1"
      . " AND A.order = 3"
//      . " AND A.progress > 0"
//      . " GROUP BY A.order"
      . " ORDER BY A.progress DESC"
      . " LIMIT 0,1"
      . "");
      
    if($book){
      if($book2){
        $progress = ($book[0]->progress + $book2[0]->progress)/2;
      }
      else{
        $progress = $book[0]->progress;
      }
      if($progress >= 100){
        $detail = $this->reservation_detail($code);
        
        if($detail[0]['status'] == 2){
          foreach ($detail AS $key => $det){
            $type = ($key == 0 ? 1 : 2);
            $cek_flight = $this->global_models->get_query("SELECT A.*"
              . " ,(SELECT B.type FROM site_ticket_reservation AS B WHERE B.id_site_ticket_reservation = A.id_site_ticket_reservation) AS type_flight"
              . " FROM site_ticket_reservation_flight AS A"
              . " WHERE A.type = '{$type}'"
              . " AND A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
              . " AND A.status = 1"
              . " ORDER BY A.urut ASC");
            if(!$cek_flight[0]->pnrid){
              $kirim_update_flight = array(
                "id"          => $det['book']['id'],
                "pnrid"       => $det['book']['code'],
                "timelimit"   => $det['book']['timelimit'],
                "total"       => $det['total']['amount'],
                "nta"         => $det['nta']['amount'],
                "detail"      => json_encode($det['bill']),
                "note"        => $det['book']['note'],
              );
              if(in_array($cek_flight[0]->type_flight, array(1,2))){
                $where_flight = array("id_site_ticket_reservation" => $cek_flight[0]->id_site_ticket_reservation);
              }
              else{
                $where_flight = array("id_site_ticket_reservation_flight" => $cek_flight[0]->id_site_ticket_reservation_flight);
              }
              $this->global_models->update("site_ticket_reservation_flight", $where_flight, $kirim_update_flight);
            }
          }
          
          foreach ($detail[0]['detail']['passangers'] AS $pax){
            if($pax['ticketnumber']){
              $this->global_models->query("UPDATE site_ticket_reservation_pax"
                . " SET ticketnumber = '{$pax['ticketnumber']}'"
                . " WHERE id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
                . " AND LOWER(firstname) = '".  strtolower($pax['firsname'])."'"
                . " AND LOWER(lastname) = '".  strtolower($pax['lastname'])."'"
                . " ");
            }
          }
          
        }
        
        $book_detail = $this->global_models->get_query("SELECT A.*"
          . " ,B.*"
          . " FROM site_ticket_reservation AS A"
          . " LEFT JOIN crm_customer AS B ON B.id_crm_customer = A.id_crm_customer"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'");
          
        $title = $this->global_variable->title_name();
          
        $flight_detail = $this->global_models->get_query("SELECT A.*"
          . " FROM site_ticket_reservation_flight AS A"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
          . " AND A.status = 1"
          . " ORDER BY A.type ASC, A.urut ASC");
          
        foreach ($flight_detail AS $fd){
          $nomor = explode(" ", $fd->flightnumber);
          $f_detail[($fd->type == 1 ? 0 : 1)][$fd->urut] = array(
            "origin"        => $fd->origin,
            "destination"   => $fd->destination,
            "number"        => $fd->flightnumber,
            "class"         => $fd->classcode,
            "airlinecode"   => $fd->airline,
            "airline"       => $nomor[0],
            "departdate"    => $fd->departdate,
            "arrivaldate"   => $fd->arrivaldate,
            "price"         => $fd->price,
            "pnrid"         => $fd->pnrid,
            "timelimit"     => $fd->timelimit,
            "total"         => $fd->total,
            "nta"           => $fd->nta,
            "detail"        => $fd->detail,
            "note"          => $fd->note,
          );
        }
          
        $pax_detail = $this->global_models->get_query("SELECT A.*"
          . " FROM site_ticket_reservation_pax AS A"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
          . " ORDER BY A.urut ASC");
          
        foreach ($pax_detail AS $pd){
          $p_detail[] = array(
            "firstname"       => $pd->firstname,
            "lastname"        => $pd->lastname,
            "title"           => $title[$pd->title],
            "birthdate"       => $pd->birthdate,
            "email"           => $pd->email,
            "telp_home"       => $pd->telp_home,
            "telp_1"          => $pd->telp_1,
            "telp_2"          => $pd->telp_2,
            "type"            => $pd->type,
            "nationality"     => $pd->nationality,
            "passportexpire"  => $pd->passportexpire,
            "passportnumber"  => $pd->passportnumber,
            "passportorigin"  => $pd->passportorigin,
            "urut"            => $pd->urut,
            "urut_assoc"      => $pd->urut_assoc,
            "note"            => $pd->note
          );
        }
        
        $return = array(
          "status"      => 2,
          "progress"    => 100,
//          "debug"       => $detail,
          "stamp"       => array(
            $detail[0]['book']['note'],
            $detail[1]['book']['note'],
          ),
//          "debug"       => $detail,
          "detail"      => array(
            "bookers"     => array(
              "number"      => $code,
              "origin"      => $book_detail[0]->origin,
              "destination" => $book_detail[0]->destination,
              "adult"       => $book_detail[0]->adult,
              "child"       => $book_detail[0]->child,
              "infant"      => $book_detail[0]->infant,
              "departuredate" => $book_detail[0]->departuredate,
              "returndate"  => $book_detail[0]->returndate,
              "date"        => $book_detail[0]->tanggal,
              "title"       => $title[$book_detail[0]->title],
              "name"        => $book_detail[0]->name,
              "email"       => $book_detail[0]->email,
              "telp"        => $book_detail[0]->telp,
              "telp_home"   => $book_detail[0]->telp_home,
              "type"        => $cek_flight[0]->type_flight,
              "status"      => $book_detail[0]->status,
              "id"          => $book_detail[0]->id_site_ticket_reservation,
            ),
            "flight"      => $f_detail,
            "pax"         => $p_detail,
          ),
        );
      }
      else{
        $book_detail = $this->global_models->get_query("SELECT A.*"
          . " ,B.*"
          . " FROM site_ticket_reservation AS A"
          . " LEFT JOIN crm_customer AS B ON B.id_crm_customer = A.id_crm_customer"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'");
          
        $title = $this->global_variable->title_name();
          
        $flight_detail = $this->global_models->get_query("SELECT A.*"
          . " FROM site_ticket_reservation_flight AS A"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
          . " AND A.status = 1"
          . " ORDER BY A.type ASC, A.urut ASC");
          
        foreach ($flight_detail AS $fd){
          $nomor = explode(" ", $fd->flightnumber);
          $f_detail[($fd->type == 1 ? 0 : 1)][$fd->urut] = array(
            "origin"        => $fd->origin,
            "destination"   => $fd->destination,
            "number"        => $fd->flightnumber,
            "class"         => $fd->classcode,
            "airlinecode"   => $fd->airline,
            "airline"       => $nomor[0],
            "departdate"    => $fd->departdate,
            "arrivaldate"   => $fd->arrivaldate,
            "price"         => $fd->price,
          );
        }
          
        $pax_detail = $this->global_models->get_query("SELECT A.*"
          . " FROM site_ticket_reservation_pax AS A"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
          . " ORDER BY A.urut ASC");
          
        foreach ($pax_detail AS $pd){
          $p_detail[] = array(
            "firstname"       => $pd->firstname,
            "lastname"        => $pd->lastname,
            "title"           => $title[$pd->title],
            "birthdate"       => $pd->birthdate,
            "email"           => $pd->email,
            "telp_home"       => $pd->telp_home,
            "telp_1"          => $pd->telp_1,
            "telp_2"          => $pd->telp_2,
            "type"            => $pd->type,
            "nationality"     => $pd->nationality,
            "passportexpire"  => $pd->passportexpire,
            "passportnumber"  => $pd->passportnumber,
            "passportorigin"  => $pd->passportorigin,
            "urut"            => $pd->urut,
            "urut_assoc"      => $pd->urut_assoc,
            "note"            => $pd->note
          );
        }
          
        $return = array(
//          "debug"       => $book,
          "status"      => 4,
          "progress"    => $progress,
          "detail"      => array(
            "bookers"     => array(
              "number"      => $code,
              "date"        => $book_detail[0]->tanggal,
              "title"       => $title[$book_detail[0]->title],
              "name"        => $book_detail[0]->name,
              "email"       => $book_detail[0]->email,
              "telp"        => $book_detail[0]->telp,
              "telp_home"   => $book_detail[0]->telp_home,
            ),
            "flight"      => $f_detail,
            "pax"         => $p_detail,
          ),
        );
      }
    }
    else{
      $return = array(
        "status"      => 3,
        "debug"       => array(
          $book, $book2
        ),
      );
    }
    
    return $return;
  }
  
  function reservation_flight($token, $reservation, $passangers, $segments, $fields = array()){
    $url = $this->server."/apiv3/RsvFlight";
    $pax = array();
    $type = array(
      1 => "Adult",
      2 => "Child",
      3 => "Infant",
    );
    $title = $this->global_variable->title_name();
    
    foreach ($passangers AS $key => $ps){
      
      $this->global_models->generate_id($id_site_ticket_reservation_pax, "site_ticket_reservation_pax");
      $kirim_pax = array(
        "id_site_ticket_reservation_pax"  => $id_site_ticket_reservation_pax,
        "id_site_ticket_reservation"      => $reservation['reservation']['id'],
        "firstname"                       => $ps['firstname'],
        "lastname"                        => $ps['lastname'],
        "title"                           => $ps['title'],
        "birthdate"                       => $ps['birthdate'],
        "email"                           => $ps['email'],
        "telp_home"                       => $ps['telp'],
        "telp_1"                          => $ps['hp1'],
        "telp_2"                          => $ps['hp2'],
        "type"                            => $ps['type'],
        "nationality"                     => $ps['nationality'],
        "passportexpire"                  => $ps['passport']['expire'],
        "passportnumber"                  => $ps['passport']['number'],
        "passportorigin"                  => $ps['passport']['origin'],
        "urut"                            => $key,
        "urut_assoc"                      => $ps['assoc'],
        "note"                            => "",
        "create_by_users"                 => $this->session->userdata("id"),
        "create_date"                     => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("site_ticket_reservation_pax", $kirim_pax);
      
      $pax[] = array(
        "Index"           => ($key + 1),
        "Type"            => $ps['type'],
        "Title"           => $title[$ps['title']],
        "FirstName"       => $ps['firstname'],
        "LastName"        => ($ps['lastname'] ? $ps['lastname'] : $ps['firstname']),
        "BirthDate"       => $ps['birthdate'],
        "Email"           => $ps['email'],
        "HomePhone"       => $ps['telp'],
        "MobilePhone"     => $ps['hp1'],
        "OtherPhone"      => $ps['hp2'],
        "IdNumber"        => $ps['id'],
        "Nationality"     => $ps['nationality'],
        "AdultAssoc"      => $ps['assoc'],
        "PassportExpire"  => $ps['passport']['expire'],
        "PassportNumber"  => $ps['passport']['number'],
        "PassportOrigin"  => $ps['passport']['origin'],
      );
    }
    
    foreach ($segments["departure"] AS $key1 => $dep){
      //    flight
      $this->global_models->generate_id($id_site_ticket_reservation_flight, "site_ticket_reservation_flight");
      $kirim_flight = array(
        "id_site_ticket_reservation_flight" => $id_site_ticket_reservation_flight,
        "id_site_ticket_reservation"        => $reservation['reservation']['id'],
        "code"                              => $reservation['reservation']['code'],
        "origin"                            => $dep['departure']['code'],
        "destination"                       => $dep['arrive']['code'],
        "flightnumber"                      => $dep['flight']['number'],
        "classcode"                         => $dep['class']['code'],
        "airline"                           => $dep['airline'],
        "departdate"                        => $dep['departure']['date'],
        "arrivaldate"                       => $dep['arrive']['date'],
        "seat"                              => $dep['flight']['seat'],
        "type"                              => 1,
        "status"                            => 1,
        "urut"                              => $key1,
        "price"                             => ($dep['class']['fare'] + $dep['class']['tax']),
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("site_ticket_reservation_flight", $kirim_flight);
      
      $flight[] = array(
        "ClassId"         => $dep['class']['id'],
        "Airline"         => $dep['airline'],
        "FlightNumber"    => $dep['flight']['number'],
        "Origin"          => $dep['departure']['code'],
        "DepartDate"      => date("Y-m-d", strtotime($dep['departure']['date'])),
        "DepartTime"      => date("H:i:s", strtotime($dep['departure']['date'])),
        "Destination"     => $dep['arrive']['code'],
        "ArriveDate"      => date("Y-m-d", strtotime($dep['arrive']["date"])),
        "ArriveTime"      => date("H:i:s", strtotime($dep['arrive']['date'])),
        "ClassCode"       => $dep['class']['code'],
        "FlightId"        => $dep['flight']['id'],
        "Num"             => 0,
        "Seq"             => $key1
      );
    }
    
    if($segments["return"]){
      if($segments["return"][0]['airline'] == $segments["departure"][0]['airline']){
        $reservation_type = 2;
      }
      else{
        $reservation_type = 3;
      }
    }
    else{
      $reservation_type = 1;
    }
    
    $this->global_models->update("site_ticket_reservation", array("id_site_ticket_reservation" => $reservation['reservation']['id']), array("type" => $reservation_type));
    
    if($reservation_type == 2){
      foreach ($segments["return"] AS $key2 => $ret){
        //    flight
        $this->global_models->generate_id($id_site_ticket_reservation_flight, "site_ticket_reservation_flight");
        $kirim_flight = array(
          "id_site_ticket_reservation_flight" => $id_site_ticket_reservation_flight,
          "id_site_ticket_reservation"        => $reservation['reservation']['id'],
          "code"                              => $reservation['reservation']['code'],
          "origin"                            => $ret['departure']['code'],
          "destination"                       => $ret['arrive']['code'],
          "flightnumber"                      => $ret['flight']['number'],
          "classcode"                         => $ret['class']['code'],
          "airline"                           => $ret['airline'],
          "departdate"                        => $ret['departure']['date'],
          "arrivaldate"                       => $ret['arrive']['date'],
          "seat"                              => $ret['flight']['seat'],
          "type"                              => $reservation_type,
          "status"                            => 1,
          "urut"                              => $key2,
          "price"                             => ($ret['class']['fare'] + $ret['class']['tax']),
          "create_by_users"                   => $this->session->userdata("id"),
          "create_date"                       => date("Y-m-d H:i:s"),
        );
        $this->global_models->insert("site_ticket_reservation_flight", $kirim_flight);

        $flight[] = array(
          "ClassId"         => $ret['class']['id'],
          "Airline"         => $ret['airline'],
          "FlightNumber"    => $ret['flight']['number'],
          "Origin"          => $ret['departure']['code'],
          "DepartDate"      => date("Y-m-d", strtotime($ret['departure']['date'])),
          "DepartTime"      => date("H:i:s", strtotime($ret['departure']['date'])),
          "Destination"     => $ret['arrive']['code'],
          "ArriveDate"      => date("Y-m-d", strtotime($ret['arrive']["date"])),
          "ArriveTime"      => date("H:i:s", strtotime($ret['arrive']['date'])),
          "ClassCode"       => $ret['class']['code'],
          "FlightId"        => $ret['flight']['id'],
          "Num"             => ($segments["departure"] ? 1 : 0),
          "Seq"             => $key2
        );
      }
    }
    
    $customer = $this->global_models->get("crm_customer", array("id_crm_customer" => $reservation['customer']['id']));
    $firstname = explode(" ", $customer[0]->name);
    $lastname = "";
    foreach ($firstname AS $frt){
      $lastname .= "{$frt} ";
    }
    
    $kirim = array(
      "Contact"           => array(
        "Email"       => $customer[0]->email,
        "Title"       => $title[$customer[0]->title],
        "FirstName"   => $firstname[0],
        "LastName"    => $lastname,
        "HomePhone"   => $customer[0]->telp_home,
        "MobilePhone" => $customer[0]->telp
      ),
      "Passengers"        => $pax,
      "Segments"          => $flight,
      "CallbackUri"       => site_url("site/reservation-flight"),
      "FlightType"        => $fields['opsigo']['flighttype'],
    );
    
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
    $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
    $hasil_json = json_decode($hasil);
    
    if($reservation_type == 3){
      $flight = array();
      foreach ($segments["return"] AS $key1 => $dep){
      //    flight
        $this->global_models->generate_id($id_site_ticket_reservation_flight, "site_ticket_reservation_flight");
        $kirim_flight = array(
          "id_site_ticket_reservation_flight" => $id_site_ticket_reservation_flight,
          "id_site_ticket_reservation"        => $reservation['reservation']['id'],
          "code"                              => $reservation['reservation']['code'],
          "origin"                            => $dep['departure']['code'],
          "destination"                       => $dep['arrive']['code'],
          "flightnumber"                      => $dep['flight']['number'],
          "classcode"                         => $dep['class']['code'],
          "airline"                           => $dep['airline'],
          "departdate"                        => $dep['departure']['date'],
          "arrivaldate"                       => $dep['arrive']['date'],
          "seat"                              => $dep['flight']['seat'],
          "type"                              => $reservation_type,
          "status"                            => 1,
          "urut"                              => $key1,
          "price"                             => ($dep['class']['fare'] + $dep['class']['tax']),
          "create_by_users"                   => $this->session->userdata("id"),
          "create_date"                       => date("Y-m-d H:i:s"),
        );
        $this->global_models->insert("site_ticket_reservation_flight", $kirim_flight);

        $flight[] = array(
          "ClassId"         => $dep['class']['id'],
          "Airline"         => $dep['airline'],
          "FlightNumber"    => $dep['flight']['number'],
          "Origin"          => $dep['departure']['code'],
          "DepartDate"      => date("Y-m-d", strtotime($dep['departure']['date'])),
          "DepartTime"      => date("H:i:s", strtotime($dep['departure']['date'])),
          "Destination"     => $dep['arrive']['code'],
          "ArriveDate"      => date("Y-m-d", strtotime($dep['arrive']["date"])),
          "ArriveTime"      => date("H:i:s", strtotime($dep['arrive']['date'])),
          "ClassCode"       => $dep['class']['code'],
          "FlightId"        => $dep['flight']['id'],
          "Num"             => 0,
          "Seq"             => $key1
        );
      }
      
      $kirim['Segments'] = $flight;
      $hasil2 = $this->curl_mentah($url, $kirim, $header, TRUE);
      $hasil_json2 = json_decode($hasil2);
    }
    
    if($hasil_json){
      if(in_array($reservation_type, array(1,2))){
        if($hasil_json->PnrId){
          $this->global_models->generate_id($id_site_ticket_reservation_progress, "site_ticket_reservation_progress");
          $progress = array(
            "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress,
            "id_site_ticket_reservation"          => $reservation['reservation']['id'],
            "pnrid"           => $hasil_json->PnrId,
            "progress"        => 0,
            "text"            => "Create",
            "order"           => $reservation_type,
            "type"            => 1,
            "status"          => 1,
            "note"            => $hasil,
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("site_ticket_reservation_progress", $progress);
          $return = array(
            "status"  => 2,
            "id"      => $id_site_ticket_reservation_progress,
            "pnrid"   => $hasil_json->PnrId,
          );
        }
        else{
          $return = array(
            "status"  => 3,
            "debug"   => $kirim,
            "note"    => $hasil,
            "token"   => $token,
          );
        }
      }
      else{
        if($hasil_json->PnrId AND $hasil_json2->PnrId){
          $this->global_models->generate_id($id_site_ticket_reservation_progress, "site_ticket_reservation_progress");
          $progress = array(
            "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress,
            "id_site_ticket_reservation"          => $reservation['reservation']['id'],
            "pnrid"           => $hasil_json->PnrId,
            "progress"        => 0,
            "text"            => "Create",
            "order"           => 1,
            "type"            => 1,
            "status"          => 1,
            "note"            => $hasil,
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("site_ticket_reservation_progress", $progress);
          
          $this->global_models->generate_id($id_site_ticket_reservation_progress2, "site_ticket_reservation_progress");
          $progress = array(
            "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress2,
            "id_site_ticket_reservation"          => $reservation['reservation']['id'],
            "pnrid"           => $hasil_json2->PnrId,
            "progress"        => 0,
            "text"            => "Create",
            "order"           => $reservation_type,
            "type"            => 2,
            "status"          => 1,
            "note"            => $hasil2,
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("site_ticket_reservation_progress", $progress);
          $return = array(
            "status"  => 2,
            "id"      => $id_site_ticket_reservation_progress,
            "id2"     => $id_site_ticket_reservation_progress2,
            "pnrid"   => $hasil_json->PnrId,
            "pnrid2"  => $hasil_json2->PnrId,
          );
        }
        else{
          $return = array(
            "status"  => 3,
            "debug"   => $kirim,
            "note"    => $hasil,
            "token"   => $token,
          );
        }
      }
    }
    else{
      $return = array(
        "status"  => 3,
        "debug"   => $kirim,
        "note"    => $hasil,
        "token"   => $token,
      );
    }
    
    return $return;
  }
  
  function reservation_update_class($token, $code, $class = array(), $class2 = array()){
    $url = $this->server."/apiv3/RsvFlight";
    $reservation = $this->global_models->get("site_ticket_reservation", array("code" => $code));
//    update flight
//    kalau class ada type in array (1,2)
//    kalau class2 ada type in array (3)
    if($class)
      $in_array = "1,2";
    
    if($class2)
      $in_array .= ",3";
    
    $in_array = trim($in_array, ",");
    
    $this->global_models->query("UPDATE site_ticket_reservation_flight"
      . " SET status = 2"
      . " WHERE id_site_ticket_reservation = '{$reservation[0]->id_site_ticket_reservation}'"
      . " AND type IN ({$in_array})");
//    $this->global_models->update("site_ticket_reservation_flight", array("id_site_ticket_reservation" => $reservation[0]->id_site_ticket_reservation), array("status" => 2));
//    update progress
//    kalau class ada order in array (1,2)
//    kalau class2 ada order in array (3)
    $this->global_models->query("UPDATE site_ticket_reservation_progress"
      . " SET status = 2"
      . " WHERE id_site_ticket_reservation = '{$reservation[0]->id_site_ticket_reservation}'"
      . " AND `order` IN ({$in_array})");
//    $this->global_models->update("site_ticket_reservation_progress", array("id_site_ticket_reservation" => $reservation[0]->id_site_ticket_reservation), array("status" => 2));
//    reservation
    $pax = array();
    $type = array(
      1 => "Adult",
      2 => "Child",
      3 => "Infant",
    );
    $title = $this->global_variable->title_name();
    
    $passangers = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation_pax AS A"
      . " WHERE A.id_site_ticket_reservation = '{$reservation[0]->id_site_ticket_reservation}'"
      . " ORDER BY A.urut ASC");
    
    foreach ($passangers AS $key => $ps){
      $pax[] = array(
        "Index"           => ($ps->urut + 1),
        "Type"            => $ps->type,
        "Title"           => $title[$ps->title],
        "FirstName"       => $ps->firstname,
        "LastName"        => ($ps->lastname ? $ps->lastname : $ps->firstname),
        "BirthDate"       => $ps->birthdate,
        "Email"           => $ps->email,
        "HomePhone"       => $ps->telp_home,
        "MobilePhone"     => $ps->telp_1,
        "OtherPhone"      => $ps->telp_2,
        "IdNumber"        => NULL,
        "Nationality"     => $ps->nationality,
        "AdultAssoc"      => $ps->urut_assoc,
        "PassportExpire"  => $ps->passportexpire,
        "PassportNumber"  => $ps->passportnumber,
        "PassportOrigin"  => $ps->passportorigin,
      );
    }
    
    foreach ($class AS $key1 => $dep){
      //    flight
      $this->global_models->generate_id($id_site_ticket_reservation_flight, "site_ticket_reservation_flight");
      $kirim_flight = array(
        "id_site_ticket_reservation_flight" => $id_site_ticket_reservation_flight,
        "id_site_ticket_reservation"        => $reservation[0]->id_site_ticket_reservation,
        "code"                              => $reservation[0]->code,
        "origin"                            => $dep['route']['origin'],
        "destination"                       => $dep['route']['destination'],
        "flightnumber"                      => $dep['flight']['number'],
        "classcode"                         => $dep['class']['code'],
        "airline"                           => $dep['flight']['airline'],
        "departdate"                        => $dep['route']['date']['departure'],
        "arrivaldate"                       => $dep['route']['date']['arrive'],
        "seat"                              => $dep['class']['seat'],
        "type"                              => 1,
        "status"                            => 1,
        "urut"                              => $key1,
        "price"                             => ($dep['class']['fare'] + $dep['class']['tax']),
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("site_ticket_reservation_flight", $kirim_flight);
      
      $flight[] = array(
        "ClassId"         => $dep['class']['id'],
        "Airline"         => $dep['flight']['airline'],
        "FlightNumber"    => $dep['flight']['number'],
        "Origin"          => $dep['route']['origin'],
        "DepartDate"      => date("Y-m-d", strtotime($dep['route']['date']['departure'])),
        "DepartTime"      => date("H:i:s", strtotime($dep['route']['date']['departure'])),
        "Destination"     => $dep['route']['destination'],
        "ArriveDate"      => date("Y-m-d", strtotime($dep['route']['date']['arrive'])),
        "ArriveTime"      => date("H:i:s", strtotime($dep['route']['date']['arrive'])),
        "ClassCode"       => $dep['class']['code'],
        "FlightId"        => $dep['flight']['id'],
        "Num"             => 0,
        "Seq"             => $key1
      );
    }
    
    foreach ($class2 AS $key2 => $ret){
      //    flight
      $this->global_models->generate_id($id_site_ticket_reservation_flight, "site_ticket_reservation_flight");
      $kirim_flight = array(
        "id_site_ticket_reservation_flight" => $id_site_ticket_reservation_flight,
        "id_site_ticket_reservation"        => $reservation[0]->id_site_ticket_reservation,
        "code"                              => $reservation[0]->code,
        "origin"                            => $ret['route']['origin'],
        "destination"                       => $ret['route']['destination'],
        "flightnumber"                      => $ret['flight']['number'],
        "classcode"                         => $ret['class']['code'],
        "airline"                           => $ret['flight']['airline'],
        "departdate"                        => $ret['route']['date']['departure'],
        "arrivaldate"                       => $ret['route']['date']['arrive'],
        "seat"                              => $ret['class']['seat'],
        "type"                              => ($class[0]['flight']['airline'] == $ret['flight']['airline'] ? 2 : 3),
        "status"                            => 1,
        "urut"                              => $key2,
        "price"                             => ($ret['class']['fare'] + $ret['class']['tax']),
        "create_by_users"                   => $this->session->userdata("id"),
        "create_date"                       => date("Y-m-d H:i:s"),
      );
      $this->global_models->insert("site_ticket_reservation_flight", $kirim_flight);
      
      if($class[0]['flight']['airline'] == $ret['flight']['airline']){
        $flight[] = array(
          "ClassId"         => $ret['class']['id'],
          "Airline"         => $ret['flight']['airline'],
          "FlightNumber"    => $ret['flight']['number'],
          "Origin"          => $ret['route']['origin'],
          "DepartDate"      => date("Y-m-d", strtotime($ret['route']['date']['departure'])),
          "DepartTime"      => date("H:i:s", strtotime($ret['route']['date']['departure'])),
          "Destination"     => $dep['route']['destination'],
          "ArriveDate"      => date("Y-m-d", strtotime($ret['route']['date']['arrive'])),
          "ArriveTime"      => date("H:i:s", strtotime($ret['route']['date']['arrive'])),
          "ClassCode"       => $ret['class']['code'],
          "FlightId"        => $ret['flight']['id'],
          "Num"             => 1,
          "Seq"             => $key2
        );
      }
      else{
        $flight2[] = array(
          "ClassId"         => $ret['class']['id'],
          "Airline"         => $ret['flight']['airline'],
          "FlightNumber"    => $ret['flight']['number'],
          "Origin"          => $ret['route']['origin'],
          "DepartDate"      => date("Y-m-d", strtotime($ret['route']['date']['departure'])),
          "DepartTime"      => date("H:i:s", strtotime($ret['route']['date']['departure'])),
          "Destination"     => $dep['route']['destination'],
          "ArriveDate"      => date("Y-m-d", strtotime($ret['route']['date']['arrive'])),
          "ArriveTime"      => date("H:i:s", strtotime($ret['route']['date']['arrive'])),
          "ClassCode"       => $ret['class']['code'],
          "FlightId"        => $ret['flight']['id'],
          "Num"             => 1,
          "Seq"             => $key2
        );
      }
    }
    
    $customer = $this->global_models->get("crm_customer", array("id_crm_customer" => $reservation[0]->id_crm_customer));
    $firstname = explode(" ", $customer[0]->name);
    $lastname = "";
    foreach ($firstname AS $frt){
      $lastname .= "{$frt} ";
    }
    
    $kirim = array(
      "Contact"           => array(
        "Email"       => $customer[0]->email,
        "Title"       => $title[$customer[0]->title],
        "FirstName"   => $firstname[0],
        "LastName"    => ($lastname ? $lastname : $firstname[0]),
        "HomePhone"   => $customer[0]->telp_home,
        "MobilePhone" => $customer[0]->telp
      ),
      "Passengers"        => $pax,
      "Segments"          => $flight,
      "CallbackUri"       => site_url("site/reservation-flight"),
      "FlightType"        => $class[0]['flight']['type'],
    );
    
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
    $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
    $this->global_models->update("site_ticket_reservation", array("id_site_ticket_reservation" => $reservation[0]->id_site_ticket_reservation), array("kirim1" => json_encode($kirim)));
    $hasil_json = json_decode($hasil);
    
    if($flight2){
      $kirim['Segments'] = $flight2;
      $kirim['FlightType'] = $class2[0]['flight']['type'];
      $hasil2 = $this->curl_mentah($url, $kirim, $header, TRUE);
      $this->global_models->update("site_ticket_reservation", array("id_site_ticket_reservation" => $reservation[0]->id_site_ticket_reservation), array("kirim2" => json_encode($kirim)));
      $hasil_json2 = json_decode($hasil);
    }
    
    if($hasil_json2 AND $class2){
      if($hasil_json2->PnrId){
        $this->global_models->generate_id($id_site_ticket_reservation_progress2, "site_ticket_reservation_progress");
        $progress = array(
          "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress2,
          "id_site_ticket_reservation"          => $reservation[0]->id_site_ticket_reservation,
          "pnrid"           => $hasil_json2->PnrId,
          "progress"        => 0,
          "text"            => "Create",
          "order"           => 3,
          "type"            => 1,
          "status"          => 1,
          "note"            => $hasil,
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("site_ticket_reservation_progress", $progress);
        $return = array(
          "status"  => 2,
          "id"      => $id_site_ticket_reservation_progress2,
          "pnrid"   => $hasil_json2->PnrId,
        );
      }
      else{
        $return = array(
          "status"  => 3,
          "debug"   => $kirim,
          "note"    => $hasil,
          "token"   => $token,
        );
      }
    }
    if($hasil_json AND $class){
      if($hasil_json->PnrId){
        $this->global_models->generate_id($id_site_ticket_reservation_progress, "site_ticket_reservation_progress");
        $progress = array(
          "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress,
          "id_site_ticket_reservation"          => $reservation[0]->id_site_ticket_reservation,
          "pnrid"           => $hasil_json->PnrId,
          "progress"        => 0,
          "text"            => "Create",
          "order"           => 1,
          "type"            => 1,
          "status"          => 1,
          "note"            => $hasil,
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("site_ticket_reservation_progress", $progress);
        $return = array(
          "status"  => 2,
          "id"      => $id_site_ticket_reservation_progress,
          "pnrid"   => $hasil_json->PnrId,
        );
      }
      else{
        $return = array(
          "status"  => 3,
          "debug"   => $kirim,
          "note"    => $hasil,
          "token"   => $token,
        );
      }
    }
    else{
      $return = array(
        "status"  => 3,
        "debug"   => $kirim,
        "note"    => $hasil,
        "token"   => $token,
      );
    }
    
    return $return;
  }
  
  private function generate_id(&$id){
    $idw = trim($this->getGUID(), "{}");
    $cek = $this->global_models->get_field("site_ticket_available_progress", "id_site_ticket_available_progress", array("id_site_ticket_available_progress" => $idw));
    if($cek){
      $this->generate_id($id);
    }
    else{
      $id = $idw;
    }
  }
  
  private function getGUID(){
    if (function_exists('com_create_guid')){
      return com_create_guid();
    }
    else{
      mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
      $charid = strtoupper(md5(uniqid(rand(), true)));
      $hyphen = chr(45);// "-"
      $uuid = chr(123)// "{"
          .substr($charid, 0, 8).$hyphen
          .substr($charid, 8, 4).$hyphen
          .substr($charid,12, 4).$hyphen
          .substr($charid,16, 4).$hyphen
          .substr($charid,20,12)
          .chr(125);// "}"
      return $uuid;
    }
  }
  
  function token(){
    $kirim = array(
      "grant_type"    => $this->grant_type,
      "client_id"     => $this->client_id,
      "client_secret" => $this->client_secret,
      "scope"         => $this->scope
    );
    $header = array(
      "Content-Type: application/x-www-form-urlencoded"
    );
    $hasil = $this->curl_mentah($this->server_token, $kirim, $header);
    $hasil_json = json_decode($hasil);
    if($hasil_json->access_token){
      $return = array(
        "status"  => 2,
        "data"    => array(
          "token" => $hasil_json->access_token
        )
      );
    }
    else{
      $return = array(
        "status"  => 3,
        "note"    => $hasil_json
      );
    }
    
    return $return;
  }
  
  function curl_mentah($url, $pst, $header = NULL, $json = FALSE){
    $ch = curl_init();
    if($header)
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    if($json == TRUE)
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pst));
    else
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pst));
    $hasil = curl_exec($ch);
//    print_r(curl_getinfo($ch));
    curl_close($ch);
//    print_r('asas');
    return $hasil;
  }
  
	function book($token, $pst){
		$kirim = array(
      "Airline"   => $pst['airline'],
      "Adult"     => $pst['adult'],
      "Child"     => $pst['child'],
      "Infant"    => $pst['infant'],
      "ClassId"   => $pst['classid'],
      "FlightId"  => $pst['flightid'],
      "Fare"      => $pst['fare'],
      "Tax"       => $pst['tax'],
    );
    $header = array(
      "Content-Type: application/json",
      "Authorization: Bearer {$token}"
    );
    $hasil = $this->curl_mentah($this->server."/FareDetail", $kirim, $header, TRUE);
    $hasil_json = json_decode($hasil);
    
    if($hasil_json){
      $return = array(
        "status"  => 2,
        "data"    => $hasil_json,
      );
    }
    else{
      $return = array(
        "status"  => 3,
        "debug"   => $hasil,
        "note"    => $hasil_json,
      );
    }
    
    return $return;
	}
  
  function reservation_cancel($kode){
    $url = $this->server."/apiv3/CancelRsvFlight";
    $data = $this->global_models->get("site_ticket_reservation", array("code" => $kode));
    $flight = $this->global_models->get("site_ticket_reservation_flight", array("status" => 1, "id_site_ticket_reservation" => $data[0]->id_site_ticket_reservation));
    foreach ($flight AS $flg){
      $header = array(
        "Content-Type: application/json",
        "Authorization: Bearer {$token}"
      );
      $kirim['PnrId'] = $flg->id;
      $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
      $hasil_json = json_decode($hasil);
    }
    $return = array(
      "status"      => 2,
      "note"        => $hasil_json,
      "detail"      => $this->reservation_detail($kode)
    );
    return $return;
  }
  
  function issued_api($token, $data){
    $url = $this->server."/apiv3/IssueRsvFlight";
    
    $flight = $this->global_models->get("site_ticket_reservation_flight", array("id_site_ticket_reservation" => $data[0]->id_site_ticket_reservation));
    $block = array();
    foreach ($flight AS $flg){
      if(!in_array($flg->id, $block)){
        $block[] = $flg->id;
        
        $this->global_models->generate_id($id_site_ticket_issued_progress, "site_ticket_issued_progress");
        $progress = array(
          "id_site_ticket_reservation_progress" => $id_site_ticket_issued_progress,
          "id_site_ticket_reservation"          => $data[0]->id_site_ticket_reservation,
          "id_site_ticket_reservation_flight"   => $flg->id_site_ticket_reservation_flight,
          "pnrid"           => $flg->id,
          "progress"        => 0,
          "text"            => "Create",
          "type"            => 1,
          "status"          => 1,
          "note"            => $hasil,
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("site_ticket_issued_progress", $progress);
        
        $header = array(
          "Content-Type: application/json",
          "Authorization: Bearer {$token}"
        );
        $kirim = array(
          "PnrId"       => $flg->id,
          "CallbackUri" => site_url("site/issued-flight")
        );
        $hasil = $this->curl_mentah($url, $kirim, $header, TRUE);
        $hasil_json = json_decode($hasil);
      }
    }
    
//    $return = array(
//      "status"  => 2,
//      "id"      => $id_site_ticket_reservation_progress,
//      "id2"     => $id_site_ticket_reservation_progress2,
//      "pnrid"   => $hasil_json->PnrId,
//      "pnrid2"  => $hasil_json2->PnrId,
//    );
//    $return = array(
//      "status"  => 3,
//      "debug"   => $kirim,
//      "note"    => $hasil,
//      "token"   => $token,
//    );
    
    return $return;
  }
  
  function issued($token, $pnrid){
    $data = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_reservation AS A"
      . " WHERE A.code = '{$pnrid}'"
      . " ORDER BY A.create_date DESC LIMIT 0,1");
//    issued API
//    $this->issued_api($token, $data);  
//    issued local
    $kirim = array(
      "status"          => 2,
      "update_by_users" => $this->session->userdata("id")
    );
    $this->global_models->update("site_ticket_reservation", array("id_site_ticket_reservation" => $data[0]->id_site_ticket_reservation), $kirim);
    $hasil = array(
      "status"    => 2
    );
    return $hasil;
  }
	
}
?>
