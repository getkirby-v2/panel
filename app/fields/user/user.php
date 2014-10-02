<?php

class UserField extends InputField {

  public function __construct() {
    $this->type        = 'text';
    $this->icon        = 'user';
    $this->label       = l::get('fields.user.label', 'User');
    $this->placeholder = l::get('fields.user.placeholder', 'Username…');
  }

  public function input() {

    $input = parent::input();
    $input->data(array(
      'field' => 'autocomplete',
      'url'   => panel()->urls()->api() . '/autocomplete/usernames'
    ));

    return $input;

  }

}