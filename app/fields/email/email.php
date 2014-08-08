<?php

class EmailField extends InputField {

  public function __construct() {

    $this->type        = 'email';
    $this->icon        = 'envelope';
    $this->label       = l::get('fields.email.label', 'Email');
    $this->placeholder = l::get('fields.email.placeholder', 'mail@example.com');

  }

  public function input() {

    $input = parent::input();
    $input->data(array(
      'field' => 'autocomplete',
      'url'   => url('panel/api/autocomplete/emails')
    ));

    return $input;

  }

  public function validate() {
    return v::email($this->result());
  }

}