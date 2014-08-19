<?php

class InputField extends BaseField {

  public $type;

  public function input() {

    $input = new Brick('input');
    $input->addClass('input');
    $input->attr(array(
      'type'         => $this->type(),
      'value'        => html($this->value(), false),
      'required'     => $this->required(),
      'name'         => $this->name(),
      'autocomplete' => $this->autocomplete() === false ? 'off' : 'on',
      'autofocus'    => $this->autofocus(),
      'placeholder'  => $this->i18n($this->placeholder()),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      'id'           => $this->id()
    ));

    if($this->readonly()) {
      $input->attr('tabindex', '-1');
      $input->addClass('input-is-readonly');
    }

    return $input;

  }

}