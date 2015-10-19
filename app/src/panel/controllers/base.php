<?php

namespace Kirby\Panel\Controllers;

use Obj;
use R;
use Response;

use Kirby\Panel\Assets;
use Kirby\Panel\Layout;
use Kirby\Panel\View;
use Kirby\Panel\Snippet;
use Kirby\Panel\Topbar;

class Base extends Obj {

  public function redirect($obj = '/', $action = false, $force = false) {    
    return panel()->redirect($obj, $action, $force);
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
        $defaults['csrf']    = panel()->csrf();
        $defaults['formcss'] = css(panel()->urls()->css() . '/form.css?v=' . panel()->version());
        $defaults['formjs']  = js(panel()->urls()->js()   . '/form.js?v='  . panel()->version());
        $defaults['appjs']   = js(panel()->urls()->js()   . '/app.js?v='   . panel()->version());
        break;
      case 'base':
        break;
    }

    $data = array_merge($defaults, $data);

    if(r::ajax() and $type == 'app') {
      $response = array(
        'title'   => $data['title'],
        'content' => $data['topbar'] . $data['content']
      );
      return response::json($response);
    } else {
      return new Layout($type, $data);      
    }

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

  public function json($data = array()) {
    return response::json($data);
  }

}