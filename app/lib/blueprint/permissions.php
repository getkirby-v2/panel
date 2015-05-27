<?php

namespace Blueprint;

use A;
use Obj;

class Permissions extends Obj {

  public $create    = true;
  public $update    = true;
  public $delete    = true;
  public $replace   = true;
  public $changeurl = true;
  public $hide      = true;
  public $sort      = true;

  public function __construct($params = array(), $target) {

    switch ($target)  {
      case 'page':
        if ($params == false) {
          $this->update     = false;
          $this->delete     = false;
          $this->changeurl  = false;
          $this->hide       = false;
        } else if (is_array($params)){
          $this->update     = a::get($params, 'update', $this->update);
          $this->delete     = a::get($params, 'delete', $this->delete);
          $this->changeurl  = a::get($params, 'changeurl', $this->changeurl);
          $this->hide       = a::get($params, 'hide', $this->hide);
        }
        break;
      case 'subpages':
        if ($params == false) {
          $this->create     = false;
          $this->sort       = false;
        } else if (is_array($params)){
          $this->create     = a::get($params, 'create', $this->create);
          $this->sort       = a::get($params, 'sort', $this->sort);
        }
        break;
      case 'files':
        if ($params == false) {
          $this->create     = false;
          $this->update     = false;
          $this->replace    = false;
          $this->delete     = false;
        } else if (is_array($params)){
          $this->create     = a::get($params, 'upload', $this->create);
          $this->update     = a::get($params, 'update', $this->update);
          $this->replace    = a::get($params, 'replace', $this->replace);
          $this->delete     = a::get($params, 'delete', $this->delete);
        }
        break;
    }

  }

  public function allowed($permission, $role) {
    if ($role == 'admin')
      return true;
    elseif(is_array($this->{$permission}))
      return in_array($role, $this->{$permission});
    else
      return $this->{$permission};
  }

  public function set($permission, $value) {
    if ($value !== null)
      $this->{$permission} = $value;
  }



}
