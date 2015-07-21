<?php

class Draft extends Page {

  public $parent;
  public $template;

  public function __construct($id, $template) {

    parent::__construct(site(), '.draft');

    $file = $this->textfile($template);

    data::write($file, array(
      'kirbyparenturi' => $id
    ), 'kd');

  }

}