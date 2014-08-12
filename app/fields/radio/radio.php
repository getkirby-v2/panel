<?php

class RadioField extends InputListField {

  public function input() {
    $val   = func_get_arg(0);
    $input = parent::input();
    $input->addClass('radio');
    $input->attr('type', 'radio');
    $input->val($val);
    $input->attr('checked', $val == $this->value());
    return $input;
  }

  public function item($value, $text) {
    $item = parent::item($value, $text);
    $item->addClass('input-with-radio');
    return $item;
  }

}
