<?php
class File_management{
  public function get($file){
    if (file_exists($file)){
      return file_get_contents($file);
    }
    return 0;
  }
}
?>
