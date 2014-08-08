<?php

namespace Blueprint;

use Collection;

class Fields extends Collection {

  public function toArray($callback = null) {
    $result = array();
    foreach($this->data as $field) {
      $result[$field->name()] = $field->toArray();
    }
    return $result;
  }

}