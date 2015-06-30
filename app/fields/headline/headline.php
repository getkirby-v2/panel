<?php

class HeadlineField extends BaseField {

  static public $assets = array(
    'css' => array(
      'headline.css'
    )
  );

  public function result() {
    return null;
  }

  public function label() {
    return null;
  }

  public function content() {
    return '<h2 class="hgroup hgroup-single-line hgroup-compressed cf"><span class="hgroup-title">' . $this->i18n($this->label) . '</span></h2>';
  }

  public function element() {
    $element = parent::element();
    $element->addClass('field-with-headline');
    return $element;
  }

}
