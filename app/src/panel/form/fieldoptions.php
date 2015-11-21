<?php

namespace Kirby\Panel\Form;

use Collection;
use Str;
use Remote;
use V;

class FieldOptions {

  public $field;
  public $options = array();

  static public function build($field) {
    $obj = new static($field);
    return $obj->toArray();
  }

  public function __construct($field) {

    $this->field = $field;

    // array method
    if(is_array($field->options)) {
      $this->options = $field->options;
    
    // api method with valid url
    } else if(v::url($field->options) or str::contains($field->options, '://localhost') or str::contains($field->options, '://127.0.0.1')) {
      
      $response = remote::get($field->options);
      $options  = @json_decode($response->content(), true);

      if(is_array($options)) {
        $this->options = $options;        
      } else {
        $this->options = array();
      }

    // without a page object, no files or related pages can be fetched
    } else if(!$field->page) {
      $this->options = array();

    // query method to query any set of images or files
    } else if($field->options == 'query') {

      $defaults = array(
        'page'     => $field->page->id(),
        'fetch'    => 'children',
        'value'    => '{{uid}}',
        'text'     => '{{title}}',
        'flip'     => false,
        'template' => false
      );

      $query = array_merge($defaults, $field->query);
      
      // dynamic page option 
      // ../
      // ../../ etc.

      if(str::startsWith($query['page'], '../')) {
        $currentPage = $field->page;
        $path        = $query['page']; 
        while(str::startsWith($path, '../')) {
          if($parent = $currentPage->parent()) {
            $currentPage = $parent;
          } else {
            break;
          }
          $path = str::substr($path, 3);
        }
        $page = $currentPage;
      } else if($query['page'] == '/') {
        $page = site();
      } else {
        $page = page($query['page']);        
      }

      $items = $this->items($page, $query['fetch']);

      if($query['template']) {
        $items = $items->filter(function($item) use($query) {
          return in_array(str::lower($item->intendedTemplate()), array_map('str::lower', (array)$query['template']));
        });
      }

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

    // sorting

    if(!empty($this->field->sort)) {

      switch(strtolower($this->field->sort)) {
        case 'asc':
          asort($this->options);
          break;
        case 'desc':
          arsort($this->options);
          break;
      }

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
      case 'visibleSiblings':
        $items = $page->siblings()->not($page)->visible();
        break;
      case 'invisibleSiblings':
        $items = $page->siblings()->not($page)->invisible();
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
      case 'grandchildren':
      case 'files':
      case 'images':
      case 'documents':
      case 'videos':
      case 'audio':
      case 'code':
      case 'archives':
        $items = $page->{$method}();
        break;
      default: 
        $items = new Collection();
    }

    return $items;

  }

  public function toArray() {
    return $this->options;
  }

}
