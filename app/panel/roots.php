<?php

namespace Panel;

use Obj;

class Roots extends Obj {

  public function __construct($index) {

    $this->index       = $index;
    $this->app         = $index . DS . 'app';
    $this->assets      = $index . DS . 'assets';

    $this->controllers = $this->app . DS . 'controllers';
    $this->fields      = $this->app . DS . 'fields';
    $this->forms       = $this->app . DS . 'forms';
    $this->languages   = $this->app . DS . 'languages';
    $this->layouts     = $this->app . DS . 'layouts';
    $this->lib         = $this->app . DS . 'lib';
    $this->routes      = $this->app . DS . 'routes';
    $this->snippets    = $this->app . DS . 'snippets';
    $this->views       = $this->app . DS . 'views';

  }

}