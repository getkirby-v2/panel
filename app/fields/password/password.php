<?php

class PasswordField extends InputField {

  static public $assets = array(
    'js' => array(
      'password.js'
    )
  );

  public $suggestion = false;

  public function __construct() {

    $this->type  = 'password';
    $this->icon  = 'key';
    $this->label = l::get('fields.password.label', 'Password');

  }

  public function input() {

    $input = parent::input();

    if($this->suggestion) {
      $input->data(array(
        'field' => 'passwordSuggestion'
      ));
    }

    return $input;

  }

  public function help() {    
    if($this->suggestion and !$this->readonly) {
      $this->help = $this->suggestion();
    }
    return parent::help();
  }

  public function suggestion() {
    return '<code class="pw-suggestion"></code><a class="pw-reload" href="#"><i class="fa fa-refresh icon"></i></a>';      
  }

}