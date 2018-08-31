<?php
class Html_format{
  function __construct(){
      
  }
  
  /**
   * @author NBS
   */
  function pesan_success($title, $isi = NULL){
    $html = ""
      . '<div class="alert alert-success alert-dismissable">'
        . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
        . '<h4>	<i class="icon fa fa-check"></i>'
          . $title
        . '</h4>'
        . $isi
      . '</div>'
      . "";
    return $html;
  }
    
}
?>
