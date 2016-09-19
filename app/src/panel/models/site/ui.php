<?php 

namespace Kirby\Panel\Models\Site;

class UI {

  public $site;

  public function __construct($site) {
    $this->site = $site;
  }

  public function create() {
    return $this->site->canHaveMoreSubpages();            
  }

  public function update() {
    return $this->site->event('update:ui')->isAllowed();    
  }

  public function upload() {
    return $this->site->canHaveMoreFiles();
  }

}