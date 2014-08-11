<?php

class History {

  static public function visit($uri) {

    $history = site()->user()->history();

    if(empty($history) or !is_array($history)) {
      $history = array();
    }

    // remove existing entries
    foreach($history as $key => $val) {
      if($val == $uri) unset($history[$key]);
    }

    array_unshift($history, $uri);
    $history = array_slice($history, 0, 5);

    try {
      site()->user()->update(array(
        'history' => $history
      ));
    } catch(Exception $e) {

    }

  }

  static public function get() {

    $history = site()->user()->history();

    if(empty($history) or !is_array($history)) {
      return array();
    }

    $update = false;
    $result = array();

    foreach($history as $item) {

      $page = page($item);

      if(!$page) {
        $update = true;
      } else {
        $result[] = $page;
      }

    }

    if($update) {

      $history = array_map(function($item) {
        return $item->id();
      }, $result);

      try {
        site()->user()->update(array(
          'history' => $history
        ));
      } catch(Exception $e) {

      }

    }

    return $result;

  }

}