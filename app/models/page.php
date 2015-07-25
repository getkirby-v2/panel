<?php

class PageModel {

  public $source;

  public function __construct($id) {

    $this->source = ($id == '/' or empty($id)) ? site() : page($id);

    if(!$this->source) {
      throw new Exception('The page could not be found');
    }

  }

  

}