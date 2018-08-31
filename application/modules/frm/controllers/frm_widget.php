<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frm_widget extends MX_Controller {
    
  function __construct() {
  }
  
  
  /**
   * code: frmwidget
   */
  function kurs(){
    $url = site_url();
    print ""
    . "<div class='box box-info box-solid'>"
      . "<div class='box-header with-border'>"
        . "<h3 class='box-title'>".lang("Rate Bayar Tunai & Credit Card")."</h3>"
        . "<div class='box-tools pull-right'>"
          . "<button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>"
        . "</div>"
      . "</div>"
      . "<div class='box-body'>"
        . "<table class='table'>"
          . "<tbody>"
            . "<tr>"
              . "<th style='width: 10px'>#</th>"
              . "<th>Task</th>"
              . "<th>Progress</th>"
              . "<th>Label</th>"
            . "</tr>"
            . "<tr>"
              . "<td>1.</td>"
              . "<td>Update software</td>"
              . "<td>"
                . "<div class='progress progress-xs'>"
                  . "<div class='progress-bar progress-bar-danger' style='width: 55%'>"
                  . "</div>"
                . "</div>"
              . "</td>"
              . "<td>"
                . "<span class='badge bg-red'>55%</span>"
              . "</td>"
            . "</tr>"
          . "</tbody>"
        . "</table>"
      . "</div>"
    . "</div>"
    . "";
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */