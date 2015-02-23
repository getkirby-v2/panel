<?php

class UrlField extends InputField {

  public function __construct() {

    $this->type        = 'url';
    $this->icon        = 'chain';
    $this->label       = l::get('fields.url.label', 'URL');
    $this->placeholder = 'http://';

  }

  public function validate() {
    return v::url($this->value());
  }

}