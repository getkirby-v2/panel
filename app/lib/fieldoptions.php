<?php

class FieldOptions {

  public $field;
  public $options = array();

  static public function build($field) {
    $obj = new static($field);
    return $obj->toArray();
  }

  public function __construct($field) {

    $this->field = $field;

    if(is_array($field->options)) {
      $this->options = $field->options;
    } else if(!$field->page) {
      $this->options = array();
    } else if($field->options == 'query') {

      $defaults = array(
        'page'  => $field->page->id(),
        'fetch' => 'children',
        'value' => '{{uid}}',
        'text'  => '{{title}}',
        'flip'  => false
      );

      $query   = array_merge($defaults, $field->query);
      $page    = page($query['page']);
      $items   = $this->items($page, $query['fetch']);

      if($query['flip']) {
        $items = $items->flip();
      }

      foreach($items as $item) {

        $value = $this->tpl($query['value'], $item);
        $text  = $this->tpl($query['text'], $item);

        $this->options[$value] = $text;

      }

    } else if($items = $this->items($field->page, $field->options)) {

      foreach($items as $item) {

        if(is_a($item, 'Page')) {
          $this->options[$item->uid()] = (string)$item->title();
        } else if(is_a($item, 'File')) {
          $this->options[$item->filename()] = (string)$item->filename();
        }

      }

    } else {
      $this->options = array();
    }

  }

  protected function tpl($string, $obj) {

    return preg_replace_callback('!\{\{(.*?)\}\}!', function($item) use($obj) {
      return (string)$obj->{$item[1]}();
    }, $string);

  }

  protected function items($page, $method) {

    switch($method) {
      case 'visibleChildren':
        $items = $page->children()->visible();
        break;
      case 'invisibleChildren':
        $items = $page->children()->invisible();
        break;
      case 'siblings':
        $items = $page->siblings()->not($page);
        break;
      case 'pages':
        $items = site()->index();
        $items = $items->sortBy('title', 'asc');
        break;
      case 'index':
        $items = $page->index();
        $items = $items->sortBy('title', 'asc');
        break;
      case 'children':
      case 'files':
      case 'images':
      case 'documents':
      case 'videos':
      case 'audio':
      case 'code':
      case 'archives':
        $items = $page->{$method}();
        break;
    }

    return $items;

  }

  public function toArray() {
    return $this->options;
  }

}