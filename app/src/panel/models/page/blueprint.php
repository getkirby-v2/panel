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

  static public $root = null;

  public $name      = null;
  public $file      = null;
  public $yaml      = array();
  public $title     = null;
  public $preview   = 'page';
  public $pages     = null;
  public $files     = null;
  public $deletable = true;
  public $icon      = 'file-o';
  public $fields    = array();

  public function __construct($name) {

    // check if the fallback is needed
    if(!static::exists($name)) {
      $name = 'default';
    }    

    $this->name = $name;
    $this->file = static::$root . DS . $name . '.php';
    $this->yaml = data::read($this->file, 'yaml');

    // remove the broken first line
    unset($this->yaml[0]);

    $this->title     = a::get($this->yaml, 'title', 'Page');
    $this->preview   = a::get($this->yaml, 'preview', 'page');
    $this->deletable = a::get($this->yaml, 'deletable', true);
    $this->icon      = a::get($this->yaml, 'icon', 'file-o');
    $this->pages     = new Pages(a::get($this->yaml, 'pages', true));
    $this->files     = new Files(a::get($this->yaml, 'files', true));

  }

  public function fields($page = null) {
    $fields = a::get($this->yaml, 'fields', array());
    return new Fields($fields, $page);
  }

  static public function exists($name) {
    return file_exists(static::$root . DS . strtolower($name) . '.php');
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
