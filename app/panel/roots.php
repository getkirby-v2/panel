<?php

namespace Panel;

use Obj;

class Roots extends Obj {

  public $panel;

  public function __construct($panel, $root) {

    $this->panel       = $panel;
    $this->index       = $root;
    $this->app         = $root . DS . 'app';
    $this->assets      = $root . DS . 'assets';

    $this->controllers = $this->app . DS . 'controllers';
    $this->fields      = $this->app . DS . 'fields';
    $this->forms       = $this->app . DS . 'forms';
    $this->languages   = $this->app . DS . 'languages';
    $this->widgets     = $this->app . DS . 'widgets';
    $this->layouts     = $this->app . DS . 'layouts';
    $this->lib         = $this->app . DS . 'lib';
    $this->routes      = $this->app . DS . 'routes';
    $this->snippets    = $this->app . DS . 'snippets';
    $this->views       = $this->app . DS . 'views';

  }

}