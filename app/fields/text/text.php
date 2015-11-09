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
    $this->min    = 0;
    $this->max    = false;
  }

  public function validate() {

    if($this->validate and is_array($this->validate)) {
      return parent::validate();
    } else {
      if($this->min and !v::min($this->result(), $this->min)) return false;
      if($this->max and !v::max($this->result(), $this->max)) return false;
    }

    return true;

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

    $input = new Brick('input', null);
    $input->addClass('input');

    if (!$this->readonly() && ($this->min() || $this->max())) {
      $input->data('max', $this->max())->data('min', $this->min());
    }

    $input->attr(array(
      'type'         => $this->type(),
      'value'        => '',
      'required'     => $this->required(),
      'name'         => $this->name(),
      'autocomplete' => $this->autocomplete() === false ? 'off' : 'on',
      'autofocus'    => $this->autofocus(),
      'placeholder'  => $this->i18n($this->placeholder()),
      'readonly'     => $this->readonly(),
      'disabled'     => $this->disabled(),
      'id'           => $this->id()
    ));

    if(!is_array($this->value())) {
      $input->val(html($this->value(), false));
    }

    if($this->readonly()) {
      $input->attr('tabindex', '-1');
      $input->addClass('input-is-readonly');
    }

    return $input;

  }

  public function outsideRange($length) {

    if ($this->min() && $length < $this->min()) {
      return true;
    }

    if ($this->max() && $length > $this->max()) {
      return true;
    }

    return false;
  }

  public function counter() {

    if(!$this->min() && !$this->max() || $this->readonly()) return null;

    $counter = new Brick('div');
    $counter->addClass('field-counter marginalia text');

    $length = strlen($this->value());

    if ($this->outsideRange($length)) {
      $counter->addClass('outside-range');
    }

    $counter->data('field', 'counter')->data('count', $this->name());
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
