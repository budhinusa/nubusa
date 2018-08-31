<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

print "<script type='text/javascript'>"
    . "$('a').click(function(){"
      . "var url = $(this).attr('href');"
      . "if(url == 'javascript:void(0)'){"
        . "return true;"
      . "}"
      . "else{"
      . "$.post(url, function(data){"
        . "$('#isi-content').html(data);"
      . "});"
        . "return false;"
      . "}"
    . "});"
  . '</script>';