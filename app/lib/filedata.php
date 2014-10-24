<?php

class FileData {

  static public function createByInput($file, $input = array()) {
    $data = array();
    foreach($file->meta()->toArray() as $key => $value) {
      if(strtolower($key) == 'sort') continue;
      $data[$key] = null;
    }
    return array_merge($data, $input);
  }

}
