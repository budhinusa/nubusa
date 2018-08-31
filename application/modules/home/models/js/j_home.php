<?php
class J_home extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function widget_variable(){
    $html = ""
      . "var variable_widget = new Vue({"
        . "el: '#row-widget',"
        . "data: {"
          . "tampil: {"
            . "hrd: '',"
            . "kurs: '',"
          . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function widget_get_hrd(){
    $html = ""
      . "function get_hrd(){"
        . "$.post('".site_url("hrm/hrm-widget/hrd-and-training")."', {}, function(data){"
          . "variable_widget.tampil.hrd = data;"
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
  
  function widget_get_kurs(){
    $html = ""
      . "function get_kurs(){"
        . "$.post('".site_url("frmantavaya/frmantavaya-widget/kurs-bca")."', {}, function(data){"
          . "variable_widget.tampil.kurs = data;"
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
