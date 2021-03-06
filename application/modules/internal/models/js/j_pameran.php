<?php
class J_pameran extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function ticket_book_form($id_site_pameran_ticket){
    $html = ""
      . "var formutama = new Vue({"
        . "el: '#form-ticket',"
        . "data: {"
          . "name: '',"
          . "telp: '',"
          . "email: '',"
          . "departure_date: '',"
          . "return_date: '',"
          . "note: '',"
          . "id_site_pameran_ticket_detail2: '',"
          . "id_site_pameran_ticket_detail: '',"
          . "id_site_pameran_ticket_route: '',"
          . "id_site_pameran_ticket: '{$id_site_pameran_ticket}'"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "name: this.name,"
              . "telp: '0'+this.telp,"
              . "email: this.email,"
              . "departure_date: this.departure_date,"
              . "return_date: this.return_date,"
              . "note: this.note,"
              . "id_site_pameran_ticket_route: this.id_site_pameran_ticket_route,"
              . "id_site_pameran_ticket_detail: this.id_site_pameran_ticket_detail,"
            . "};"
            
            . "$.post('".site_url("sitepameran/pameran-umum-ajax/book-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 10001){"
                . "$('#negative-response-title').html('".lang("Access")."');"
                . "$('#negative-response-body').html('".lang("You can not access this function")."');"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 3){"
                . "$('#negative-response-title').html('".lang("Function")."');"
                . "$('#negative-response-body').html(hasil.note);"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else{"
                . "window.location = '".site_url("sitepameran/pameran-umum/confirm-ticket-book")."/'+hasil.id;"
              . "}"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              
            . "});"
          . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function ticket_int_book_form($id_site_pameran_ticket_int_detail){
    $html = ""
      . "var formutama = new Vue({"
        . "el: '#form-ticket',"
        . "data: {"
          . "name: '',"
          . "telp: '',"
          . "email: '',"
          . "departure_date: '',"
          . "return_date: '',"
          . "note: '',"
          . "id_site_pameran_ticket_int_detail: '{$id_site_pameran_ticket_int_detail}'"
        . "},"
        . "methods: {"
          . "add_new: function(){"
            . "var kirim = {"
              . "name: this.name,"
              . "telp: '0'+this.telp,"
              . "email: this.email,"
              . "departure_date: this.departure_date,"
              . "return_date: this.return_date,"
              . "note: this.note,"
              . "id_site_pameran_ticket_int_detail: this.id_site_pameran_ticket_int_detail,"
            . "};"
            
            . "$('#block-loading').css('z-index', '20000');"
            . "$('#block-loading').show();"
            
            . "$.post('".site_url("sitepameran/pameran-umum-ajax/book-int-set")."', kirim, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 10001){"
                . "$('#negative-response-title').html('".lang("Access")."');"
                . "$('#negative-response-body').html('".lang("You can not access this function")."');"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 3){"
                . "$('#negative-response-title').html('".lang("Function")."');"
                . "$('#negative-response-body').html(hasil.note);"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else{"
                . "window.location = '".site_url("sitepameran/pameran-umum/confirm-ticket-int-book")."/'+hasil.id;"
              . "}"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              
            . "});"
          . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function ticket_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("sitepameran/pameran-master-ajax/ticket-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "formutama.title = hasil.data.title;"
            . "formutama.location = hasil.data.location;"
            . "formutama.days = hasil.data.days;"
            . "formutama.adult_triple_twin = number_format(hasil.data.adult_triple_twin);"
            . "formutama.adult_sgl_supp = number_format(hasil.data.adult_sgl_supp);"
            . "formutama.child_twin_bed = number_format(hasil.data.child_twin_bed);"
            . "formutama.child_extra_bed = number_format(hasil.data.child_extra_bed);"
            . "formutama.child_no_bed = number_format(hasil.data.child_no_bed);"
            . "formutama.airport_tax = number_format(hasil.data.airport_tax);"
            . "formutama.visa = number_format(hasil.data.visa);"
            . "formutama.id_site_pameran_ticket = hasil.data.id_site_pameran_ticket;"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function ticket_int_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("sitepameran/pameran-master-ajax/ticket-int-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
//      . "console.log(formutama);"
            . "formutama.title = hasil.data.title;"
            . "formutama.startdate = hasil.data.startdate;"
            . "formutama.enddate = hasil.data.enddate;"
            . "formutama.route = hasil.data.route;"
            . "formutama.airline = hasil.data.airline;"
//            . "formutama.urut = hasil.data.urut;"
            . "formutama.id_site_pameran_ticket_int = hasil.data.id_site_pameran_ticket_int;"
//      . "console.log(formutama);"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function ticket_int_book_pax_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("sitepameran/sitepameran-ajax/ticket-int-book-pax-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
//      . "console.log(formutama);"
            . "formpax.name = hasil.data.name;"
            . "formpax.tanggal_lahir = hasil.data.tanggal_lahir;"
            . "formpax.telp = hasil.data.telp;"
            . "formpax.email = hasil.data.email;"
            . "formpax.passport = hasil.data.passport;"
            . "formpax.passport_country = hasil.data.passport_country;"
            . "formpax.passport_date = hasil.data.passport_date;"
            . "formpax.note = hasil.data.note;"
//      . "console.log(formutama);"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function ticket_route_select_utama(){
    $html = ""
      . "function select_route(){"
        . "var id = vm_route.page.select_value;"
        . "$.post('".site_url("sitepameran/pameran-master-ajax/ticket-route-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "formroute.title = hasil.data.title;"
            . "formroute.urut = hasil.data.urut;"
            . "formroute.id_site_pameran_ticket_route = hasil.data.id_site_pameran_ticket_route;"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function ticket_detail_select_utama(){
    $html = ""
      . "function select_detail(){"
        . "var id = vm_detail.page.select_value;"
        . "$.post('".site_url("sitepameran/pameran-master-ajax/ticket-detail-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "formdetail.code_class = hasil.data.code_class;"
            . "formdetail.title_class = hasil.data.title_class;"
            . "formdetail.basic = number_format(hasil.data.basic);"
            . "formdetail.tax = number_format(hasil.data.tax);"
            . "formdetail.iwjr = number_format(hasil.data.iwjr);"
            . "formdetail.voucher = hasil.data.voucher;"
            . "formdetail.note = hasil.data.note;"
            . "formdetail.id_site_pameran_ticket_detail = hasil.data.id_site_pameran_ticket_detail;"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function ticket_int_detail_select_utama(){
    $html = ""
      . "function select_detail(){"
        . "var id = vm_detail.page.select_value;"
        . "$.post('".site_url("sitepameran/pameran-master-ajax/ticket-int-detail-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "formdetail.code_class = hasil.data.code_class;"
            . "formdetail.title_class = hasil.data.title_class;"
            . "formdetail.basic = number_format(hasil.data.basic);"
            . "formdetail.tax = number_format(hasil.data.tax);"
            . "formdetail.voucher = hasil.data.voucher;"
            . "formdetail.tanggal = hasil.data.tanggal;"
            . "formdetail.enddate = hasil.data.enddate;"
            . "formdetail.seat = hasil.data.seat;"
            . "formdetail.note = hasil.data.note;"
            . "formdetail.id_site_pameran_ticket_int_detail = hasil.data.id_site_pameran_ticket_int_detail;"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function company_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("hrmemployee/employee-master-ajax/company-get-detail")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "formutama.code = hasil.data.code;"
            . "formutama.title = hasil.data.title;"
            . "formutama.id_hrm_company = hasil.data.id_hrm_company;"
            . "formutama.note = hasil.data.note;"
          . "}"
        . "})"
        . ".done(function(){"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function location_location_delete(){
    $html = ""
      . "$(document).on('click', '.location-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("hrmemployee/employee-master-ajax/location-delete")."', {id: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "vm_utama.delete_items(id);"
            . "vm_utama.cari($('#searchString').val());"
            . "vm_dept.delete_items(id);"
            . "vm_dept.cari($('#searchString').val());"
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . "";
    return $html;
  }
    
  function ticket_int_book_pax_pax_delete(){
    $html = ""
      . "$(document).on('click', '.pax-delete', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$.post('".site_url("sitepameran/sitepameran-ajax/ticket-int-book-pax-delete")."', {id_site_pameran_ticket_int_book_pax: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 10001){"
            . "$('#negative-response-title').html('".lang("Access")."');"
            . "$('#negative-response-body').html('".lang("You can not access this function")."');"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else if(hasil.status == 3){"
            . "$('#negative-response-title').html('".lang("Function")."');"
            . "$('#negative-response-body').html(hasil.note);"
            . "$('#negative-response').modal('show');"
          . "}"
          . "else{"
            . "vm_utama.delete_items(id);"
            . "vm_utama.cari($('#searchString').val());"
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "});"
      . "";
    return $html;
  }
    
  function ticket_int_book_pax_confirm_book(){
    $html = ""
      . "$(document).on('click', '.confirm-book', function(evt){"
        . "window.location = '".site_url("sitepameran/ticket-international-book-confirm")."/'+formutama.id_site_pameran_ticket_int_detail+'/'+formutama.book_number;"
      . "});"
      . "$(document).on('click', '.payment-book', function(evt){"
        . "window.location = '".site_url("sitepameran/ticket-international-book-payment")."/'+'/'+formutama.book_number;"
      . "});"
      . "";
    return $html;
  }
    
}
?>
