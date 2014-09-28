<?php

class PageField extends InputField {

  public function __construct() {

    $this->type        = 'text';
    $this->icon        = 'chain';
    $this->label       = l::get('fields.page.label', 'Page');
    $this->placeholder = l::get('fields.page.placeholder', 'path/to/page');

  }

  public function input() {

    $input = parent::input();
    $input->data(array(
      'field' => 'autocomplete',
      'url'   => panel()->urls()->api() . '/autocomplete/uris'
    ));

    return $input;

  }

}