<?php 

namespace Kirby\Panel\Models\Page;

class UI {

  public $page;

  public function __construct($page) {
    $this->page = $page;
  }

  public function create() {
    return $this->page->canHaveMoreSubpages();            
  }

  public function update() {
    return $this->page->event('update:ui')->isAllowed();    
  }

  public function move() {
    return $this->page->canChangeURL();    
  }

  public function template() {
    return $this->page->canChangeTemplate();    
  }

  public function upload() {
    return $this->page->canHaveMoreFiles();
  }

  public function delete() {
    return $this->page->isDeletable();    
  }

}