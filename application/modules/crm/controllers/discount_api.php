<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Discount_api extends REST_Controller {
  function voucher_cek_get(){
    $this->load->model("api/m_api");
    $kepala = getallheaders();
    $key = $this->m_api->key_cek($kepala['key']);
    if($key['status'] == 2){
      $this->load->model("crm/m_discount");
      $voucher = $this->get('voucher');
      if(!$voucher){
        $this->response(array('error' => lang("Parameter salah")), 400);
      }
      else{
        $data = $this->m_discount->voucher_check($voucher);
        if($data){
          if($data['status'] === 2){
            $this->response(array(
              "status"  => $data['status'],
              "note"    => lang("Available"),
              "detail"  => array(
                "startdate"     => $data['detail']->startdate,
                "enddate"       => $data['detail']->enddate,
              )
            ), 200);
          }
          else{
            $this->response(array('error' => $data['note']), 404);
          }
        }
        else{
          $this->response(array('error' => lang("Voucher tidak ditemukan")), 404);
        }
      }
    }
    else if($key['status'] == 4){
      $this->response(array('error' => lang("Timeout")), 419);
    }
    else{
      $this->response(array('error' => $key['note']), 401);
    }
  }
  
  function redeem_post(){
    $this->load->model("api/m_api");
    $kepala = getallheaders();
    $key = $this->m_api->key_cek($kepala['key']);
    if($key['status'] == 2){
      $this->load->model("crm/m_discount");
      
    }
    else if($key['status'] == 4){
      $this->response(array('error' => lang("Timeout")), 419);
    }
    else{
      $this->response(array('error' => $key['note']), 401);
    }
  }
  
}