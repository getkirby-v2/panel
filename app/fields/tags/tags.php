<?php

class TagsField extends TextField {

  static public $assets = array(
    'js' => array(
      'tags.min.js'
    )
  );

  public function __construct() {

    $this->icon      = 'tag';
    $this->label     = l::get('fields.tags.label', 'Tags');
    $this->index     = 'siblings';
    $this->field     = 'tags';
    $this->separator = ',';
    $this->lower     = false;

  }

  public function input() {

    $input = parent::input();
    $input->addClass('input-with-tags');
    $input->data(array(
      'field'     => 'tags',
      'lowercase' => $this->lower,
      'separator' => $this->separator,
    ));

    if($page = $this->page()) {

      $query = array(
        'uri'       => $page->id(),
        'index'     => $this->index(),
        'field'     => $this->field(),
        'separator' => $this->separator()
      );

      $input->data('url', url('panel/api/autocomplete/field?' . http_build_query($query)));

    }

    return $input;

  }

}