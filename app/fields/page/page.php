<?php

class PageField extends TextField {

  public function __construct() {

    $this->icon        = 'chain';
    $this->label       = l::get('fields.page.label', 'Page');
    $this->placeholder = l::get('fields.page.placeholder', 'path/to/page');
    $this->index       = 'pages';
    $this->template    = false;

  }

  public function input() {

    $input = parent::input();
    $input->data(array('field' => 'autocomplete'));

    $query = array(
      'uri'       => $this->page()->id(),
      'index'     => $this->index(),
      'template'  => $this->template
    );

    $input->data('url', panel()->urls()->api() . '/autocomplete/uris?' . http_build_query($query));

    return $input;

  }

}