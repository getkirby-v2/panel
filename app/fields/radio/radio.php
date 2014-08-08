<?php

class RadioField extends InputListField {

  public function input() {
    $input = parent::input();
    $input->addClass('radio');
    $input->attr('type', 'radio');
    $input->attr('checked', func_get_arg(0) == $this->value());
    return $input;
  }

  public function item($value, $text) {
    $item = parent::item($value, $text);
    $item->addClass('input-with-radio');
    return $item;
  }

}
