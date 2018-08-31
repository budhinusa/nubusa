<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller {
    
  function __construct() {
//    $this->menu = $this->cek();
    $this->load->model('site/m_site');
    if($this->session->userdata('lng'))
      $this->lang->load($this->session->userdata('lng'));
  }
  
  function detail(){
    $this->load->model("site/m_opsigo");
    $token = $this->m_opsigo->token();
    
    $pst = array(
      'airline'   => 2,
      'adult'     => 1,
      'child'     => 0,
      "infant"    => 0,
      "classid"   => 'fb7a1153-66bb-4873-a6e5-222f69444264',
      "flightid"  => '1614d3aa-2da5-46dc-98d1-7683195b71e2',
      "fare"      => 470000,
      "tax"       => 102000,
    );
    
    if($token['status'] == 2){
      $availability = $this->m_opsigo->detail($token['data']['token'], $pst);
    }
    $this->debug($availability, true);
  }
  
  function availability(){
    
    $this->load->model("site/m_sitediscount");
    $this->debug($this->m_sitediscount->discount_depan(), true);
    
    $this->load->model("site/m_opsigo");
    $token = $this->m_opsigo->token();
    
    $route = array(
      "origin"      => "CGK",
      "destination" => "DPS",
    );
    $pax = array(
      "adult"   => 1,
      "child"   => 0,
      "infant"  => 0,
    );
    if($token['status'] == 2){
      $availability = $this->m_opsigo->availability($token['data']['token'], $route, $pax, 2, 2, "2017-10-28");
    }
    $this->debug($availability);
    $this->debug(json_decode($availability), true);
  }
  
  function test(){
      $data = json_decode('[{"Origin":"CGK","Destination":"DPS","IsInternational":false,"Flights":[{"Id":"QG~ 856~ ~~CGK~10/26/2017 04:55~DPS~10/26/2017 07:55~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 856","Origin":"CGK","Destination":"DPS","Fare":643500.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"04:55","ArriveDate":"2017-10-26","ArriveTime":"07:55","TotalTransit":0,"ClassObjects":[{"Id":"0~N~~N~RGFR~~1~X","FlightId":"QG~ 856~ ~~CGK~10/26/2017 04:55~DPS~10/26/2017 07:55~","Code":"N","Category":"Economy","Seat":8,"Fare":643500.0000,"Tax":119350.000,"FareBasisCode":"N"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 850~ ~~CGK~10/26/2017 07:35~DPS~10/26/2017 10:25~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 850","Origin":"CGK","Destination":"DPS","Fare":1400000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"07:35","ArriveDate":"2017-10-26","ArriveTime":"10:25","TotalTransit":0,"ClassObjects":[{"Id":"0~A~~A~RGFR~~1~X","FlightId":"QG~ 850~ ~~CGK~10/26/2017 07:35~DPS~10/26/2017 10:25~","Code":"A","Category":"Economy","Seat":9,"Fare":1400000.0000,"Tax":195000.000,"FareBasisCode":"A"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 854~ ~~CGK~10/26/2017 11:40~DPS~10/26/2017 14:40~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 854","Origin":"CGK","Destination":"DPS","Fare":643500.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"11:40","ArriveDate":"2017-10-26","ArriveTime":"14:40","TotalTransit":0,"ClassObjects":[{"Id":"0~N~~N~RGFR~~1~X","FlightId":"QG~ 854~ ~~CGK~10/26/2017 11:40~DPS~10/26/2017 14:40~","Code":"N","Category":"Economy","Seat":8,"Fare":643500.0000,"Tax":119350.000,"FareBasisCode":"N"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~9743~ ~~CGK~10/26/2017 13:20~DPS~10/26/2017 16:20~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 9743","Origin":"CGK","Destination":"DPS","Fare":490000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"13:20","ArriveDate":"2017-10-26","ArriveTime":"16:20","TotalTransit":0,"ClassObjects":[{"Id":"0~P~~P~RGFR~~1~X","FlightId":"QG~9743~ ~~CGK~10/26/2017 13:20~DPS~10/26/2017 16:20~","Code":"P","Category":"Economy","Seat":9,"Fare":490000.0000,"Tax":104000.000,"FareBasisCode":"P"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 852~ ~~CGK~10/26/2017 16:40~DPS~10/26/2017 19:40~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 852","Origin":"CGK","Destination":"DPS","Fare":423000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"16:40","ArriveDate":"2017-10-26","ArriveTime":"19:40","TotalTransit":0,"ClassObjects":[{"Id":"0~Q~~Q~RGFR~~2~X","FlightId":"QG~ 852~ ~~CGK~10/26/2017 16:40~DPS~10/26/2017 19:40~","Code":"Q","Category":"Economy","Seat":6,"Fare":423000.0000,"Tax":97300.000,"FareBasisCode":"Q"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 858~ ~~CGK~10/26/2017 18:25~DPS~10/26/2017 21:00~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 858","Origin":"CGK","Destination":"DPS","Fare":490000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"18:25","ArriveDate":"2017-10-26","ArriveTime":"21:00","TotalTransit":0,"ClassObjects":[{"Id":"0~P~~P~RGFR~~1~X","FlightId":"QG~ 858~ ~~CGK~10/26/2017 18:25~DPS~10/26/2017 21:00~","Code":"P","Category":"Economy","Seat":9,"Fare":490000.0000,"Tax":104000.000,"FareBasisCode":"P"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 815~ ~~CGK~10/26/2017 04:10~SUB~10/26/2017 05:35~^QG~ 642~ ~~SUB~10/26/2017 07:55~DPS~10/26/2017 09:45~","Airline":4,"AirlineImageUrl":null,"AirlineName":null,"Number":"QG 815 / QG 642","Origin":"CGK","Destination":"DPS","Fare":961500.0000,"IsMultiClass":true,"IsConnecting":true,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"04:10","ArriveDate":"2017-10-26","ArriveTime":"09:45","TotalTransit":1,"ClassObjects":null,"ConnectingFlights":[{"Id":"QG~ 815~ ~~CGK~10/26/2017 04:10~SUB~10/26/2017 05:35~^QG~ 642~ ~~SUB~10/26/2017 07:55~DPS~10/26/2017 09:45~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 815","Origin":"CGK","Destination":"SUB","Fare":351000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"04:10","ArriveDate":"2017-10-26","ArriveTime":"05:35","TotalTransit":0,"ClassObjects":[{"Id":"2~P~~P~RGFR~~1~X","FlightId":"QG~ 815~ ~~CGK~10/26/2017 04:10~SUB~10/26/2017 05:35~^QG~ 642~ ~~SUB~10/26/2017 07:55~DPS~10/26/2017 09:45~","Code":"P","Category":"Economy","Seat":5,"Fare":961500.0,"Tax":156150.0,"FareBasisCode":"P"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 815~ ~~CGK~10/26/2017 04:10~SUB~10/26/2017 05:35~^QG~ 642~ ~~SUB~10/26/2017 07:55~DPS~10/26/2017 09:45~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 642","Origin":"SUB","Destination":"DPS","Fare":610500.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"07:55","ArriveDate":"2017-10-26","ArriveTime":"09:45","TotalTransit":0,"ClassObjects":[{"Id":"1~B~~B~RGFR~~1~","FlightId":"QG~ 815~ ~~CGK~10/26/2017 04:10~SUB~10/26/2017 05:35~^QG~ 642~ ~~SUB~10/26/2017 07:55~DPS~10/26/2017 09:45~","Code":"P","Category":"Economy","Seat":5,"Fare":0.0,"Tax":0.0,"FareBasisCode":"P"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null}],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 811~ ~~CGK~10/26/2017 05:55~SUB~10/26/2017 07:25~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":null,"AirlineName":null,"Number":"QG 811 / QG 644","Origin":"CGK","Destination":"DPS","Fare":1009500.0000,"IsMultiClass":true,"IsConnecting":true,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"05:55","ArriveDate":"2017-10-26","ArriveTime":"15:25","TotalTransit":1,"ClassObjects":null,"ConnectingFlights":[{"Id":"QG~ 811~ ~~CGK~10/26/2017 05:55~SUB~10/26/2017 07:25~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 811","Origin":"CGK","Destination":"SUB","Fare":465000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"05:55","ArriveDate":"2017-10-26","ArriveTime":"07:25","TotalTransit":0,"ClassObjects":[{"Id":"2~O~~O~RGFR~~1~X","FlightId":"QG~ 811~ ~~CGK~10/26/2017 05:55~SUB~10/26/2017 07:25~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Code":"O","Category":"Economy","Seat":9,"Fare":1009500.0,"Tax":160950.0,"FareBasisCode":"O"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 811~ ~~CGK~10/26/2017 05:55~SUB~10/26/2017 07:25~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 644","Origin":"SUB","Destination":"DPS","Fare":544500.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"12:55","ArriveDate":"2017-10-26","ArriveTime":"15:25","TotalTransit":0,"ClassObjects":[{"Id":"1~E~~E~RGFR~~1~","FlightId":"QG~ 811~ ~~CGK~10/26/2017 05:55~SUB~10/26/2017 07:25~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Code":"O","Category":"Economy","Seat":9,"Fare":0.0,"Tax":0.0,"FareBasisCode":"O"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null}],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 801~ ~~CGK~10/26/2017 07:45~SUB~10/26/2017 09:15~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":null,"AirlineName":null,"Number":"QG 801 / QG 644","Origin":"CGK","Destination":"DPS","Fare":1009500.0000,"IsMultiClass":true,"IsConnecting":true,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"07:45","ArriveDate":"2017-10-26","ArriveTime":"15:25","TotalTransit":1,"ClassObjects":null,"ConnectingFlights":[{"Id":"QG~ 801~ ~~CGK~10/26/2017 07:45~SUB~10/26/2017 09:15~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 801","Origin":"CGK","Destination":"SUB","Fare":465000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"07:45","ArriveDate":"2017-10-26","ArriveTime":"09:15","TotalTransit":0,"ClassObjects":[{"Id":"2~O~~O~RGFR~~1~X","FlightId":"QG~ 801~ ~~CGK~10/26/2017 07:45~SUB~10/26/2017 09:15~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Code":"O","Category":"Economy","Seat":9,"Fare":1009500.0,"Tax":160950.0,"FareBasisCode":"O"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 801~ ~~CGK~10/26/2017 07:45~SUB~10/26/2017 09:15~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 644","Origin":"SUB","Destination":"DPS","Fare":544500.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"12:55","ArriveDate":"2017-10-26","ArriveTime":"15:25","TotalTransit":0,"ClassObjects":[{"Id":"1~E~~E~RGFR~~1~","FlightId":"QG~ 801~ ~~CGK~10/26/2017 07:45~SUB~10/26/2017 09:15~^QG~ 644~ ~~SUB~10/26/2017 12:55~DPS~10/26/2017 15:25~","Code":"O","Category":"Economy","Seat":9,"Fare":0.0,"Tax":0.0,"FareBasisCode":"O"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null}],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 803~ ~~CGK~10/26/2017 11:55~SUB~10/26/2017 13:25~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":null,"AirlineName":null,"Number":"QG 803 / QG 646","Origin":"CGK","Destination":"DPS","Fare":775500.0001,"IsMultiClass":true,"IsConnecting":true,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"11:55","ArriveDate":"2017-10-26","ArriveTime":"20:05","TotalTransit":1,"ClassObjects":null,"ConnectingFlights":[{"Id":"QG~ 803~ ~~CGK~10/26/2017 11:55~SUB~10/26/2017 13:25~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 803","Origin":"CGK","Destination":"SUB","Fare":465000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"11:55","ArriveDate":"2017-10-26","ArriveTime":"13:25","TotalTransit":0,"ClassObjects":[{"Id":"0~K~~K~RGFR~~1~X","FlightId":"QG~ 803~ ~~CGK~10/26/2017 11:55~SUB~10/26/2017 13:25~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Code":"K","Category":"Economy","Seat":9,"Fare":841500.0,"Tax":144150.0,"FareBasisCode":"K"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 803~ ~~CGK~10/26/2017 11:55~SUB~10/26/2017 13:25~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 646","Origin":"SUB","Destination":"DPS","Fare":0.0001,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"18:10","ArriveDate":"2017-10-26","ArriveTime":"20:05","TotalTransit":0,"ClassObjects":[{"Id":"0~K~~K~RGFR~~1~X","FlightId":"QG~ 803~ ~~CGK~10/26/2017 11:55~SUB~10/26/2017 13:25~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Code":"K","Category":"Economy","Seat":9,"Fare":0.0,"Tax":0.0,"FareBasisCode":"K"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null}],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 805~ ~~CGK~10/26/2017 13:40~SUB~10/26/2017 15:10~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":null,"AirlineName":null,"Number":"QG 805 / QG 646","Origin":"CGK","Destination":"DPS","Fare":775500.0001,"IsMultiClass":true,"IsConnecting":true,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"13:40","ArriveDate":"2017-10-26","ArriveTime":"20:05","TotalTransit":1,"ClassObjects":null,"ConnectingFlights":[{"Id":"QG~ 805~ ~~CGK~10/26/2017 13:40~SUB~10/26/2017 15:10~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 805","Origin":"CGK","Destination":"SUB","Fare":465000.0000,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"13:40","ArriveDate":"2017-10-26","ArriveTime":"15:10","TotalTransit":0,"ClassObjects":[{"Id":"0~K~~K~RGFR~~1~X","FlightId":"QG~ 805~ ~~CGK~10/26/2017 13:40~SUB~10/26/2017 15:10~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Code":"K","Category":"Economy","Seat":9,"Fare":841500.0,"Tax":144150.0,"FareBasisCode":"K"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null},{"Id":"QG~ 805~ ~~CGK~10/26/2017 13:40~SUB~10/26/2017 15:10~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Airline":4,"AirlineImageUrl":"http://portalvhds11000v9mfhk0k.blob.core.windows.net/airline/QG-mail.png","AirlineName":"Citilink","Number":"QG 646","Origin":"SUB","Destination":"DPS","Fare":0.0001,"IsMultiClass":false,"IsConnecting":false,"IsAvailable":true,"FlightType":"NonGds","DepartDate":"2017-10-26","DepartTime":"18:10","ArriveDate":"2017-10-26","ArriveTime":"20:05","TotalTransit":0,"ClassObjects":[{"Id":"0~K~~K~RGFR~~1~X","FlightId":"QG~ 805~ ~~CGK~10/26/2017 13:40~SUB~10/26/2017 15:10~^QG~ 646~ ~~SUB~10/26/2017 18:10~DPS~10/26/2017 20:05~","Code":"K","Category":"Economy","Seat":9,"Fare":0.0,"Tax":0.0,"FareBasisCode":"K"}],"ConnectingFlights":[],"FareBreakdowns":null,"GroupingId":null}],"FareBreakdowns":null,"GroupingId":null}],"HaveUpdate":0}]');
    
    $this->debug($hasil);
    $this->debug($data, true);
  }
  
  function token_get(){
    $pst = array(
      "grant_type"		=> "client_credentials",
      "client_id"			=> "client-cre-testopsigo-va",
      "client_secret"	=> "V@4p1s3cRet",
      "scope"         => "scope-opsigoapi",
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://opsigo-auth.azurewebsites.net/core/connect/token');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pst));
    $hasil_1 = curl_exec($ch);
    curl_close($ch);

    return json_decode($hasil_1);
  }
  
  function change_lang($lang){
    $this->session->set_userdata(array("lng" => $lang));
    redirect(site_url($this->input->get("url")));
  }
  
  public function book_confirm_shadow(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    
//    $title = $this->global_variable->title_name();
    $name = explode(" ", $pst['name']);
    foreach ($name AS $key => $nm){
      if($key > 0){
        $last_name .= $nm." ";
      }
    }
    
    $contact = array(
      "email"     => $pst['email'],
      "title"     => $pst['adult_title'][0],
      "firstname" => $name[0],
      "lastname"  => $last_name,
      "telp"      => "0".$pst['telp'],
      "hp"        => "0".$pst['telp']
    );
    foreach ($pst['adult_title'] AS $key_a => $adult_title){
      $name = explode(" ", $pst['adult_name'][$key_a]);
      $last_name = "";
      foreach ($name AS $key => $nm){
        if($key > 0){
          $last_name .= $nm." ";
        }
      }
    
      $passangers[] = array(
        'type'          => 1,
        'title'         => $adult_title,
        'firstname'     => $name[0],
        'lastname'      => $last_name,
        'birthdate'     => "1987-12-16",
        'email'         => $pst['email'],
        'telp'          => "0".$pst['telp'],
        'hp1'           => "0".$pst['telp'],
        'hp2'           => "0".$pst['telp'],
        'id'            => NULL,
        'nationality'   => ($pst['adult_nationality'][$key_a] ? $pst['adult_nationality'][$key_a] : "ID"),
        'assoc'         => NULL,
        'passport'      => array(
          'expire'        => $pst['adult_pass_expire'][$key_a],
          'number'        => $pst['adult_pass_number'][$key_a],
          'origin'        => $pst['adult_pass_origin'][$key_a],
        ),
      );
    }
    
    foreach ($pst['child_title'] AS $key_c => $child_title){
      $name = explode(" ", $pst['child_name'][$key_c]);
      $last_name = "";
      foreach ($name AS $key => $nm){
        if($key > 0){
          $last_name .= $nm." ";
        }
      }
    
      $passangers[] = array(
        'type'          => 2,
        'title'         => $child_title,
        'firstname'     => $name[0],
        'lastname'      => $last_name,
        'birthdate'     => $pst['child_date'][$key_c],
        'email'         => $pst['email'],
        'telp'          => "0".$pst['telp'],
        'hp1'           => "0".$pst['telp'],
        'hp2'           => "0".$pst['telp'],
        'id'            => NULL,
        'nationality'   => ($pst['child_nationality'][$key_c] ? $pst['child_nationality'][$key_c] : "ID"),
        'assoc'         => NULL,
        'passport'      => array(
          'expire'        => $pst['child_pass_expire'][$key_c],
          'number'        => $pst['child_pass_number'][$key_c],
          'origin'        => $pst['child_pass_origin'][$key_c],
        ),
      );
    }
    
    foreach ($pst['infant_title'] AS $key_i => $infant_title){
      $name = explode(" ", $pst['infant_name'][$key_i]);
      $last_name = "";
      foreach ($name AS $key => $nm){
        if($key > 0){
          $last_name .= $nm." ";
        }
      }
    
      $passangers[] = array(
        'type'          => 3,
        'title'         => $child_title,
        'firstname'     => $name[0],
        'lastname'      => $last_name,
        'birthdate'     => $pst['infant_date'][$key_i],
        'email'         => $pst['email'],
        'telp'          => "0".$pst['telp'],
        'hp1'           => "0".$pst['telp'],
        'hp2'           => "0".$pst['telp'],
        'id'            => NULL,
        'nationality'   => ($pst['infant_nationality'][$key_i] ? $pst['infant_nationality'][$key_i] : "ID"),
        'assoc'         => $pst['infant_assoc'][$key_i],
        'passport'      => array(
          'expire'        => $pst['infant_pass_expire'][$key_i],
          'number'        => $pst['infant_pass_number'][$key_i],
          'origin'        => $pst['infant_pass_origin'][$key_i],
        ),
      );
    }
    
    $round = $pst['type'];
    
    foreach ($pst['dep_flightnumber'] AS $key_dep => $fnumber){
      $segments["departure"][] = array(
        'class'           => array(
          'id'              => $pst['dep_classid'][$key_dep],
          "code"            => $pst['dep_classcode'][$key_dep],
          "fare"            => $pst['dep_fare'][$key_dep],
          "tax"             => $pst['dep_tax'][$key_dep],
        ),
        'airline'         => $pst['dep_airline'][$key_dep],
        'flight'          => array(
          'number'          => $fnumber,
          'id'              => $pst['dep_flightid'][$key_dep]
        ),
        'departure'       => array(
          'code'            => $pst['dep_departure'][$key_dep],
          'date'            => $pst['dep_departuredate'][$key_dep],
        ),
        'arrive'          => array(
          'code'            => $pst['dep_arrival'][$key_dep],
          'date'            => $pst['dep_arrivaldate'][$key_dep],
        ),
      );
    }
    
    foreach ($pst['arr_flightnumber'] AS $key_arr => $fnumber){
      $segments["return"][] = array(
        'class'           => array(
          'id'              => $pst['arr_classid'][$key_arr],
          "code"            => $pst['arr_classcode'][$key_arr],
          "fare"            => $pst['arr_fare'][$key_arr],
          "tax"             => $pst['arr_tax'][$key_arr],
        ),
        'airline'         => $pst['arr_airline'][$key_arr],
        'flight'          => array(
          'number'          => $fnumber,
          'id'              => $pst['arr_flightid'][$key_arr]
        ),
        'departure'       => array(
          'code'            => $pst['arr_departure'][$key_arr],
          'date'            => $pst['arr_departuredate'][$key_arr],
        ),
        'arrive'          => array(
          'code'            => $pst['arr_arrival'][$key_arr],
          'date'            => $pst['arr_arrivaldate'][$key_arr],
        ),
      );
    }
    
    $fields['opsigo']['flighttype'] = $pst['flighttype'];
    
//    $this->debug($pst);
//    $this->debug($contact);
//    $this->debug($passangers, true);
//    $this->debug($segments);
//    $this->debug($fields, true);
    
    $this->load->model("site/m_opsigo");
    $book = array(
      "origin"      => $pst['awal_departure'],
      "destination" => $pst['awal_arrival'],
      "adult"       => $pst['adult'],
      "child"       => $pst['child'],
      "infant"      => $pst['infant'],
      "departuredate" => $pst['awal_departuredate'],
      "returndate"  => $pst['awal_returndate'],
    );
    $reservation = $this->m_opsigo->reservation($contact, $book, $round);
//    $this->debug($reservation, true);
    
    if($reservation['reservation']['id']){
      $token = $this->m_opsigo->token();

      if($token['status'] == 2){
        $book = $this->m_opsigo->reservation_flight($token['data']['token'], $reservation, $passangers, $segments, $fields);
      }
    }
//    $this->debug($book);
//    $this->debug($reservation, true);
//    $this->debug($book, true);
    if($reservation['status'] == 2){
      redirect("site/book-confirm/{$reservation['reservation']['code']}");
    }
    else{
      redirect("site/book-fail");
    }
    
  }
  
  private function _passanger($pax, $id_crm_customer, $id_site_travel_book){
    foreach ($pax AS $px){
      $id_site_travel_passangers = $this->global_models->get_field("site_travel_passangers", "id_site_travel_passangers", array(
        "id_crm_customer"       => $id_crm_customer,
        "firstname"             => $px['firstname'],
        "lastname"              => $px['lastname'],
        "type"                  => $px['type'],
        "birthdate"             => $px['birthdate'],
        "title"                 => $px['title'],
      ));
      if(!$id_site_travel_passangers){
        $this->global_models->generate_id($id_site_travel_passangers, "site_travel_passangers");
        $kirim = array(
          "id_site_travel_passangers"   => $id_site_travel_passangers,
          "id_crm_customer"             => $id_crm_customer,
          "title"                       => $px['title'],
          "firstname"                   => $px['firstname'],
          "lastname"                    => $px['lastname'],
          "birthdate"                   => $px['birthdate'],
          "type"                        => $px['type'],
          "create_by_users"             => $this->session->userdata("id"),
          "create_date"                 => date("Y-m-d H:i:s"),
        );
        $this->global_models->insert("site_travel_passangers", $kirim);
      }
      $this->global_models->generate_id($id_site_travel_book_passangers, "site_travel_book_passangers");
      $kirim = array(
        "id_site_travel_passangers"   => $id_site_travel_passangers,
        "title"                       => $px['title'],
        "firstname"                   => $px['firstname'],
        "lastname"                    => $px['lastname'],
        "birthdate"                   => $px['birthdate'],
        "type"                        => $px['type'],
        "assoc"                       => $px['assoc'],
        "id_site_travel_book"         => $id_site_travel_book,
        "id_site_travel_book_passangers" => $id_site_travel_book_passangers,
        "create_by_users"             => $this->session->userdata("id"),
        "create_date"                 => date("Y-m-d H:i:s"),
      );
      
      $this->global_models->insert("site_travel_book_passangers", $kirim);
    }
    return true;
  }
  
  private function _format_date($date, $sper = "/"){
    $temp = explode($sper, $date);
    return $temp[2]."-{$temp[1]}-{$temp[0]}";
  }
  
  private function _first_last_name($name){
    $temp = explode(" ", $name);
    $tp = "";
    foreach ($temp AS $key => $tp){
      if($key == 0)
        $first = $tp;
      else
        $last .= $tp." ";
    }
    if(!$last)
      $last = $first;
    return array("first" => $first, "last" => $last);
  }
  
  private function _customer_set($simpan){
    $id_crm_customer = $this->global_models->get_field("crm_customer", "id_crm_customer", array("email" => $simpan['email']));
    if(!$id_crm_customer){
      $this->global_models->generate_id($id_crm_customer, "crm_customer");
      $simpan['id_crm_customer'] = $id_crm_customer;
      $simpan['create_by_users'] = $this->session->userdata("id");
      $simpan['create_date']     = date("Y-m-d H:i:s");
      $this->global_models->insert("crm_customer", $simpan);
    }
    else{
      $simpan['update_by_users'] = $this->session->userdata("id");
      $this->global_models->update("crm_customer", array("id_crm_customer" => $id_crm_customer), $simpan);
    }
    return $id_crm_customer;
  }


  function generate_nomor(&$nomor){
    $nomor = random_string('numeric', 10);
    $cek = $this->global_models->get_field("site_travel_book", "id_site_travel_book", array("number" => $nomor));
    if($cek){
      $this->generate_nomor($nomor);
    }
  }
  
  public function payment_result($kode){
    $book = $this->global_models->get("site_travel_book", array("number" => $kode));
    $pnrid = $book[0]->pnrid;
    $pay = $this->global_models->get("site_travel_book_pay", array("id_site_travel_book" => $book[0]->id_site_travel_book));
//    $this->debug($book, TRUE);
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, SERVERGA."detailserver2/{$pnrid}");

    $headers = array();
    $headers[] = 'username: internal';
    $headers[] = 'sandi: data';
    $headers[] = 'Content-Type: application/json';

    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true); 
//    curl_setopt($ch1, CURLOPT_POST, 1);
//    curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($kirim));
    $hasil = curl_exec($ch1);
    curl_close($ch1);
    $data = json_decode($hasil);
    
//    $this->debug($hasil);
//    $this->debug($data, true);
//    $this->debug($data->data[0]->flight, true);
    
    $css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('payment-result', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'section'     => $section,
        'data'        => $data->data,
        'code'        => $kode,
        'pay'         => $pay,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("payment-result");
  }
  
  function _proses_payment_credit_mega_infinite($tiket){
//    $mid = array(
//      2 => '',
//      3 => '201504003102',
//      4 => '201504003301',
//    );
    $angka1 = md5(rand(11111, 99999));
    $angka2 = md5(rand(11111, 99999));
    $ref_auto = rand(11111, 99999);
    $jml_angka = strlen($tiket['id_crm_payment_channel']);
    
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/mv/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201504003102'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-result/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".str_replace("https", "http", site_url("site/cek-cc-bank"))."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/payget/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201402000501'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-finish/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".site_url("site/cek-cc-bank")."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    print $hasil;
    print '<script>
function myFunction() {
    document.getElementById("bankcc").submit();
}
myFunction();
</script>';
    die;
  }
  
  function _proses_payment_credit_mega($tiket){
//    $mid = array(
//      2 => '',
//      3 => '201504003102',
//      4 => '201504003301',
//    );
    $angka1 = md5(rand(11111, 99999));
    $angka2 = md5(rand(11111, 99999));
    $ref_auto = rand(11111, 99999);
    $jml_angka = strlen($tiket['id_crm_payment_channel']);
    
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/mv/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201504003201'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-result/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".str_replace("https", "http", site_url("site/cek-cc-bank"))."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/payget/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201402000501'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-finish/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".site_url("site/cek-cc-bank")."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    print $hasil;
    print '<script>
function myFunction() {
    document.getElementById("bankcc").submit();
}
myFunction();
</script>';
    die;
  }
  
  function _proses_payment_bca($tiket){
    
  }
  
  function _proses_payment_credit_visa($tiket){
//    $mid = array(
//      2 => '',
//      3 => '201504003102',
//      4 => '201504003301',
//    );
    $angka1 = md5(rand(11111, 99999));
    $angka2 = md5(rand(11111, 99999));
    $ref_auto = rand(11111, 99999);
    $jml_angka = strlen($tiket['id_crm_payment_channel']);
    
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/mv/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201504003301'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-result/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".str_replace("https", "http", site_url("site/cek-cc-bank"))."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/payget/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='201402000501'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket['book_code']}-{$ref_auto}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($tiket['bayar'], 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket['book_code']."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket['id_crm_payment_channel']."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$tiket['id_site_ticket_payment']."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("site/book-finish/{$tiket['book_code']}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".site_url("site/cek-cc-bank")."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    print $hasil;
    print '<script>
function myFunction() {
    document.getElementById("bankcc").submit();
}
myFunction();
</script>';
    die;
  }
  
  public function book_payment(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $this->load->model("site/m_opsigo");
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
    $pnrid                    = $pst['pnrid'];
    $id_crm_payment_channel   = $pst['id_crm_payment_channel'];
    
    $reservation = $this->m_opsigo->reservation_cek($pnrid);
    $book = $this->global_models->get("site_ticket_reservation", array("code" => $pnrid));
    
    $total = 0;
    $airline = array();
    $timelimit = NULL;
    $this->m_site->limit_flight_get($timelimit, $total, $reservation);
    
    $harga_tampil = $total;
    $pst['whitelist'] = $whitelist;
    if($discount_depan['status'] == 2){
      $id_discount = "";
      foreach ($discount_depan['data']['discount'] AS $disc){
        if($disc['is_payment_channel'] == 2){
          $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
          $id_discount = $disc['id'];
        }
        else{
          foreach ($disc['payment_channel'] AS $dpc){
            if($pst['whitelist'][$dpc['id']]){
              $reguler = $this->global_fungsi->diskon($disc['nilai'], $total);
              $id_discount = $disc['id'];
              unset($pst['whitelist'][$dpc['id']]);
            }
          }
        }
      }
    }
    
//    $this->debug($pst);
//    $this->debug($reservation);
//    $this->debug($discount_depan);
//    $this->debug($reguler);
//    $this->debug(date("Y-m-d H:i:s", $timelimit), true);
    $this->global_models->trans_begin();
    $this->global_models->update("site_ticket_payment", array("id_site_ticket_reservation" => $book[0]->id_site_ticket_reservation), array("status" => 3));
    $this->global_models->update("site_ticket_payment_discount", array("id_site_ticket_reservation" => $book[0]->id_site_ticket_reservation), array("status" => 3));
    
    $payment_methode = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_payment AS A"
      . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
      . " AND A.id_crm_payment_channel = '{$id_crm_payment_channel}'"
      . " ");
    if($payment_methode){
      $id_site_ticket_payment = $payment_methode[0]->id_site_ticket_payment;
      $kirim = array(
        "timelimit"                   => date("Y-m-d H:i:s", $timelimit),
        "nilai"                       => $total,
        "fee"                         => $pst['fee'],
        "pengurangan"                 => ($id_discount ? $reguler['diskon'] : NULL),
        "status"                      => 1,
        "kirim1"                      => $note,
        "update_by_users"             => $this->session->userdata("id"),
      );
      
      $this->global_models->update("site_ticket_payment", array("id_site_ticket_payment" => $id_site_ticket_payment), $kirim);
    }
    else{
      $this->global_models->generate_id($id_site_ticket_payment, "site_ticket_payment");
      $kirim = array(
        "id_site_ticket_payment"      => $id_site_ticket_payment,
        "id_site_ticket_reservation"  => $book[0]->id_site_ticket_reservation,
        "id_crm_payment_channel"      => $id_crm_payment_channel,
        "tanggal"                     => date("Y-m-d H:i:s"),
        "timelimit"                   => date("Y-m-d H:i:s", $timelimit),
        "nilai"                       => $total,
        "fee"                         => $pst['fee'],
        "pengurangan"                 => ($id_discount ? $reguler['diskon'] : NULL),
        "status"                      => 1,
        "kirim1"                      => $note,
        "create_by_users"             => $this->session->userdata("id"),
        "create_date"                 => date("Y-m-d H:i:s")
      );
//      $this->debug($kirim);
      $this->global_models->insert("site_ticket_payment", $kirim);
    }
    
//    cek payment discount voucher
//    jika voucher update nilai pengurangan
    if($pst['id_crm_pos_discount_voucher_use']){
      $this->load->model("crm/m_discount");
      $kirim_voucher = array(
        "id_crm_payment_channel"          => $id_crm_payment_channel,
        "id_crm_pos_discount_voucher_use" => $pst['id_crm_pos_discount_voucher_use'],
        "nilai"                           => $total,
        "source_table"                    => "site_ticket_reservation",
        "source_id"                       => $book[0]->id_site_ticket_reservation
      );
      $cek_voucher = $this->m_discount->voucher_cek_detail($kirim_voucher);
//      $this->debug($cek_voucher, true);
      if($cek_voucher['status'] == 2){
        $payment_discount = $this->global_models->get_query("SELECT A.*"
        . " FROM site_ticket_payment_discount AS A"
        . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
        . " AND A.id_site_ticket_payment = '{$id_site_ticket_payment}'"
        . " ");
        $reguler['diskon'] = $cek_voucher['nilai'];
        if($payment_discount){
          $id_site_ticket_payment_discount = $payment_discount[0]->id_site_ticket_payment_discount;
          $kirim_discount = array(
            "voucher"                         => $cek_voucher['voucher'],
            "nilai"                           => $cek_voucher['nilai'],
            "id_crm_pos_discount"             => $cek_voucher['id_crm_pos_discount'],
            "status"                          => 1,
            "update_by_users"                 => $this->session->userdata("id"),
          );
          $this->global_models->update("site_ticket_payment_discount", array("id_site_ticket_payment_discount" => $id_site_ticket_payment_discount), $kirim_discount);
        }
        else{
          $this->global_models->generate_id($id_site_ticket_payment_discount, "site_ticket_payment_discount");
          $kirim_discount = array(
            "id_site_ticket_payment_discount" => $id_site_ticket_payment_discount,
            "id_site_ticket_payment"          => $id_site_ticket_payment,
            "id_crm_pos_discount"             => $cek_voucher['id_crm_pos_discount'],
            "id_site_ticket_reservation"      => $book[0]->id_site_ticket_reservation,
            "timelimit"                       => $cek_voucher['timelimit'],
            "nilai"                           => $cek_voucher['nilai'],
            "status"                          => 1,
            "create_by_users"                 => $this->session->userdata("id"),
            "create_date"                     => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("site_ticket_payment_discount", $kirim_discount);
        }
      }
      else{
        if($id_discount){
          $payment_discount = $this->global_models->get_query("SELECT A.*"
          . " FROM site_ticket_payment_discount AS A"
          . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
          . " AND A.id_site_ticket_payment = '{$id_site_ticket_payment}'"
          . " ");
          if($payment_discount){
            $id_site_ticket_payment_discount = $payment_discount[0]->id_site_ticket_payment_discount;
            $kirim_discount = array(
              "id_crm_pos_discount"             => $id_discount,
              "nilai"                           => $reguler['diskon'],
              "status"                          => 1,
              "update_by_users"                 => $this->session->userdata("id"),
            );
            $this->global_models->update("site_ticket_payment_discount", array("id_site_ticket_payment_discount" => $id_site_ticket_payment_discount), $kirim_discount);
          }
          else{
            $this->global_models->generate_id($id_site_ticket_payment_discount, "site_ticket_payment_discount");
            $kirim_discount = array(
              "id_site_ticket_payment_discount" => $id_site_ticket_payment_discount,
              "id_site_ticket_payment"          => $id_site_ticket_payment,
              "id_crm_pos_discount"             => $id_discount,
              "id_site_ticket_reservation"      => $book[0]->id_site_ticket_reservation,
              "timelimit"                       => date("Y-m-d H:i:s", $timelimit),
              "nilai"                           => $reguler['diskon'],
              "status"                          => 1,
              "create_by_users"                 => $this->session->userdata("id"),
              "create_date"                     => date("Y-m-d H:i:s")
            );
            $this->global_models->insert("site_ticket_payment_discount", $kirim_discount);
          }
        }
      }
    }
    else{
      if($id_discount){
        $payment_discount = $this->global_models->get_query("SELECT A.*"
        . " FROM site_ticket_payment_discount AS A"
        . " WHERE A.id_site_ticket_reservation = '{$book[0]->id_site_ticket_reservation}'"
        . " AND A.id_site_ticket_payment = '{$id_site_ticket_payment}'"
        . " ");
        if($payment_discount){
          $id_site_ticket_payment_discount = $payment_discount[0]->id_site_ticket_payment_discount;
          $kirim_discount = array(
            "id_crm_pos_discount"             => $id_discount,
            "nilai"                           => $reguler['diskon'],
            "status"                          => 1,
            "update_by_users"                 => $this->session->userdata("id"),
          );
          $this->global_models->update("site_ticket_payment_discount", array("id_site_ticket_payment_discount" => $id_site_ticket_payment_discount), $kirim_discount);
        }
        else{
          $this->global_models->generate_id($id_site_ticket_payment_discount, "site_ticket_payment_discount");
          $kirim_discount = array(
            "id_site_ticket_payment_discount" => $id_site_ticket_payment_discount,
            "id_site_ticket_payment"          => $id_site_ticket_payment,
            "id_crm_pos_discount"             => $id_discount,
            "id_site_ticket_reservation"      => $book[0]->id_site_ticket_reservation,
            "timelimit"                       => date("Y-m-d H:i:s", $timelimit),
            "nilai"                           => $reguler['diskon'],
            "status"                          => 1,
            "create_by_users"                 => $this->session->userdata("id"),
            "create_date"                     => date("Y-m-d H:i:s")
          );
          $this->global_models->insert("site_ticket_payment_discount", $kirim_discount);
        }
      }
    }
    $this->global_models->trans_commit();
    if($id_crm_payment_channel == '0DSWGQJCJH62FYJQE4B' AND $id_site_ticket_payment){
      $kirim_data = array(
        "id_crm_payment_channel"      => $id_crm_payment_channel,
        "book_code"                   => $pnrid,
        "bayar"                       => ($total - $reguler['diskon']),
        "id_site_ticket_payment"      => $id_site_ticket_payment
      );
//      $this->debug($kirim_data, true);
      $this->_proses_payment_credit_mega_infinite($kirim_data);
    }
    if($id_crm_payment_channel == 'WL3JCKGBQMB76O' AND $id_site_ticket_payment){
      $kirim_data = array(
        "id_crm_payment_channel"      => $id_crm_payment_channel,
        "book_code"                   => $pnrid,
        "bayar"                       => ($total - $reguler['diskon']),
        "id_site_ticket_payment"      => $id_site_ticket_payment
      );
//      $this->debug($kirim_data, true);
      $this->_proses_payment_credit_mega($kirim_data);
    }
    if($id_crm_payment_channel == 'DMAUVOHQZPM3WS7' AND $id_site_ticket_payment){
      $kirim_data = array(
        "id_crm_payment_channel"      => $id_crm_payment_channel,
        "book_code"                   => $pnrid,
        "bayar"                       => ($total - $reguler['diskon']),
        "id_site_ticket_payment"      => $id_site_ticket_payment
      );
//      $this->debug($kirim_data, true);
      $this->_proses_payment_credit_visa($kirim_data);
    }
    if($id_crm_payment_channel == '8STQ0' AND $id_site_ticket_payment){
      $kirim_data = array(
        "id_crm_payment_channel"      => $id_crm_payment_channel,
        "book_code"                   => $pnrid,
        "bayar"                       => ($total - $reguler['diskon']),
        "id_site_ticket_payment"      => $id_site_ticket_payment
      );
//      $this->debug($kirim_data, true);
      $this->_proses_payment_bca($kirim_data);
    }
//    $this->debug($id_site_ticket_payment);
//    $this->debug($id_crm_payment_channel, true);
    die;
  }
  
  function cek_cc_bank(){
    $pst = $this->input->post();
    $id_site_ticket_payment   = $pst['TM_UserField5'];
    $book_code                = $pst['TM_UserField1'];
    $id_crm_payment_channel   = $pst['TM_UserField2'];
    $status                   = $pst['TM_Status'];
    
    $this->global_models->insert("site_log_bank_mega", array(
      "semua"                   => json_encode($pst),
      "note"                    => $pst['TM_Error'], 
      "tanggal"                 => date("Y-m-d H:i:s"), 
      "book_code"               => $book_code,
      "status"                  => $status,
      "id_crm_payment_channel"  => $id_crm_payment_channel,
      "id_site_ticket_payment"  => $id_site_ticket_payment,
    ));
    
//    die;
//    $this->debug($pst, true);
//    $id_tiket_payment = 1;
//    $book_code        = '24P6XG';
//    $type             = 3;
    print "set";
    if($id_site_ticket_payment){
      $site_ticket_payment = $this->global_models->get_query("SELECT A.*"
        . " FROM site_ticket_payment AS A"
        . " WHERE A.id_site_ticket_payment = '{$id_site_ticket_payment}'"
        . " AND A.id_site_ticket_reservation = (SELECT B.id_site_ticket_reservation FROM site_ticket_reservation AS B WHERE B.code = '{$book_code}' ORDER BY B.create_date DESC LIMIT 0,1)");
      if($site_ticket_payment AND trim($status) == "YES"){
        $this->global_models->update("site_ticket_payment", array("id_site_ticket_payment" => $id_site_ticket_payment), array("terima" => $pst['TM_DebitAmt']));
        if($pst['TM_DebitAmt'] >= ($site_ticket_payment[0]->nilai + $site_ticket_payment[0]->fee - $site_ticket_payment[0]->pengurangan)){
          $this->global_models->update("site_ticket_payment", array("id_site_ticket_payment" => $id_site_ticket_payment), array("status" => 2, "update_by_users" => $this->session->userdata("id")));
          
          $this->issue($book_code);
        }
      }
    }
    die;
  }
  
  function cek_pesanan(){
    $pst = $this->input->post();
    if($pst){
      
    }
    $css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('cek-pesanan', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->build("cek-pesanan");
  }
  
  function issue($pnrid){
    $this->load->model("site/m_opsigo");
    $token = $this->m_opsigo->token();
    
    if($token['status'] == 2){
      $result = $this->m_opsigo->issued($token['data']['token'], $pnrid);
    }
    return $result;
  }
  
  public function book_result($kode, $id_crm_payment_channel = NULL){
    $cek = $this->_cek_kondisi($kode);
    if($cek['condition']['finish'] == 2){
      redirect("site/book-finish/{$kode}");
    }
    if($cek['condition']['expired'] == 2){
      redirect("site/book-expired/{$kode}");
    }
    
//    $this->debug($cek, true);
    $this->load->model("site/m_sitediscount");
    $this->load->model("site/m_site");
    $payment_channel = $this->m_site->payment_channel_get();
    $id_crm_payment_channel = ($id_crm_payment_channel ? $id_crm_payment_channel : $payment_channel['data'][0]['id']);
    $discount_depan = $this->m_sitediscount->discount_depan();
    foreach ($payment_channel['data'] AS $pc){
      $whitelist[$pc['id']] = array(
        "title" => $pc['title'],
        "image" => $pc['image']
      );
    }
    
    $book = $cek['book'];
//    $this->debug($payment_channel, true);
//    $this->debug($book,true);
    
    $total = 0;
    $airline = $this->global_variable->site_ticket_airline();
    $hari = $this->global_variable->hari17();
    $title = $this->global_variable->title_name();
    foreach ($book['detail']['flight'] AS $flight){
      $total += $flight[0]['total'];
      foreach ($flight AS $flg){
        $info['departure'] = $this->m_site->bandara_info($flg['origin']);
        $info['arrival'] = $this->m_site->bandara_info($flg['destination']);
        $info_flight .= ""
          . "<figure class='m-t-30'>"
            . "<ol class='list-inline m-b-15'>"
              . "<li><img src='".site_url()."{$airline[$flg['airline']]['image2']}' style='width: 40px' alt=''></li>"
            . "</ol>"
            . "<figcaption>"
              . "<h4 class='m-t-0'>{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})</h4>"
              . "<p>"
                . "<small>{$hari[date("N", strtotime($flg['departdate']))]}, ".date("d F Y", strtotime($flg['departdate']))." </small><br>"
                . "<small>".date("H:i", strtotime($flg['departdate']))." - ".date("H:i", strtotime($flg['arrivaldate']))."</small>"
              . "</p>"
            . "</figcaption>"
          . "</figure>"
          . "";
      }
    }
    
    $info_pax = "";
    foreach ($book['detail']['pax'] AS $pax){
      $info_pax .= "<p>{$pax['title']} {$pax['firstname']} {$pax['lastname']}</p>";
    }
    
    $css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $foot = $this->global_format->framework();
    $foot .= "<script>"
      . "var formvoucher = new Vue({"
        . "el: '#validasi-voucher',"
        . "data: {"
          . "code : ''"
          . ""
        . "}," 
        . "methods: {"
          . "valid: function(){"
            . "$.post('".site_url("site/site-data-ajax/voucher-validation")."', {code: this.code, pnrid: '{$kode}', id_crm_payment_channel: '{$id_crm_payment_channel}'}, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 10001){"
              . "}"
              . "else if(hasil.status == 1 || hasil.status == 3){"
              . "}"
              . "else if(hasil.status == 2){"
                . "$('#crm-pos-discount-voucher-use').val(hasil.id);"
                . "$('#nilai-discount').text('IDR '+hasil.nilai);"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "}"
        . "}"
      . "});"
      . "</script>";
    
    $this->template
      ->set_layout('default')
      ->build('book-result', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'section'     => $section,
        
        'kode'        => $kode,
        "info_flight" => $info_flight,
        "total"       => $total,
        "info_pax"    => $info_pax,
        "payment_channel"    => $payment_channel,
        "code_payment"=> $id_crm_payment_channel,
      ));
    $this->template
      ->set_layout('default')
      ->build("book-result");
  }
  
  function _cek_kondisi($kode){
    $this->load->model("site/m_opsigo");
    $book = $this->m_opsigo->reservation_cek($kode);
//    $this->debug($book, true);
    $payment = $this->global_models->get_query("SELECT A.*"
      . " FROM site_ticket_payment AS A"
      . " WHERE A.id_site_ticket_reservation = '{$book['detail']['bookers']['id']}'"
      . " AND (A.status = 1 OR A.status = 2)"
      . " ");
      
    $status['payment'] = 2;
    $status['finish'] = 3;
    $status['expired'] = 3;
    
    if($payment){
      if(strtotime($payment[0]->timelimit) <= strtotime("NOW")){
        $status['payment'] = 3;
        $status['finish'] = 3;
        $status['expired'] = 2;
      }

      if($payment[0]->status == 2){
        $status['payment'] = 3;
        $status['finish'] = 2;
        $status['expired'] = 3;
      }
    }
    else{
      $tahun = date("Y") + 10;
      $timelimit = strtotime(date("{$tahun}-m-d H:i:s"));
      foreach ($book['detail']['flight'] AS $flight){
        foreach ($flight AS $flg){
          if($flg['timelimit']){
            if($timelimit >= strtotime($flg['timelimit']))
              $timelimit = strtotime($flg['timelimit']);
          }
        }
      }
      if($timelimit < strtotime("NOW")){
        $status['payment'] = 3;
        $status['finish'] = 3;
        $status['expired'] = 2;
      }
    }
    
    $return = array(
      "status"    => 2,
      "book"      => $book,
      "condition" => $status
    );
    
    return $return;
  }

  public function book_finish($kode){
    $cek = $this->_cek_kondisi($kode);
    if($cek['condition']['payment'] == 2){
      redirect("site/book-result/{$kode}");
    }
    if($cek['condition']['expired'] == 2){
      redirect("site/book-expired/{$kode}");
    }
    $this->load->model("site/m_sitediscount");
    $book = $cek['book'];
    
    $total = 0;
    $airline = $this->global_variable->site_ticket_airline();
    $hari = $this->global_variable->hari17();
    $title = $this->global_variable->title_name();
    foreach ($book['detail']['flight'] AS $flight){
      $total += $flight[0]['total'];
      foreach ($flight AS $flg){
        $info['departure'] = $this->m_site->bandara_info($flg['origin']);
        $info['arrival'] = $this->m_site->bandara_info($flg['destination']);
        $info_flight .= ""
          . "<figure class='m-t-30'>"
            . "<ol class='list-inline m-b-15'>"
              . "<li><img src='".site_url()."{$airline[$flg['airline']]['image2']}' style='width: 40px' alt=''></li>"
            . "</ol>"
            . "<figcaption>"
              . "<h4 class='m-t-0'>{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})</h4>"
              . "<p>"
                . "<small>{$hari[date("N", strtotime($flg['departdate']))]}, ".date("d F Y", strtotime($flg['departdate']))." </small><br>"
                . "<small>".date("H:i", strtotime($flg['departdate']))." - ".date("H:i", strtotime($flg['arrivaldate']))."</small>"
              . "</p>"
            . "</figcaption>"
          . "</figure>"
          . "";
      }
    }
    
    $info_pax = "";
    foreach ($book['detail']['pax'] AS $pax){
      $info_pax .= "<p>{$pax['title']} {$pax['firstname']} {$pax['lastname']}</p>";
    }
    
    $css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('book-finish', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'section'     => $section,
        
        'kode'        => $kode,
        "info_flight" => $info_flight,
        "total"       => $total,
        "info_pax"    => $info_pax,
      ));
    $this->template
      ->set_layout('default')
      ->build("book-finish");
  }
  
  public function book_confirm($kode){
    $this->load->model("site/m_opsigo");
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
    
    $reservation = $this->m_opsigo->reservation_cek($kode);
//    $this->debug($payment_channel);
//    $this->debug($discount_depan);
//    $this->debug($whitelist, true);
//    $this->debug($reservation, true);
    if(in_array("BookingError", $reservation['stamp'])){
      redirect("site/book-fail");
    }
    
    $css = ""
      . "<style>"
        . ".view-enable{"
          . "display: block;"
        . "}"
        . ".view-disenable{"
          . "display: none;"
        . "}"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    
    $foot = ""
      . $this->global_format->framework()
      . "<script>"
        . "$(document).on('click', '#pesan-ticket', function(evt){"
          . "$.post('".site_url('site/site-data-ajax/garuda-book')."', {kode: '{$kode}'}, function(data){"
            . "if(data == 2 || data == '2'){"
              . "window.location = '".site_url("site/book-result/{$kode}")."';"
            . "}"
            . "else{"
              . "alert('".lang("Fail").": ".lang("Booking Gagal")."');"
              . "window.location = '".site_url()."';"
            . "}"
          . "})"
          . ".fail(function(){"
//            . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
          . "})"
          . ".always(function(){"
          . "});"
        . "});"
        . "var formprogress = new Vue({"
          . "el: '#progress-flight',"
          . "data: {"
            . "progresspersen: {$reservation['progress']},"
            . "tampil: '".($reservation['progress'] < 100 ? 'view-enable' : 'view-disenable')."',"
          . "},"
          . "watch:{"
            . "progresspersen: function(val){"
              . "if(val >= 100){"
                . "window.location = '".site_url("site/book-confirm/{$kode}")."';"
//                . "reload();"
              . "}"
              . "else{"
              . "}"
            . "}"
          . "},"
          . "methods: {"
            . "cek_progress: function(){"
              . "var vm = this;"
              . "$.post('".site_url('site/site-opsigo-ajax/reservation-cek')."', {code: '{$kode}'}, function(data){"
                . "var hasil = $.parseJSON(data);"
                . "if(hasil.status == 10001){"
                . "}"
                . "else if(hasil.status == 3){"
//                  . "formprogress.progresspersen = formprogress.progresspersen + (1/formprogress.flight.length * 100);"
                . "}"
                . "else{"
//                  . "if(hasil.data.progress >= 100){"
//                    . "window.location = '".site_url("site/book-confirm/{$kode}")."';"
//                  . "}"
//                  . "else{"
                    . "vm.progresspersen = hasil.data.progress;"
//                  . "}"
                . "}"
              . "})"
              . ".done(function(){"
              . "})"
              . ".fail(function(){"
              . "})"
              . ".always(function(){"
                . "setTimeout(function(){"
                  . "vm.cek_progress();"
                . "}, 10000);"
              . "});"
            . "}"
          . "}"
        . "});"
        . "setTimeout(function(){"
          . "formprogress.cek_progress();"
        . "}, 10000);";
          
      $change_class = FALSE;
      $r = 0;
      foreach ($reservation["stamp"] AS $k => $stamp){
        if($stamp == "FlightUnavailable"){
          $change_class = TRUE;
          $type[$k] = $reservation['detail']['flight'][$k][0]['airlinecode'];
          $r++;
        }
      }
      
      if($change_class == TRUE){
        $foot .= ""
          . "var kirim_available = {"
            . "type: '{$type[0]}',"
            . "type2: '{$type[1]}',"
            . "tgl: '{$reservation['detail']['bookers']['departuredate']}',"
            . "return: '{$reservation['detail']['bookers']['returndate']}',"
            . "asal: '{$reservation['detail']['bookers']['origin']}',"
            . "tujuan: '{$reservation['detail']['bookers']['destination']}',"
            . "adl: '{$reservation['detail']['bookers']['adult']}',"
            . "chd: '{$reservation['detail']['bookers']['child']}',"
            . "inf: '{$reservation['detail']['bookers']['infant']}',"
            . "code: '{$kode}',"
            . "flightnumber: '{$reservation['detail']['flight'][0][0]['number']}',"
            . "flightnumber2: '{$reservation['detail']['flight'][1][0]['number']}'"
          . "};";
            
        $foot .= ""
          . "$.post('".site_url('site/site-opsigo-ajax/reservation-available')."', kirim_available, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(hasil.status == 10001){"
            . "}"
            . "else if(hasil.status == 3){"
            . "}"
            . "else{"
//                . "reload();"
            . "}"
          . "})"
          . ".done(function(){"
          . "})"
          . ".fail(function(){"
          . "})"
          . ".always(function(){"
            . "window.location = '".site_url("site/book-confirm/{$kode}")."';"
          . "});"
          . "";
      }
              
      $foot .= ""
      . "</script>"
      . "";
    
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('book-confirm', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'section'     => $section,
        
        'paket'       => $reservation['detail'],
        'whitelist'   => $whitelist,
        'discount_depan'  => $discount_depan,
        'payment_channel' => $payment_channel,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("book-confirm");
  }
  
  public function book_fail(){
    
    $css = ""
      . "<style>"
        . ".view-enable{"
          . "display: block;"
        . "}"
        . ".view-disenable{"
          . "display: none;"
        . "}"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    
    $foot = ""
      . $this->global_format->framework()
      . "<script>";  
    $foot .= ""
      . "</script>"
      . "";
    
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('book-fail', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("book-fail");
  }
  
  public function book_expired($kode){
    
    $css = ""
      . "<style>"
        . ".view-enable{"
          . "display: block;"
        . "}"
        . ".view-disenable{"
          . "display: none;"
        . "}"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    
    $foot = ""
      . $this->global_format->framework()
      . "<script>";  
    $foot .= ""
      . "</script>"
      . "";
    
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('book-expired', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("book-expired");
  }
  
  public function book_cancel($kode){
    $this->load->model("site/m_opsigo");
    $reservation = $this->m_opsigo->reservation_cancel($kode);
//    $this->debug($payment_channel);
//    $this->debug($discount_depan);
//    $this->debug($whitelist, true);
//    $this->debug($reservation, true);
    redirect("site/book-confirm/{$kode}");
  }
  
  public function book(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    
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
    
    $css = ""
      . "<style>"
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>"
      . "";
    $section = ""
      . "<section class='clearfix booking-steps'>"
        . "<span class='left active'></span>"
        . "<span class='right '></span>"
        . "<div class='container'>"
          . "<div class='btn-group btn-group-justified'>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>CARI PENERBANGAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn active'>INFORMASI PENUMPANG</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>ULASAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PEMBAYARAN PEMESANAN</a>"
            . "<a href='http://antavaya.com/Flight/Passenger#' class='btn '>PENGIRIMAN TIKET</a>"
          . "</div>"
        . "</div>"
      . "</section>"
      . "";
    $this->template
      ->set_layout('default')
      ->build('book', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'section'     => $section,
        'pst'         => $pst,
        'whitelist'   => $whitelist,
        'discount_depan'  => $discount_depan,
        'payment_channel' => $payment_channel,
        
      ));
    $this->template
      ->set_layout('default')
      ->build("book");
  }
  
  public function flight(){
    $pst = $this->input->get();
    
    $rute     = explode(".", $pst['journey']);
    $pax      = explode(".", $pst['psgr']);
    $tgl      = explode(".", $pst['date']);
    $class_flight = "";
    if($pst['ct'] == "BISNIS")
      $class_flight = 2;
    
    if($tgl[1]){
      redirect("site/flight-round-trip?journey={$pst['journey']}&date={$pst['date']}&psgr={$pst['psgr']}&ct={$pst['ct']}");
    }
    
//    $this->debug($param, true);
    
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    $header = array(
      array(
        "title"       => lang("HTML"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Harga"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Durasi"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Berangkat"),
        "id"          => 4,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Tiba"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $css = ""
      . "<style>"
//        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $param = array(
      "origin"         => $rute[0],
      "destination"    => $rute[1],
      "adult"          => $pax[0],
      "child"          => $pax[1],
      "infant"         => $pax[2],
      "departuredate"  => $tgl[0],
      "departuredate2" => $tgl[1],
      "type"           => ($tgl[1] ? 2 : 1),
    );
    
    $foot .= ""
      . "{$this->global_format->js_grid_table2(array(), $header, $grid)}"
      . "function ambil_data(type, update = 1){"
        . "$.post('".site_url('site/site-opsigo-ajax/flight-get')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', type: type, inf: '{$param['infant']}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
//            . "$('#negative-response-title').html('".lang("Access")."');"
//            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
//            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
//            . "$('#negative-response-title').html('".lang("Function")."');"
//            . "$('#negative-response-body').html(hasil.note);"
//            . "$('#negative-response').modal('show');"
            . "formprogress.progresspersen = formprogress.progresspersen + (1/formprogress.flight.length * 100);"
          . "}"
          . "else{"
            . "if(update == 2){"
              . "hasil.status = 2;"
            . "}"
            . "if(hasil.status == 4){"
              . "setTimeout(function(){"
                . "$.post('".site_url('site/site-opsigo-ajax/flight-cek')."', {requestid: hasil.requestid}, function(datacek){"
                  . "var hasilcek = $.parseJSON(datacek);"
                  . "if(hasilcek.status == 2){"
                    . "ambil_data(type, 2);"
                  . "}"
                  . "else if(hasilcek.status == 3){"
                    . "formprogress.progresspersen = formprogress.progresspersen + (1/formprogress.flight.length * 100);"
                  . "}"
                . "});"
              . "}, 30000);"
            . "}"
            . "else{"
              . "if(hasil.data){"
                . "for(ind = 0; ind < hasil.data.length; ++ind){"
                  . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                  . "{$grid['variable']}.sort_data_always_asc(1);"
                . "}"
                . "{$grid['variable']}.page.ga[type] = hasil.isi;"
                . "formprogress.progresspersen = formprogress.progresspersen + (1/formprogress.flight.length * 100);"
  //              . "console.log({$grid['variable']}.page.ga);"
              . "}"
            . "}"
          . "}"
        . "})"
        . ".done(function(){"
          
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "function ambil_garuda(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                . "{$grid['variable']}.sort_data_always_asc(1);"
              . "}"
              . "{$grid['variable']}.page.ga = hasil.isi;"
            . "}"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('.progress-bar').css('width', '100%');"
          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
      
      . "function ambil_availability_sess(ReqTxnID, SessionId, SequenceNumber, SecurityToken){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', reqtxnid: ReqTxnID, sessionid: SessionId, sequencenumber: SequenceNumber, securitytoken: SecurityToken, class_flight: '{$class_flight}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "{$grid['variable']}.page.ga_availability = {$grid['variable']}.page.ga_availability.concat(hasil.isi);"
            . "ambil_availability_sess(hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
//            . "console.log('----------------');"
//            . "console.log({$grid['variable']}.page.ga_availability);"
          . "}"
          . "else{"
            . "$('.progress-bar').css('width', '20%');"
            . "$('.progress-bar-percent').html('(20%)');"
            . "{$grid['variable']}.page.ga_persen = 20;"
            . "var per_items = 80/{$grid['variable']}.page.ga_availability.length;"
            . "{$grid['variable']}.page.ga_peritems = per_items;"
            . "{$grid['variable']}.page.ga = [];"
            . "ambil_faredetail(0);"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
                
      . "function ambil_faredetail(ke, ReqTxnID, SessionId, SequenceNumber, SecurityToken){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-faredetail')."', {data: JSON.stringify({$grid['variable']}.page.ga_availability[ke]), adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', key: ke, reqtxnid: ReqTxnID, sessionid: SessionId, sequencenumber: SequenceNumber, securitytoken: SecurityToken}, function(data){"
//        . "console.log(data);"
          . "var hasil = $.parseJSON(data);"
//          . "console.log(hasil.debug);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
              . $this->global_format->js_grid_add($grid, "hasil.data")
              . "{$grid['variable']}.sort_data_always_asc(1);"
            . "}"
          . "}"
          . "{$grid['variable']}.page.ga.push(hasil.isi);"
          
          . "{$grid['variable']}.page.ga_persen = {$grid['variable']}.page.ga_persen + {$grid['variable']}.page.ga_peritems;"
          . "$('.progress-bar').css('width', {$grid['variable']}.page.ga_persen+'%');"
          . "$('.progress-bar-percent').html('('+{$grid['variable']}.page.ga_persen+'%)');"
          . "if(({$grid['variable']}.page.ga_availability.length - 1) > ke){"
            . "ambil_faredetail((ke + 1), hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
          . "}"
          . "else{"
            . "{$grid['variable']}.page.ga_persen = 100;"
            . "$('.progress-bar').css('width', '100%');"
            . "$('.progress-bar-percent').html('(100%)');"
            . "$.post('".site_url('site/site-data-ajax/ga-logout')."', {reqtxnid: hasil.ReqTxnID, sessionid: hasil.SessionId, sequencenumber: hasil.SequenceNumber, securitytoken: hasil.SecurityToken}, function(data){"
            . "});"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "console.log({$grid['variable']}.page.ga_availability);"
        . "});"
      . "}"
              
      . "function ambil_availability(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', class_flight: '{$class_flight}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "{$grid['variable']}.page.ga_availability = hasil.isi;"
            . "ambil_availability_sess(hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "console.log('----------------');"
//          . "console.log({$grid['variable']}.page.ga_availability);"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
      
//      . "ambil_availability();"

//      . "ambil_garuda();"
      . "$(document).on('click', '.fancy-nbs', function(evt){"
        . "var key = $(this).attr('isi');"
        . "var keytype = $(this).attr('isitype');"
//              . "console.log(key);"
//              . "console.log({$grid['variable']}.page);"
        . "$.fancybox.open({"
          . "padding: 0,"
          . "type: 'inline',"
          . "maxWidth: 800,"
          . "content: $('#nbs-fancy'),"
          . "helpers: {"
            . "title: {"
              . "type: 'over'"
            . "}"
          . "},"
          . "beforeShow: function () {"
            . "var kirim = {"
              . "paket: JSON.stringify({$grid['variable']}.page.ga[keytype][key]),"
              . "adult: {$param['adult']},"
              . "child: {$param['child']},"
              . "infant: {$param['infant']},"
              . "awal_departure: '{$param['origin']}',"
              . "awal_arrival: '{$param['destination']}',"
              . "awal_departuredate: '{$param['departuredate']}',"
              . "awal_returndate: '{$param['departuredate2']}',"
              . "type: {$param['type']}"
            . "};"
            . "$.post('".site_url('site/site-data-ajax/one-way-popup')."', kirim, function(data){"
              . "$('#hasil-popup').html(data);"
            . "})"
            . ".fail(function(){"
//              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "afterShow: function () {"
          . "}"
        . "});"
      . "});"
      . "$(document).on('click', '#urutharga', function(evt){"
        . "{$grid['variable']}.sort_data(1);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutdurasi', function(evt){"
        . "{$grid['variable']}.sort_data(2);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutberangkat', function(evt){"
        . "{$grid['variable']}.sort_data(3);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#uruttiba', function(evt){"
        . "{$grid['variable']}.sort_data(4);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . ""
          
      . "var formprogress = new Vue({"
        . "el: '#progress-flight',"
        . "data: {"
          . "progresspersen: 0,"
          . "flight: [2,3,4,5,7,8,11],"
        . "},"
        . "watch:{"
          . "progresspersen: function(val){"
            . "if(val >= 98){"
              . "this.progresspersen = 100;"
            . "}"
          . "}"
        . "}"
      . "});"
      . "{$grid['variable']}.page.ga = [];"
      . "for(var y = 0 ; y < formprogress.flight.length ; y++){"
//        . "{$grid['variable']}.page.ga[y] = [];"
        . "ambil_data(formprogress.flight[y]);"
      . "}"
          
//      . "$('.fancy-nbs').fancybox({"
//        . "padding: 0,"
//        . "type: 'inline',"
//        . "maxWidth: 800,"
//        . "content: $('#nbs-fancy'),"
//        . "helpers: {"
//          . "title: {"
//            . "type: 'over'"
//          . "}"
//        . "},"
//        . "beforeShow: function () {"
//          . "var key = $(this).attr('isi');"
//          . "console.log({$grid['variable']}.page.ga);"
//          . "console.log(key);"
//        . "},"
//        . "afterShow: function () {"
//        . "}"
//      . "});"
      
//          . "coba();"
      . ""
      . "";
      
    $foot .= "</script>";
    
    $this->template
      ->set_layout('default')
      ->build('flight', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'rute'        => $rute,
        'pax'         => $pax,
        'tgl'         => $tgl,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->build("flight");
  }
  
  public function flight_round_trip(){
    $pst = $this->input->get();
    
    $rute     = explode(".", $pst['journey']);
    $pax      = explode(".", $pst['psgr']);
    $tgl      = explode(".", $pst['date']);
    $class_flight = "";
    if($pst['ct'] == "BISNIS")
      $class_flight = 2;
//    $this->debug($param, true);
    
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 100,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    $grid2 = array(
      "limit"         => 100,
      "id"            => "table-utama2",
      "search"        => "",
      "variable"      => "vm_utama2",
      "cari"          => "searchString2",
      "onselect"      => "",
      "select"        => array(),
      "select_value"  => "",
      "on_unselect"   => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    $header = array(
      array(
        "title"       => lang("HTML"),
        "id"          => 1,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Harga"),
        "id"          => 2,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Durasi"),
        "id"          => 3,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Berangkat"),
        "id"          => 4,
        "asc"         => false,
        "desc"        => false,
      ),
      array(
        "title"       => lang("Tiba"),
        "id"          => 5,
        "asc"         => false,
        "desc"        => false,
      ),
    );
    
    $css = ""
      . "<style>"
//        . $this->global_format->css_grid()
        . ".body{"
          . "padding-top: inherit !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $param = array(
      "origin"         => $rute[0],
      "destination"    => $rute[1],
      "adult"          => $pax[0],
      "child"          => $pax[1],
      "infant"         => $pax[2],
      "departuredate"  => $tgl[0],
      "departuredate2" => $tgl[1],
      "type"           => ($tgl[1] ? 2 : 1),
    );
    
    $foot .= ""
      . "{$this->global_format->js_grid_table2(array(), $header, $grid)}"
      . "{$this->global_format->js_grid_table2(array(), $header, $grid2)}"
      . "{$grid['variable']}.page.ga_persen = 0;"
      . "{$grid2['variable']}.page.ga_persen = 0;"
      
      . "function ambil_faredetail(ke, ReqTxnID, SessionId, SequenceNumber, SecurityToken){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-faredetail')."', {data: JSON.stringify({$grid['variable']}.page.ga_availability[ke]), adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', key: ke, class: 'coba-pilih-pergi', reqtxnid: ReqTxnID, sessionid: SessionId, sequencenumber: SequenceNumber, securitytoken: SecurityToken}, function(data){"
//        . "console.log(data);"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
              . $this->global_format->js_grid_add($grid, "hasil.data")
              . "{$grid['variable']}.sort_data_always_asc(1);"
              . "{$grid['variable']}.page.ga.push(hasil.isi);"
            . "}"
          . "}"
                
          . "{$grid['variable']}.page.ga_persen = {$grid['variable']}.page.ga_persen + {$grid['variable']}.page.ga_peritems;"
          . "$('.progress-bar').css('width', ({$grid['variable']}.page.ga_persen + {$grid2['variable']}.page.ga_persen)+'%');"
          . "$('.progress-bar-percent').html('('+({$grid['variable']}.page.ga_persen + {$grid2['variable']}.page.ga_persen)+'%)');"
          . "if(({$grid['variable']}.page.ga_availability.length - 1) > ke){"
            . "ambil_faredetail((ke + 1), hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
          . "}"
          . "else{"
            . "{$grid['variable']}.page.ga_persen = 50;"
            . "$('.progress-bar').css('width', ({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%');"
            . "$('.progress-bar-percent').html('('+({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%)');"
            . "$.post('".site_url('site/site-data-ajax/ga-logout')."', {reqtxnid: hasil.ReqTxnID, sessionid: hasil.SessionId, sequencenumber: hasil.SequenceNumber, securitytoken: hasil.SecurityToken}, function(data){"
            . "});"
          . "}"
              
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "function ambil_faredetail2(ke2, ReqTxnID2, SessionId2, SequenceNumber2, SecurityToken2){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-faredetail')."', {data: JSON.stringify({$grid2['variable']}.page.ga_availability[ke2]), adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', key: ke2, reqtxnid: ReqTxnID2, sessionid: SessionId2, sequencenumber: SequenceNumber2, securitytoken: SecurityToken2}, function(data23){"
//        . "console.log(data);"
          . "var hasil23 = $.parseJSON(data23);"
          . "if(hasil23.status == 2){"
            . "if(hasil23.data){"
              . $this->global_format->js_grid_add($grid2, "hasil23.data")
              . "{$grid2['variable']}.sort_data_always_asc(1);"
              . "{$grid2['variable']}.page.ga.push(hasil23.isi);"
            . "}"
          . "}"
          . "{$grid2['variable']}.page.ga_persen = {$grid2['variable']}.page.ga_persen + {$grid2['variable']}.page.ga_peritems;"
          . "$('.progress-bar').css('width', ({$grid['variable']}.page.ga_persen + {$grid2['variable']}.page.ga_persen)+'%');"
          . "$('.progress-bar-percent').html('('+({$grid['variable']}.page.ga_persen + {$grid2['variable']}.page.ga_persen)+'%)');"
          . "if(({$grid2['variable']}.page.ga_availability.length - 1) > ke2){"
            . "ambil_faredetail2((ke2 + 1), hasil23.ReqTxnID, hasil23.SessionId, hasil23.SequenceNumber, hasil23.SecurityToken);"
          . "}"
          . "else{"
            . "{$grid2['variable']}.page.ga_persen = 50;"
            . "$('.progress-bar').css('width', ({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%');"
            . "$('.progress-bar-percent').html('('+({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%)');"
            . "$.post('".site_url('site/site-data-ajax/ga-logout')."', {reqtxnid: hasil23.ReqTxnID, sessionid: hasil23.SessionId, sequencenumber: hasil23.SequenceNumber, securitytoken: hasil23.SecurityToken}, function(data){"
            . "});"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      
      . "function ambil_availability_sess(ReqTxnID, SessionId, SequenceNumber, SecurityToken){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', reqtxnid: ReqTxnID, sessionid: SessionId, sequencenumber: SequenceNumber, securitytoken: SecurityToken, class_flight: '{$class_flight}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "{$grid['variable']}.page.ga_availability = {$grid['variable']}.page.ga_availability.concat(hasil.isi);"
            . "ambil_availability_sess(hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
//            . "console.log('----------------');"
//            . "console.log({$grid['variable']}.page.ga_availability);"
          . "}"
          . "else{"
            . "{$grid['variable']}.page.ga_persen = {$grid['variable']}.page.ga_persen + 10;"
            . "$('.progress-bar').css('width', ({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%');"
            . "$('.progress-bar-percent').html('('+({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%)');"
            . "var per_items = 40/{$grid['variable']}.page.ga_availability.length;"
            . "{$grid['variable']}.page.ga_peritems = per_items;"
            . "{$grid['variable']}.page.ga = [];"
            . "ambil_faredetail(0);"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
      
      . "function ambil_availability_sess2(ReqTxnID2, SessionId2, SequenceNumber2, SecurityToken2){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['destination']}', tujuan: '{$param['origin']}', tgl: '{$param['departuredate2']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', reqtxnid: ReqTxnID2, sessionid: SessionId2, sequencenumber: SequenceNumber2, securitytoken: SecurityToken2, class_flight: '{$class_flight}'}, function(data22){"
          . "var hasil22 = $.parseJSON(data22);"
          . "if(hasil22.status == 2){"
            . "{$grid2['variable']}.page.ga_availability = {$grid2['variable']}.page.ga_availability.concat(hasil22.isi);"
            . "ambil_availability_sess2(hasil22.ReqTxnID, hasil22.SessionId, hasil22.SequenceNumber, hasil22.SecurityToken);"
//            . "console.log('----------------');"
//            . "console.log({$grid['variable']}.page.ga_availability);"
          . "}"
          . "else{"
            . "{$grid2['variable']}.page.ga_persen = {$grid2['variable']}.page.ga_persen + 10;"
            . "$('.progress-bar').css('width', ({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%');"
            . "$('.progress-bar-percent').html('('+({$grid2['variable']}.page.ga_persen + {$grid['variable']}.page.ga_persen)+'%)');"
            . "var per_items = 40/{$grid2['variable']}.page.ga_availability.length;"
            . "{$grid2['variable']}.page.ga_peritems = per_items;"
            . "{$grid2['variable']}.page.ga = [];"
            . "ambil_faredetail2(0);"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
      
      . "function ambil_availability(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', class_flight: '{$class_flight}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "{$grid['variable']}.page.ga_availability = hasil.isi;"
            . "ambil_availability_sess(hasil.ReqTxnID, hasil.SessionId, hasil.SequenceNumber, hasil.SecurityToken);"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "console.log('----------------');"
//          . "console.log({$grid['variable']}.page.ga_availability);"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
      . "function ambil_availability2(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get-availability')."', {asal: '{$param['destination']}', tujuan: '{$param['origin']}', tgl: '{$param['departuredate2']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', class_flight: '{$class_flight}'}, function(data2){"
          . "var hasil2 = $.parseJSON(data2);"
          . "if(hasil2.status == 2){"
            . "{$grid2['variable']}.page.ga_availability = hasil2.isi;"
            . "ambil_availability_sess2(hasil2.ReqTxnID, hasil2.SessionId, hasil2.SequenceNumber, hasil2.SecurityToken);"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
//          . "console.log('----------------');"
//          . "console.log({$grid['variable']}.page.ga_availability);"
//          . "$('.progress-bar').css('width', '100%');"
//          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
//      . "ambil_availability();"
//      . "ambil_availability2();"
      
      . "function ambil_garuda(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}', class: 'coba-pilih-pergi'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(hasil.data){"
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                . "{$grid['variable']}.sort_data_always_asc(1);"
              . "}"
              . "{$grid['variable']}.page.ga = hasil.isi;"
            . "}"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('.progress-bar').css('width', '50%');"
          . "$('.progress-bar-percent').html('(50%)');"
        . "});"
      . "}"
                
      . "function ambil_garuda2(){"
        . "$.post('".site_url('site/site-data-ajax/garuda-get')."', {asal: '{$param['destination']}', tujuan: '{$param['origin']}', tgl: '{$param['departuredate2']}', adl: '{$param['adult']}', chd: '{$param['child']}', inf: '{$param['infant']}'}, function(data2){"
          . "var hasil2 = $.parseJSON(data2);"
          . "if(hasil2.status == 2){"
            . "if(hasil2.data){"
              . "for(ind2 = 0; ind2 < hasil2.data.length; ++ind2){"
                . $this->global_format->js_grid_add($grid2, "hasil2.data[ind2]")
                . "{$grid2['variable']}.sort_data_always_asc(1);"
              . "}"
              . "{$grid2['variable']}.page.ga = hasil2.isi;"
            . "}"
          . "}"
          . "else{"
          . "}"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('.progress-bar').css('width', '100%');"
          . "$('.progress-bar-percent').html('(100%)');"
        . "});"
      . "}"
                
//      . "ambil_garuda();"
//      . "ambil_garuda2();"
                
      . "function ambil_data(type, update = 1){"
        . "$.post('".site_url('site/site-opsigo-ajax/flight-get')."', {asal: '{$param['origin']}', tujuan: '{$param['destination']}', tgl: '{$param['departuredate']}', adl: '{$param['adult']}', chd: '{$param['child']}', type: type, inf: '{$param['infant']}', class: 'coba-pilih-pergi'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
          . "}"
          . "else if(hasil.status == 3){"
            . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
          . "}"
          . "else{"
            . "if(update == 2){"
              . "hasil.status = 2;"
            . "}"
            . "if(hasil.status == 4){"
              . "setTimeout(function(){"
                . "$.post('".site_url('site/site-opsigo-ajax/flight-cek')."', {requestid: hasil.requestid}, function(datacek){"
                  . "var hasilcek = $.parseJSON(datacek);"
                  . "if(hasilcek.status == 2){"
                    . "ambil_data(type, 2);"
                  . "}"
                  . "else if(hasilcek.status == 3){"
                    . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
                  . "}"
                . "});"
              . "}, 30000);"
            . "}"
            . "else{"
              . "if(hasil.data){"
                . "for(ind = 0; ind < hasil.data.length; ++ind){"
                  . $this->global_format->js_grid_add($grid, "hasil.data[ind]")
                  . "{$grid['variable']}.sort_data_always_asc(1);"
                . "}"
                . "{$grid['variable']}.page.ga[type] = hasil.isi;"
                . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
  //              . "console.log({$grid['variable']}.page.ga);"
              . "}"
            . "}"
          . "}"
        . "})"
        . ".done(function(){"
          
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
                
      . "function ambil_data2(type, update = 1){"
        . "$.post('".site_url('site/site-opsigo-ajax/flight-get')."', {asal: '{$param['destination']}', tujuan: '{$param['origin']}', tgl: '{$param['departuredate2']}', adl: '{$param['adult']}', chd: '{$param['child']}', type: type, inf: '{$param['infant']}'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
          . "}"
          . "else if(hasil.status == 3){"
            . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
          . "}"
          . "else{"
            . "if(update == 2){"
              . "hasil.status = 2;"
            . "}"
            . "if(hasil.status == 4){"
              . "setTimeout(function(){"
                . "$.post('".site_url('site/site-opsigo-ajax/flight-cek')."', {requestid: hasil.requestid}, function(datacek){"
                  . "var hasilcek = $.parseJSON(datacek);"
                  . "if(hasilcek.status == 2){"
                    . "ambil_data2(type, 2);"
                  . "}"
                  . "else if(hasilcek.status == 3){"
                    . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
                  . "}"
                . "});"
              . "}, 30000);"
            . "}"
            . "else{"
              . "if(hasil.data){"
                . "for(ind = 0; ind < hasil.data.length; ++ind){"
                  . $this->global_format->js_grid_add($grid2, "hasil.data[ind]")
                  . "{$grid2['variable']}.sort_data_always_asc(1);"
                . "}"
                . "{$grid2['variable']}.page.ga[type] = hasil.isi;"
                . "formprogress.progresspersen = (formprogress.progresspersen + (1/formprogress.flight.length * 100)/2);"
  //              . "console.log({$grid['variable']}.page.ga);"
              . "}"
            . "}"
          . "}"
        . "})"
        . ".done(function(){"
          
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
                
      . "$(document).on('click', '#ganti-pergi-result', function(evt){"
        . "$('#pergi-result').hide();"
        . "$('#ganti-pergi-result').hide();"
        . "$('#table-utama').show();"
        . "$('#parent-pergi').addClass('active');"
        . "$('#parent-pergi').removeClass('selected');"
        . "$('#parent-pulang').addClass('nonactive');"
        . "$('#parent-pulang').removeClass('active');"
      . "});"
                
      . "$(document).on('click', '.coba-pilih-pergi', function(evt){"
        . "var key = $(this).attr('isi');"
        . "var isitype = $(this).attr('isitype');"
        . "{$grid['variable']}.page.pilih = {$grid['variable']}.page.ga[isitype][key];"

        . "$.post('".site_url("site/site-data-ajax/round-trip-detail-pergi")."', {paket: JSON.stringify({$grid['variable']}.page.pilih)}, function(data){"
          . "$('#pergi-result').html(data);"
        . "})"
        . ".fail(function(){"
//          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#pergi-result').show();"
          . "$('#ganti-pergi-result').show();"
          . "$('#table-utama').hide();"
          . "$('#parent-pergi').removeClass('active');"
          . "$('#parent-pergi').addClass('selected');"
          . "$('#parent-pulang').removeClass('nonactive');"
          . "$('#parent-pulang').addClass('active');"
        . "});"
      . "});"
                
      . "$(document).on('click', '.fancy-nbs', function(evt){"
        . "var key = $(this).attr('isi');"
        . "var isitype = $(this).attr('isitype');"
//        . "console.log({$grid['variable']}.page.pilih);"
//        . "console.log({$grid2['variable']}.page.ga[key]);"
        . "$.fancybox.open({"
          . "padding: 0,"
          . "type: 'inline',"
          . "maxWidth: 800,"
          . "content: $('#nbs-fancy'),"
          . "helpers: {"
            . "title: {"
              . "type: 'over'"
            . "}"
          . "},"
          . "beforeShow: function () {"
            . "var kirim = {"
              . "paket: JSON.stringify({$grid['variable']}.page.pilih),"
              . "paket2: JSON.stringify({$grid2['variable']}.page.ga[isitype][key]),"
              . "adult: {$param['adult']},"
              . "child: {$param['child']},"
              . "infant: {$param['infant']},"
              . "awal_departure: '{$param['origin']}',"
              . "awal_arrival: '{$param['destination']}',"
              . "awal_departuredate: '{$param['departuredate']}',"
              . "awal_returndate: '{$param['departuredate2']}',"
              . "type: {$param['type']}"
            . "};"
            . "$.post('".site_url('site/site-data-ajax/round-trip-popup')."', kirim, function(data){"
              . "$('#hasil-popup').html(data);"
            . "})"
            . ".fail(function(){"
//              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
            . "});"
          . "},"
          . "afterShow: function () {"
          . "}"
        . "});"
      . "});"
      . "$(document).on('click', '#urutharga', function(evt){"
        . "{$grid['variable']}.sort_data(1);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutdurasi', function(evt){"
        . "{$grid['variable']}.sort_data(2);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#urutberangkat', function(evt){"
        . "{$grid['variable']}.sort_data(3);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . "$(document).on('click', '#uruttiba', function(evt){"
        . "{$grid['variable']}.sort_data(4);"
        . "{$grid['variable']}.select(1);"
      . "});"
      . ""
          
      . "var formprogress = new Vue({"
        . "el: '#progress-flight',"
        . "data: {"
          . "progresspersen: 0,"
          . "flight: [2,3,4,5,7,8,11],"
        . "},"
        . "watch:{"
          . "progresspersen: function(val){"
            . "if(val >= 98){"
              . "this.progresspersen = 100;"
            . "}"
          . "}"
        . "}"
      . "});"
      . "{$grid['variable']}.page.ga = [];"
      . "{$grid2['variable']}.page.ga = [];"
      . "for(var y = 0 ; y < formprogress.flight.length ; y++){"
//        . "{$grid['variable']}.page.ga[y] = [];"
        . "ambil_data(formprogress.flight[y]);"
        . "ambil_data2(formprogress.flight[y]);"
      . "}"
//      . "$('.fancy-nbs').fancybox({"
//        . "padding: 0,"
//        . "type: 'inline',"
//        . "maxWidth: 800,"
//        . "content: $('#nbs-fancy'),"
//        . "helpers: {"
//          . "title: {"
//            . "type: 'over'"
//          . "}"
//        . "},"
//        . "beforeShow: function () {"
//          . "var key = $(this).attr('isi');"
//          . "console.log({$grid['variable']}.page.ga);"
//          . "console.log(key);"
//        . "},"
//        . "afterShow: function () {"
//        . "}"
//      . "});"
      
//          . "coba();"
      . ""
      . "";
      
    $foot .= "</script>";
    
    $this->template
      ->set_layout('default')
      ->build('flight-round-trip', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'rute'        => $rute,
        'pax'         => $pax,
        'tgl'         => $tgl,
        
        'grid'        => $grid,
        'grid2'       => $grid2,
      ));
    $this->template
      ->set_layout('default')
      ->build("flight-round-trip");
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
  
  public function index(){
    
    $data = $this->curl_mentah(
      array(
        'users'         => "test", 
        'password'      => "123",
        'limit'         => 6,
        'start'         => 0,
//        'urut'          => 100,
        "hot_detal"     => 2,
      ), 
      "http://117.102.80.180/mid-store/json/json-tour-umum/tour-series-get");
    $tour = json_decode($data);
    if($tour->total < 6){
      $sisa = 6 - $tour->total;
      $push = $this->curl_mentah(
        array(
          'users'         => "test", 
          'password'      => "123",
          'limit'         => $sisa,
          'start'         => 0,
          "push_selling"  => 1,
        ), 
        "http://117.102.80.180/mid-store/json/json-tour-umum/tour-series-get");
    }
    $cadangan = json_decode($push);
    
//    $this->debug($tour);
//    $this->debug($cadangan, true);
    
    $css = ""
      . "<link href='".base_url()."themes/antavaya/assets/styles/bootstrap-margin-padding.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/antavaya/assets/styles/style-turin.css' rel='stylesheet' type='text/css' />"
      . "</style>";
    
    $banner_lebar = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM cms_banner_promo AS A"
      . " WHERE A.status = 1"
      . " AND A.type = 2"
      . " AND ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate)"
      . " AND A.code = 'PANJANG'"
      . " ORDER BY A.sort ASC LIMIT 0,4"
      . "");
    
    if(count($banner_lebar) < 4){
      $banner_lebar2 = $this->global_models->get_query(""
        . " SELECT A.*"
        . " FROM cms_banner_promo AS A"
        . " WHERE A.status = 1"
        . " AND A.type = 1"
        . " AND A.code = 'PANJANG'"
        . " ORDER BY A.sort ASC LIMIT 0,".(4-count($banner_lebar))
        . "");
    }
    
    $hot = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM cms_banner_promo AS A"
      . " WHERE A.status = 1"
      . " AND A.type = 2"
      . " AND ('".date("Y-m-d H:i:s")."' BETWEEN A.startdate AND A.enddate)"
      . " AND A.code = 'HOT SALE'"
      . " ORDER BY A.sort ASC LIMIT 0,1"
      . "");
    if(!$hot){
      $hot = $this->global_models->get_query(""
        . " SELECT A.*"
        . " FROM cms_banner_promo AS A"
        . " WHERE A.status = 1"
        . " AND A.type = 1"
        . " AND A.code = 'HOT SALE'"
        . " ORDER BY A.sort ASC LIMIT 0,1"
        . "");
    }
        
    $bg = $this->global_models->get_query(""
      . " SELECT A.*"
      . " FROM cms_banner_promo AS A"
      . " WHERE A.status = 1"
      . " AND A.code = 'BG'"
      . " ORDER BY RAND() LIMIT 1;"
      . "");
        
    $this->template
      ->set_layout('default')
      ->build('main', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot'        => $foot,
        'css'         => $css,
        'banner'      => $banner_lebar,
        'banner2'     => $banner_lebar2,
        'hot'         => $hot,
        'bg'          => $bg,
        
        'tour'        => $tour,
        'cadangan'    => $cadangan,
        
        'grid'        => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
  
  private function bandara(){
	  
		  $this->debug($dt);
		  $this->global_models->generate_id($id_site_travel_bandara, "site_travel_bandara");
		  $kirim = array(
			"id_site_travel_bandara"				=> $id_site_travel_bandara,
			"AirportCode"							=> "HKG",
			"AirportName"							=> "Hongkong",
			"AirportKeyword"						=> "hongkong, hong-kong",
			"AirportCountry"						=> "",
			"AirportCity"							=> "HONGKONG",
			"AirportAddress"						=> "Hongkong",
			"AirportDescription"					=> "",
			"status"								=> 2,
			"create_by_users"						=> $this->session->userdata("id"),
			"create_date"							=> date("Y-m-d H:i:s")
		  );
		  $this->global_models->insert("site_travel_bandara", $kirim);
	  
	  print "done";die;
  }
  
  public function promo_ticket(){
    
    $css = ""
      . "<style>"
        . "table.table tr:hover td {"
          . "background-color: #b7b9bc;"
        . "}"
        . "table.table td {"
          . "vertical-align: middle !important;"
        . "}"
        . ".kuning{"
          . "background-color: #f39c12 !important;"
        . "}"
        . ".not-editable{"
          . "display: none;"
        . "}"
        . ".editable{"
          . "display: show;"
        . "}"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
        . ".ui-autocomplete-loading {"
          . "background: white url('".base_url()."themes/".DEFAULTTHEMES."/nubusa/images/load-16x16.gif"."') right center no-repeat;"
        . "}"
        . ".kanan{"
          . "text-align: right;"
        . "}"
        . $this->global_format->css_grid()
      . "</style>";
    
    $foot .= ""
      . $this->global_format->framework()
      . '<script type="text/javascript">'
      . "";
    
    $header = $this->global_format->standart_head(array("No", "Route Starting Jakarta", "Class", "Basic", "PPN 10%", "Tax D5 Fuel", "IWJR", "Total", "Voucher", "Total", "Book"));
    
//    $this->debug(json_encode($data), true);
    $grid = array(
      "limit"         => 10,
      "id"            => "table-utama",
      "search"        => "",
      "variable"      => "vm_utama",
      "cari"          => "searchString",
//      "onselect"      => "select_utama();",
      "select"        => array(),
      "select_value"  => "",
      "unselect"      => array(),
      "unselect_value"=> "",
      "multi_select"  => false,
    );
    
    $foot .= ""
//      . "$('#id-scm-outlet-target').select2();"
      . $this->global_format->js_grid_table(array(), $header, $grid)
      . $this->global_format->standart_get("ambil_data", site_url('site/site-ajax/promo-ticket-get'), "{start: mulai}", $grid)
      . "ambil_data(0);"
      . "";
     
    $foot .= "</script>";
    $head = ""
      . "<h1>".lang("Registrasi")."</h1>"
      . "<ol class='breadcrumb'>"
        . "<li class='active'><a href='javascript:void(0)'><i class='fa fa-edit'></i> ".lang("Registrasi")."</a></li>"
      . "</ol>";
    
    $this->template
      ->set_layout('default')
      ->build('promo-ticket/main', array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'title'       => lang("Ticket"),
        'foot'        => $foot,
        'css'         => $css,
        
        'grid'              => $grid,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("promo-ticket/main");
  }
  
  function available_flight($requestid){
    $pst = json_decode(file_get_contents("php://input"));
    $kirim = array(
      "scrapkey"        => $pst->ScrapKey,
      "flightcount"     => $pst->FlightCount,
      "issuccess"       => $pst->IsSuccess,
      "note"            => json_encode($pst),
      "update_manual"   => date("Y-m-d H:i:s"),
    );
    $this->global_models->update("site_ticket_available_progress", array("id_site_ticket_available_progress" => str_replace("_","-",$requestid)), $kirim);
    print 2;die;
  }
  
  function reservation_flight(){
    $pst = json_decode(file_get_contents("php://input"));
    $this->global_models->generate_id($id_site_ticket_reservation_progress, "site_ticket_reservation_progress");
    $reserva = $this->global_models->get("site_ticket_reservation_progress", array("pnrid" => $pst->PnrId));
    $progress = array(
      "id_site_ticket_reservation_progress" => $id_site_ticket_reservation_progress,
      "id_site_ticket_reservation"          => $reserva[0]->id_site_ticket_reservation,
      "pnrid"           => $pst->PnrId,
      "progress"        => $pst->Progress,
      "order"           => $reserva[0]->order,
      "text"            => $pst->Text,
      "type"            => $pst->JobType,
      "status"          => 1,
      "note"            => json_encode($pst),
      "create_by_users" => $users[0]->id_users,
      "create_date"     => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("site_ticket_reservation_progress", $progress);
    print 2;die;
  }
  
  function issued_flight(){
    $pst = json_decode(file_get_contents("php://input"));
    $this->global_models->generate_id($id_site_ticket_issued_progress, "site_ticket_issued_progress");
    $reserva = $this->global_models->get("site_ticket_issued_progress", array("pnrid" => $pst->PnrId));
    $progress = array(
      "id_site_ticket_issued_progress"    => $id_site_ticket_issued_progress,
      "id_site_ticket_reservation"        => $reserva[0]->id_site_ticket_reservation,
      "id_site_ticket_reservation_flight" => $reserva[0]->id_site_ticket_reservation_flight,
      "pnrid"           => $pst->PnrId,
      "progress"        => $pst->Progress,
      "text"            => $pst->Text,
      "type"            => $pst->JobType,
      "status"          => 1,
      "note"            => json_encode($pst),
      "create_by_users" => $users[0]->id_users,
      "create_date"     => date("Y-m-d H:i:s")
    );
    $this->global_models->insert("site_ticket_issued_progress", $progress);
    print 2;die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */