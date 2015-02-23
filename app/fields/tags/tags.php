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

    if(isset($this->data)) {

      $input->data('url', html(json_encode($this->data), false));

    } else if($page = $this->page()) {

      $field = empty($this->field) ? $this->name() : $this->field;

      $query = array(
        'index'     => $this->index(),
        'field'     => $field,
        'separator' => $this->separator()
      );

      if (!empty($this->template)) {
          $query['template'] = $this->template;
      }
      if(empty($this->template) && $this->index() != "all") {
          $query['id'] = $page->id();
      }
      $input->data('url', panel()->urls()->api() . '/autocomplete/field?' . http_build_query($query));

    }

    return $input;

  }

}
