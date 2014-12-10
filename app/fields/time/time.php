<?php

class TimeField extends SelectField {
  
  public $override = false;
  
  public function __construct() {
    $this->icon     = 'clock-o';
    $this->interval = 60;
    $this->format   = 24;
  }

  public function value() {

    if($this->override()) {
      $value = $this->default();
    } else {
      $value = parent::value();
    }

    if(empty($value)) {
      $time  = round(time() / ($this->interval * 60)) * ($this->interval * 60);
      $value = date($this->format(), $time);
    }

    return $value;

  }

  public function format() {
    return $this->format == 12 ? 'h:i A' : 'H:i';
  }

  public function options() {

    $time    = strtotime('00:00');
    $end     = strtotime('23:59');
    $options = array();
    $format  = $this->format();

    while($time < $end) {

      $now    = date($format, $time);
      $time  += 60 * $this->interval;

      $options[$now] = $now;

    }

    return $options;

  }

}