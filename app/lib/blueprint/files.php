<?php

namespace Blueprint;

use A;
use Obj;

class Files extends Obj {

  public $fields   = array();
  public $max      = null;
  public $sort     = null;
  public $sortable = false;

  public function __construct($params = array()) {

    // start the fields collection
    $this->fields = new Fields();

    if($params === false) {
      $this->max      = 0;
      $this->sortable = false;
    } else if(is_array($params)) {
      $this->max      = a::get($params, 'max', $this->max);
      $this->sort     = a::get($params, 'sort', $this->sort);
      $this->sortable = a::get($params, 'sortable', $this->sortable);

      foreach(a::get($params, 'fields', array()) as $name => $field) {

        // add the name to the field
        $field['name'] = $name;

        // creat the field object
        $field = new Field($field);

        // append it to the collection
        $this->fields->append($name, $field);

      }

    }

  }

}