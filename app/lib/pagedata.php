<?php

class PageData {

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
