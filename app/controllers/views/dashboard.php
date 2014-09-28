<?php

class DashboardController extends Controller {

  public function index() {

    $widgets = array();
    $wroot   = kirby()->roots()->widgets();
    $wdirs   = dir::read($wroot);

    foreach($wdirs as $dir) {
      $file = $wroot . DS . $dir . DS . $dir . '.php';
      if(file_exists($file)) {
        $widgets[$dir] = require($file);
      }
    }

    return view('dashboard/index', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb'),
        'search'     => purl('pages/search/')
      )),
      'history' => history::get(),
      'site'    => site(),
      'widgets' => $widgets,
      'user'    => site()->user(),
    ));
  }

}