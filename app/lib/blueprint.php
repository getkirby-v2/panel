<?php

class Blueprint extends Obj {

  static public $root = null;

  public $name      = null;
  public $file      = null;
  public $yaml      = array();
  public $title     = null;
  public $preview   = 'page';
  public $pages     = null;
  public $files     = null;
  public $deletable = true;
  public $fields    = array();

  public function __construct($name) {

    $this->name = $name;
    $this->file = static::$root . DS . $name . '.php';
    $this->yaml = data::read($this->file, 'yaml');

    // remove the broken first line
    unset($this->yaml[0]);

    $this->title     = a::get($this->yaml, 'title', 'Page');
    $this->preview   = a::get($this->yaml, 'preview', 'page');
    $this->deletable = a::get($this->yaml, 'deletable', true);
    $this->pages     = new Blueprint\Pages(a::get($this->yaml, 'pages', true));
    $this->files     = new Blueprint\Files(a::get($this->yaml, 'files', true));
    $this->fields    = new Blueprint\Fields();

    foreach(a::get($this->yaml, 'fields', array()) as $name => $field) {

      // add the name to the field
      $field['name'] = $name;

      // creat the field object
      $field = new Blueprint\Field($field);

      // append it to the collection
      $this->fields->append($name, $field);

    }

  }

  static public function find($id) {

    if(is_a($id, 'Page')) {

      $name = $id->intendedTemplate();
      $file = static::$root . DS . $name . '.php';

      if(!file_exists($file)) {
        $name = $id->template();
        $file = static::$root . DS . $name . '.php';

        if(!file_exists($file)) {
          $name = 'default';
        }

      }

    } else if(file_exists($id)) {
      $name = f::name($id);
    } else {
      $name = $id;
      $file = static::$root . DS . $name . '.php';

      if(!file_exists($file)) {
        $name = 'default';
      }

    }

    return new static($name);

  }

  static public function all() {

    $files  = dir::read(static::$root);
    $result = array();

    foreach($files as $file) {
      $result[] = f::name($file);
    }

    return $result;

  }

  public function __toString() {
    return $this->name;
  }

}