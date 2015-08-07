<?php

function panel() {
  return panel::instance();
}

function icon($icon, $position) {
  return '<i class="icon' . r($position, ' icon-' . $position) . ' fa fa-' . $icon . '"></i>';
}

function i($icon, $position = null) {
  echo icon($icon, $position);
}

function __($var) {
  echo htmlspecialchars($var);
}

function _l($key, $default = null) {
  echo htmlspecialchars(l($key, $default));
}

function _u($obj = '', $action = false) {
  echo purl($obj, $action);
}

function purl($obj = '/', $action = false) {
  $base = panel()->urls()->index();
  if(is_string($obj)) {    
    return ($obj == '/' or empty($obj)) ? $base . '/' : rtrim($base . '/' . $obj, '/');
  } else if(is_a($obj, 'PageModel') or is_a($obj, 'FileModel') or is_a($obj, 'UserModel')) {
    return $obj->url($action ? $action : 'edit');
  }
}

function layout($file, $data = array()) {
  return new Layout($file, $data);
}

function view($file, $data = array()) {
  return new View($file, $data);
}

function topbar($view, $input) {
  return new Topbar($view, $input);
}

function screen($view, $topbar = null, $data = array()) {
  return layout('app', array(
    'topbar'  => is_a($topbar, 'Topbar')  ? $topbar : topbar($view, $topbar),
    'content' => is_a($data, 'View')      ? $data   : view($view, $data)
  ));
}

function modal($view, $data = array()) {
  if($view === 'error') $view = 'error/modal';  
  return layout('app', array('content' => view($view, $data)));
}