<?php

class Snippet extends View {

  public function __construct($file, $data = array()) {
    parent::__construct($file, $data);
    $this->root = panel::instance()->roots()->snippets();
  }

}