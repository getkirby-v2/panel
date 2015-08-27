<?php

namespace Kirby\Panel;

use Obj;

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

  public function layout($type, $data = array()) {

    $defaults = array(
      'title'     => panel()->site()->title() . ' | Panel',
      'direction' => panel()->direction(),
      'meta'      => $this->snippet('meta'),
      'css'       => Assets::css(),
      'js'        => Assets::js(),
      'content'   => ''
    );    

    switch($type) {
      case 'app':
        $defaults['topbar']  = '';
        $defaults['formcss'] = Form::css();
        $defaults['formjs']  = Form::js(false);
        $defaults['appjs']   = js(panel()->urls()->js() . '/app.js?v=' . panel()->version());
        break;
      case 'base':
        break;
    }

    return new Layout($type, array_merge($defaults, $data));

  }

  public function view($file, $data = array()) {
    return new View($file, $data);
  }

  public function snippet($file, $data = array()) {
    return new Snippet($file, $data);
  }

  public function topbar($view, $input) {
    return new Topbar($view, $input);
  }

  public function screen($view, $topbar = null, $data = array()) {
    return $this->layout('app', array(
      'topbar'  => is_a($topbar, 'Kirby\\Panel\\Topbar') ? $topbar : $this->topbar($view, $topbar),
      'content' => is_a($data,   'Kirby\\Panel\\View')   ? $data   : $this->view($view, $data)
    ));
  }

  public function modal($view, $data = array()) {
    if($view === 'error') $view = 'error/modal';  
    return $this->layout('app', array('content' => $this->view($view, $data)));
  }

}