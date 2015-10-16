<?php

namespace Kirby\Panel\Models\Page;

use A;
use Data;
use Dir;
use F;
use Obj;

use Kirby\Panel\Models\Page\Blueprint\Pages;
use Kirby\Panel\Models\Page\Blueprint\Files;
use Kirby\Panel\Models\Page\Blueprint\Fields;

class Blueprint extends Obj {

  static public $cache = array();
  static public $root  = null;

  public $name      = null;
  public $file      = null;
  public $yaml      = array();
  public $title     = null;
  public $preview   = 'page';
  public $pages     = null;
  public $files     = null;
  public $hide      = false;
  public $deletable = true;
  public $icon      = 'file-o';
  public $fields    = array();

  public function __construct($name) {

    // load from yaml file
    $this->load($name);

    $this->title     = a::get($this->yaml, 'title', 'Page');
    $this->preview   = a::get($this->yaml, 'preview', 'page');
    $this->deletable = a::get($this->yaml, 'deletable', true);
    $this->icon      = a::get($this->yaml, 'icon', 'file-o');
    $this->hide      = a::get($this->yaml, 'hide', false);
    $this->type      = a::get($this->yaml, 'type', 'page');
    $this->pages     = new Pages(a::get($this->yaml, 'pages', true));
    $this->files     = new Files(a::get($this->yaml, 'files', true));

  }

  public function load($name) {

    if(isset(static::$cache[$name])) {
      $this->file = static::$cache[$name]['file'];
      $this->name = static::$cache[$name]['name'];
      $this->yaml = static::$cache[$name]['yaml'];
      return true;
    }

    if(file_exists(static::$root . DS . $name . '.yaml')) {
      $this->file = static::$root . DS . $name . '.yaml';
      $this->name = $name;
    } else if(file_exists(static::$root . DS . $name . '.php')) {
      $this->file = static::$root . DS . $name . '.php';
      $this->name = $name;
    } else if(file_exists(static::$root . DS . 'default.yaml')) {
      $this->file = static::$root . DS . 'default.yaml';
      $this->name = 'default';
    } else if(file_exists(static::$root . DS . 'default.php')) {
      $this->file = static::$root . DS . 'default.php';
      $this->name = 'default';
    } else {
      throw new Exception('Missing blueprint: ' . $name);
    }

    $this->yaml = data::read($this->file, 'yaml');

    // remove the broken first line
    unset($this->yaml[0]);

    static::$cache[$name] = array(
      'file' => $this->file,
      'name' => $this->name,
      'yaml' => $this->yaml
    );

    return true;

  }

  public function fields($page = null) {
    $fields = a::get($this->yaml, 'fields', array());
    return new Fields($fields, $page);
  }

  static public function exists($name) {
    return (
      file_exists(static::$root . DS . strtolower($name) . '.php') or
      file_exists(static::$root . DS . strtolower($name) . '.yaml')
    );
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
