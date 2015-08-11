<?php

namespace Kirby\Panel\Models\User;

use Exception;

class History {

  static public function visit($uri) {

    if(empty($uri)) return;

    $history = panel()->user()->history();

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
      panel()->user()->update(array(
        'history' => $history
      ));
    } catch(Exception $e) {

    }

  }

  static public function get() {

    $history = panel()->user()->history();

    if(empty($history) or !is_array($history)) {
      return array();
    }

    $update = false;
    $result = array();

    foreach($history as $item) {

      try {
        $result[] = panel()->page($item);        
      } catch(Exception $e) {
        $update = true;
      }

    }

    if($update) {

      $history = array_map(function($item) {
        return $item->id();
      }, $result);

      try {
        panel()->user()->update(array(
          'history' => $history
        ));
      } catch(Exception $e) {

      }

    }

    return $result;

  }

}