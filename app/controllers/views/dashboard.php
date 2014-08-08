<?php

class DashboardController extends Controller {

  public function index() {

    $widgets = array();
    $wroot   = c::get('root.site') . DS . 'widgets';
    $wdirs   = dir::read($wroot);

    foreach($wdirs as $dir) {
      $file = $wroot . DS . $dir . DS . $dir . '.php';
      if(file_exists($file)) {
        $widgets[$dir] = require($file);
      }
    }

    return view('dashboard/index', array(
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('dashboard/breadcrumb', array('metatags' => false)),
        'search'     => purl('pages/search/')
      )),
      'history' => history::get(),
      'site'    => site(),
      'widgets' => $widgets,
      'user'    => site()->user(),
    ));
  }

  public function metatags() {

    $site      = site();
    $blueprint = blueprint::find($site);
    $fields    = $blueprint->fields()->toArray();
    $content   = $site->content()->toArray();

    return view('dashboard/metatags', array(
      'topbar' => new Snippet('pages/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('dashboard/breadcrumb', array('metatags' => true)),
        'search'     => purl('pages/search/')
      )),
      'form' => new Form($fields, $content),
      's'    => $site,
    ));

  }

}