<?php

class Blueprint extends Obj {

  static public $root = null;

  public $name        = null;
  public $file        = null;
  public $yaml        = array();
  public $title       = null;
  public $preview     = 'page';
  public $permissions = null;
  public $pages       = null;
  public $files       = null;
  public $fields      = array();

  public function __construct($name) {

    $this->name = $name;
    $this->file = static::$root . DS . $name . '.php';
    $this->yaml = data::read($this->file, 'yaml');

    // remove the broken first line
    unset($this->yaml[0]);

    $this->title        = a::get($this->yaml, 'title', 'Page');
    $this->preview      = a::get($this->yaml, 'preview', 'page');
    $this->permissions  = new Blueprint\Permissions(a::get($this->yaml, 'permissions', true), 'page');
    // legacy fallback for 'deletable'
    if ($this->permissions->delete == null)
      $this->permissions->set('delete', a::get($this->yaml, 'deletable', null));
    $this->pages        = new Blueprint\Pages(a::get($this->yaml, 'pages', true));
    $this->files        = new Blueprint\Files(a::get($this->yaml, 'files', true));

  }

  public function can($permission, $role) {
    return ($this->permissions == null) ? true : $this->permissions->allowed($permission, $role);
  }

  public function fields($page = null) {

    $fields = a::get($this->yaml, 'fields', array());

    return new Blueprint\Fields($fields, $page);

  }

  static public function find($id) {

    if(is_a($id, 'Page')) {

      $name = $id->intendedTemplate();
      $file = static::$root . DS . strtolower($name) . '.php';

      if(!file_exists($file)) {
        $name = $id->template();
        $file = static::$root . DS . strtolower($name) . '.php';

        if(!file_exists($file)) {
          $name = 'default';
        }

      }

    } else if(file_exists($id)) {
      $name = f::name($id);
    } else {
      $name = $id;
      $file = static::$root . DS . strtolower($name) . '.php';

      if(!file_exists($file)) {
        $name = 'default';
      }

    }

    return new static($name);

  }

  static public function all() {

    $files  = dir::read(static::$root);
    $result = array();
    $home   = kirby()->option('home', 'home');
    $error  = kirby()->option('error', 'error');

    foreach($files as $file) {

      $name = f::name($file);

      if($name != 'site' and $name != $home and $name != $error) {
        $result[] = $name;
      }

    }

    return $result;

  }

  public function __toString() {
    return $this->name;
  }

}
