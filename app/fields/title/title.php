<?php

class TitleField extends InputField {

  public function __construct() {

    $this->type     = 'text';
    $this->label    = l::get('fields.title.label', 'Title');
    $this->icon     = 'font';
    $this->required = true;

  }

  public function type() {
    return $this->type = 'text';
  }

}
