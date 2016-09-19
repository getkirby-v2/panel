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

  public function upload() {
    return $this->page->event('upload:ui')->isAllowed();
  }

  public function delete() {
    return $this->page->isDeletable();    
  }

}