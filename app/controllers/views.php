<?php

class ViewsController extends Kirby\Panel\Controllers\Base {

  public function index($view) {

    $file = kirby()->roots()->site() . DS . 'views' . DS . $view . DS . $view . '.php';

    if(f::exists($file)) {
      require_once($file);
      $class = $view . 'ViewController';
      $view  = new $class();
      return $view->index();
    }

  }

}
