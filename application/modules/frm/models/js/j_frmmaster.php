<?php
class J_frmmaster extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function account_select_utama(){
    $html = ""
      . "function select_utama(){"
        . "var id = vm_utama.page.select_value;"
        . "$.post('".site_url("frm/frm-master-ajax/account-get-detail")."', {id_frm_account: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formutama.title = hasil.data.title;"
          . "formutama.id_frm_account = hasil.data.id_frm_account;"
          . "formutama.code = hasil.data.code;"
          . "formutama.position = hasil.data.position;"
          . "formutama.pos = hasil.data.pos;"
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
  
  function account_form_turunan(){
    $html = ""
      . "var formturunan = new Vue({"
        . "el: '#form-turunan',"
        . "data: {"
          . "title: '',"
          . "level: '',"
          . "code: '',"
          . "acc_id: '',"
          . "id_frm_account2: '',"
          . "id_frm_account3: '',"
          . "id_frm_account4: '',"
          . "id_frm_account5: '',"
        . "},"
        . "watch: {"
          . "id_frm_account2: function(val){"
            . "vm_3rd.clear();"
            . "vm_4th.clear();"
            . "vm_5th.clear();"
            . "ambil_data3(0);"
          . "},"
          . "id_frm_account3: function(val){"
            . "vm_4th.clear();"
            . "vm_5th.clear();"
            . "ambil_data4(0);"
          . "},"
          . "id_frm_account4: function(val){"
            . "vm_5th.clear();"
            . "ambil_data5(0);"
          . "}"
        . "},"
        . "methods: {"
          . "update: function(){"
            . "$('#page-loading-turunan').show();"
            . "$.post('".site_url("frm/frm-master-ajax/account-turunan-set")."', {code: this.code,"
              . " title: this.title,"
              . " acc_id: this.acc_id,"
              . " id_frm_account2: this.id_frm_account2,"
              . " id_frm_account: formutama.id_frm_account,"
              . " id_frm_account3: this.id_frm_account3,"
              . " id_frm_account4: this.id_frm_account4,"
              . " id_frm_account5: this.id_frm_account5,"
              . " level: this.level}, function(data){"
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
                . "if(hasil.level == 2 || hasil.level == '2'){"
                  . "vm_2nd.replace_items(hasil.data, hasil.data.id);"
                  . "vm_2nd.items_live[vm_2nd.page.select[0]] = hasil.data;"
                  . "vm_2nd.cari($('#search2nd').val());"
                . "}"
                . "if(hasil.level == 3 || hasil.level == '3'){"
                  . "vm_3rd.replace_items(hasil.data, hasil.data.id);"
                  . "vm_3rd.items_live[vm_3rd.page.select[0]] = hasil.data;"
                  . "vm_3rd.cari($('#search3rd').val());"
                . "}"
                . "if(hasil.level == 4 || hasil.level == '4'){"
                  . "vm_4th.replace_items(hasil.data, hasil.data.id);"
                  . "vm_4th.items_live[vm_4th.page.select[0]] = hasil.data;"
                  . "vm_4th.cari($('#search4th').val());"
                . "}"
                . "if(hasil.level == 5 || hasil.level == '5'){"
                  . "vm_5th.replace_items(hasil.data, hasil.data.id);"
                  . "vm_5th.items_live[vm_5th.page.select[0]] = hasil.data;"
                  . "vm_5th.cari($('#search5th').val());"
                . "}"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#page-loading-turunan').hide();"
            . "});"
          . "},"
          . "add_new: function(){"
            . "$('#page-loading-turunan').show();"
            . "$.post('".site_url("frm/frm-master-ajax/account-turunan-set")."', {"
                . " code: this.code,"
                . " acc_id: this.acc_id,"
                . " title: this.title,"
                . " id_frm_account2: this.id_frm_account2,"
                . " id_frm_account: formutama.id_frm_account,"
                . " id_frm_account3: this.id_frm_account3,"
                . " id_frm_account4: this.id_frm_account4,"
                . " id_frm_account5: this.id_frm_account5,"
                . " level: this.level"
              . "}, function(data){"
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
                . "if(hasil.level == 2 || hasil.level == '2'){"
                  . "if(Array.isArray(vm_2nd.items)){"
                    . "vm_2nd.items.push(hasil.data);"
                    . "vm_2nd.items_live.push(hasil.data);"
                  . "}"
                  . "else{"
                    . "vm_2nd.items = vm_2nd.items_live = [hasil.data];"
                  . "}"
                  . "vm_2nd.cari($('#search2nd').val());"
                . "}"
                . "if(hasil.level == 3 || hasil.level == '3'){"
                  . "if(Array.isArray(vm_3rd.items)){"
                    . "vm_3rd.items.push(hasil.data);"
                    . "vm_3rd.items_live.push(hasil.data);"
                  . "}"
                  . "else{"
                    . "vm_3rd.items = vm_3rd.items_live = [hasil.data];"
                  . "}"
                  . "vm_3rd.cari($('#search3rd').val());"
                . "}"
                . "if(hasil.level == 4 || hasil.level == '4'){"
                  . "if(Array.isArray(vm_4th.items)){"
                    . "vm_4th.items.push(hasil.data);"
                    . "vm_4th.items_live.push(hasil.data);"
                  . "}"
                  . "else{"
                    . "vm_4th.items = vm_4th.items_live = [hasil.data];"
                  . "}"
                  . "vm_4th.cari($('#search4th').val());"
                . "}"
                . "if(hasil.level == 5 || hasil.level == '5'){"
                  . "if(Array.isArray(vm_5th.items)){"
                    . "vm_5th.items.push(hasil.data);"
                    . "vm_5th.items_live.push(hasil.data);"
                  . "}"
                  . "else{"
                    . "vm_5th.items = vm_5th.items_live = [hasil.data];"
                  . "}"
                  . "vm_5th.cari($('#search5th').val());"
                . "}"
              . "}"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#page-loading-turunan').hide();"
            . "});"
          . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function account_select_turunan(){
    $html = ""
      . "function select_turunan(vm_table, level){"
        . "var id = vm_table.page.select_value;"
        . "$.post('".site_url("frm/frm-master-ajax/account-get-detail")."', {id_frm_account: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "formturunan.title = hasil.data.title;"
          . "formturunan.level = hasil.data.position;"
          . "formturunan.code = hasil.data.code;"
          . "formturunan.level = hasil.data.level;"
          . "formturunan.acc_id = hasil.data.acc_id;"
          . "if(level == 2){"
            . "formturunan.id_frm_account2 = hasil.data.id_frm_account;"
          . "}"
          . "if(level == 3){"
            . "formturunan.id_frm_account3 = hasil.data.id_frm_account;"
          . "}"
          . "if(level == 4){"
            . "formturunan.id_frm_account4 = hasil.data.id_frm_account;"
          . "}"
          . "if(level == 5){"
            . "formturunan.id_frm_account5 = hasil.data.id_frm_account;"
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
  
}
?>