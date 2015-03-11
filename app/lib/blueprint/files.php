<?php

namespace Blueprint;

use A;
use Obj;

class Files extends Obj {

  public $fields   = array();
  public $max      = null;
  public $hide     = false;
  public $sort     = null;
  public $sortable = false;
  public $sanitize = true;
  public $type     = array();

  public function __construct($params = array()) {

    // start the fields collection
    $this->params = $params;

    if($params === false) {
      $this->max      = 0;
      $this->sortable = false;
      $this->hide     = true;
      $this->type     = array();
      $this->fields   = array();
    } else if(is_array($params)) {
      $this->max      = a::get($params, 'max', $this->max);
      $this->hide     = a::get($params, 'hide', $this->hide);
      $this->sort     = a::get($params, 'sort', $this->sort);
      $this->sortable = a::get($params, 'sortable', $this->sortable);
      $this->fields   = a::get($params, 'fields', array());
      $this->sanitize = a::get($params, 'sanitize', true);

      $this->type     = a::get($params, 'type', array());
      if (!is_array($this->type)) {
        $this->type   = array($this->type);
      }


    }

  }

  public function fields($page = null) {
    return new Fields($this->fields, $page);
  }

}
