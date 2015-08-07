<?php

class Controller extends Obj {

  public function redirect() {    
    return call(array(panel(), 'redirect'), func_get_args());
  }

  public function notify($message) {
    panel()->notify($message);
  }

  public function alert($message) {
    panel()->alert($message);
  }

  public function form($id, $data = array(), $submit = null) {
    return panel()->form($id, $data, $submit);
  }

  public function page($id) {
    return panel()->page($id);
  }

  public function user($username = null) {
    return panel()->user($username);
  }

}