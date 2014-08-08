<?php

class InputField extends BaseField {

  public $type;

  public function input() {

    $input = new Brick('input');
    $input->addClass('input');
    $input->attr(array(
      'type'         => $this->type(),
      'value'        => $this->value(),
      'required'     => $this->required(),
      'name'         => $this->name(),
      'autocomplete' => $this->autocomplete(),
      'autofocus'    => $this->autofocus(),
      'placeholder'  => $this->i18n($this->placeholder()),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      'id'           => $this->id()
    ));

    if($this->readonly()) {
      $input->addClass('input-is-readonly');
    }

    return $input;

  }

}