<?php

class TextField extends InputField {

  public $type = 'text';
  public $min  = 0;
  public $max  = false;

  static public $assets = array(
    'js' => array(
      'counter.js'
    ),
    'css' => array(
      'counter.css'
    )
  );

  public function __construct() {
    $this->min = 0;
    $this->max = false;
  }

  public function validate() {

    if($this->min and !v::min($this->result(), $this->min)) return false;
    if($this->max and !v::max($this->result(), $this->max)) return false;

    return parent::validate();

  }

  public function min() {
    if (isset($this->validate['min'])) {
      return $this->validate['min'];
    }
    return false;
  }

  public function max() {
    if (isset($this->validate['max'])) {
      return $this->validate['max'];
    }
    return false;
  }

  public function input() {

    $input = parent::input();

    if(!$this->readonly() && ($this->min() || $this->max())) {
      $input->data('max', $this->max())->data('min', $this->min());
    }

    return $input;

  }

  public function outsideRange($length) {

    if($this->min() && $length < $this->min()) {
      return true;
    }

    if($this->max() && $length > $this->max()) {
      return true;
    }

    return false;

  }

  public function counter() {

    if(!$this->min() && !$this->max() || $this->readonly()) return null;

    $counter = new Brick('div');
    $counter->addClass('field-counter marginalia text');

    $length = str::length($this->value());

    if($this->outsideRange($length)) {
      $counter->addClass('outside-range');
    }

    $counter->data('field', 'counter');
    $counter->html($length . ($this->max() ? '/' . $this->max() : ''));

    return $counter;

  }

  public function template() {

    return $this->element()
      ->append($this->label())
      ->append($this->content())
      ->append($this->counter())
      ->append($this->help());

  }

}
