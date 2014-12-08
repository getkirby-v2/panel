<?php

class DateField extends InputField {

  static public $assets = array(
    'js' => array(
      'moment.min.js',
      'pikaday.min.js',
      'date.js'
    ),
    'css' => array(
      'pikaday.css'
    )
  );

  public function __construct() {

    $this->type   = 'date';
    $this->icon   = 'calendar';
    $this->label  = l::get('fields.date.label', 'Date');
    $this->format = 'YYYY-MM-DD';

  }

  public function format() {
    return str::upper($this->format);
  }

  public function validate() {
    return v::date($this->result());
  }

  public function value() {
    return !empty($this->value) ? date('Y-m-d', strtotime($this->value)) : null;
  }

  public function input() {

    $input = parent::input();
    $input->removeAttr('name');
    $input->data(array(
      'field'  => 'date',
      'format' => $this->format(),
      'i18n'   => html(json_encode(array(
        'previousMonth' => '&lsaquo;',
        'nextMonth'     => '&rsaquo;',
        'months'        => l::get('fields.date.months'),
        'weekdays'      => l::get('fields.date.weekdays'),
        'weekdaysShort' => l::get('fields.date.weekdays.short')
      )), false)
    ));

    $hidden = new Brick('input', null);
    $hidden->type  = 'hidden';
    $hidden->name  = $this->name();
    $hidden->value = $this->value();

    return $input . $hidden;

  }

}
