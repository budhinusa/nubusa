<?php 
print $css;
include 'notice.php';
print "<section class='content-header'>";
print_r($template['heads']);
print "</section>";
print $template['body'];
print $foot;