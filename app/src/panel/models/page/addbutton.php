<?php

namespace Kirby\Panel\Models\Page;

use Exception;
use Obj;

class AddButton extends Obj {

  public function __construct($page) {
    $this->page = $page;
    if($this->page->canHaveMoreSubpages()) {
      if($this->page->blueprint()->pages()->template()->count() > 1) {
        $this->url   = $this->page->url('add');
        $this->modal = true;
      } else {
        $this->url   = $this->page->url('add/' . $this->page->blueprint()->pages()->template()->first()->name());
        $this->modal = false;
      }
    } else {
      throw new Exception('This page cannot have any more subpages');
    }
  }  

}