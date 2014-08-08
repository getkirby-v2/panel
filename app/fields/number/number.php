<?php

class NumberField extends InputField {

  public function __construct() {

    $this->type        = 'number';
    $this->label       = l::get('fields.number.label', 'Number');
    $this->placeholder = l::get('fields.number.placeholder', '#');

  }

  public function validate() {
    return v::num($this->result());
  }

}