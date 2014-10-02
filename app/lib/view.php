<?php

class View {

  public $root = null;
  public $file = null;
  public $data = array();

  public function __construct($file, $data = array()) {
    $this->root = panel::instance()->roots()->views();
    $this->file = $file;
    $this->data = $data;
  }

  public function __set($key, $value) {
    $this->data[$key] = $value;
  }

  public function render() {
    $file = $this->root . DS . str_replace('.', DS, $this->file) . '.php';
    if(!file_exists($file)) throw new Exception('Invalid view: ' . $this->file);
    return f::load($file, $this->data);
  }

  public function __toString() {
    return (string)$this->render();
  }

}