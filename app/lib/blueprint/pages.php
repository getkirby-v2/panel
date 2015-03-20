<?php

namespace Blueprint;

use A;
use Blueprint;
use Collection;
use Obj;

class Pages extends Obj {

  public $template    = array();
  public $sort        = null;
  public $limit       = 20;
  public $num         = null;
  public $max         = null;
  public $hide        = false;
  public $permissions = null;
  public $build       = array();

  public function __construct($params = array()) {

    if($params === true) {
      $this->template = blueprint::all();
    } else if($params === false) {
      $this->limit        = 0;
      $this->max          = 0;
      $this->sortable     = false;
      $this->permissions  = new Permissions(false, 'subpages');
      $this->hide         = true;
    } else if(is_array($params)) {
      $template = a::get($params, 'template');
      if($template == false) {
        $this->template = blueprint::all();
      } else if(is_array($template)) {
        $this->template = $template;
      } else {
        $this->template = array($template);
      }
      $this->sort         = a::get($params, 'sort', $this->sort);
      $this->limit        = a::get($params, 'limit', $this->limit);
      $this->num          = a::get($params, 'num', $this->num);
      $this->max          = a::get($params, 'max', $this->max);
      $this->hide         = a::get($params, 'hide', $this->hide);
      $this->permissions  = new Permissions(a::get($params, 'permissions', $this->permissions), 'subpages');
      // fallback for former 'sortable' option
      if ($this->permissions->sort == null)
        $this->permissions->set('sort', a::get($params, 'sortable', null));
      $this->build        = a::get($params, 'build', $this->build);
    } else if(is_string($params)) {
      $this->template = array($params);
    }

  }

  public function can($permission, $role) {
    return ($this->permissions == null) ? true : $this->permissions->allowed($permission, $role);
  }

  public function template() {
    $result = array();
    foreach($this->template as $t) {
      $result[$t] = new Blueprint($t);
    }
    return new Collection($result);
  }

  public function num() {

    $obj = new Obj();

    $obj->mode   = 'default';
    $obj->field  = null;
    $obj->format = null;

    if(is_array($this->num)) {
      foreach($this->num as $k => $v) $obj->$k = $v;
    } else if(!empty($this->num)) {
      $obj->mode = $this->num;
    }

    switch($obj->mode) {
      case 'date':
        isset($obj->field)  or $obj->field  = 'date';
        isset($obj->format) or $obj->format = 'Ymd';
        break;
    }

    return $obj;

  }

}
