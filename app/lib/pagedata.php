<?php

class PageData {

  static public function createByInput($page, $input = array()) {
    $data = array();
    foreach($page->content()->toArray() as $key => $value) {
      if(strtolower($key) == 'url_key') {
        // don't erase the url key
        continue;
      } else {
        $data[$key] = null;  
      }      
    }
    return array_merge($data, $input);
  }

  static public function createByBlueprint($blueprint, $input = array()) {

    $bp = blueprint::find($blueprint);

    if(!$bp) return $input;

    $data = array();

    foreach($bp->fields() as $key => $field) {
      $data[$key] = $field->default();
    }

    return array_merge($data, $input);

  }

}
