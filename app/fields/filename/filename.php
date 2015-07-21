<?php

class FilenameField extends InputField {

  public $type      = 'text';
  public $extension = null;
  public $icon      = true;

  public function type() {
    return $this->type = 'text';
  }

  public function icon() {

    $icon = new Brick('div');
    $icon->addClass('field-icon');
    $icon->append('<span>.' . $this->extension . '</span>');

    return $icon;

  }

}
