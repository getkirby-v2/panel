<?php

class TextField extends InputField {

  public $type = 'text';
  public $min  = 0;
  public $max  = false;

  public function __construct() {
    $this->min    = 0;
    $this->max    = false;
  }

  public function validate() {

    if($this->min and !v::min($this->result(), $this->min)) return false;
    if($this->max and !v::max($this->result(), $this->max)) return false;

    return parent::validate();

  }

}
