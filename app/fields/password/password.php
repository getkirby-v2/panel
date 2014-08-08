<?php

class PasswordField extends InputField {

  public function __construct() {

    $this->type  = 'password';
    $this->icon  = 'key';
    $this->label = l::get('fields.password.label', 'Password');

  }

}