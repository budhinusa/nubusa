<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrm_widget extends MX_Controller {
    
  function __construct() {
  }
  
  
  /**
   * code: hrmwidget
   */
  function hrd_and_training_detail(){
    $this->template
      ->set_layout('default')
      ->build('widget/hrd-training-detail', array(
        'url'         => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'        => "home",
        'title'       => lang("HRD And Training"),
        'foot'        => $foot,
        'css'         => $css,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("widget/hrd-training-detail");
  }
  
  function hrd_and_training(){
    $url = site_url();
    $onhover = <<<EOD
      <img src='{$url}/files/hrm/widget/hrd-and-training.jpg' width='100%' onmouseover="this.src='{$url}/files/hrm/widget/hrd-and-training-color.jpg'" onmouseout="this.src='{$url}/files/hrm/widget/hrd-and-training.jpg';" />
EOD;
    print ""
    . "<style>"
      . ".hrmwidget-box{"
        . "border-radius: 3px;"
        . "background: #ffffff;"
        . "margin-bottom: 20px;"
        . "width: 100%;"
        . "box-shadow: 0 1px 1px rgba(0,0,0,0.1);"
      . "}"
      . ".hrmwidget-box-widget{"
        . "border: none;"
        . "position: relative;"
      . "}"
      . ".hrmwidget-widget-user-2 .hrmwidget-widget-user-header {"
        . "padding: 20px;"
        . "border-top-right-radius: 3px;"
        . "border-top-left-radius: 3px;"
      . "}"
//      . ".hrmwidget-bg-yellow {"
//        . "background-color: #f39c12 !important;"
//      . "}"
//      . ".hrmwidget-bg-yellow:hover {"
//        . "background-color: #fffff !important;"
//      . "}"
    . "</style>"
    . "<div class='hrmwidget-box hrmwidget-box-widget hrmwidget-widget-user-2'>"
      . "<div class='hrmwidget-widget-user-header hrmwidget-bg-yellow'>"
        . "<a href='".site_url("hrm/hrm-widget/hrd-and-training-detail")."'>"
          . "{$onhover}"
        . "</a>"
      . "</div>"
    . "</div>"
    . "";
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */