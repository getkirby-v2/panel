<?php

class DashboardController extends Controller {

  public function index() {

    $site    = site();
    $widgets = array();
    $wroot   = kirby()->roots()->widgets();
    $wdirs   = dir::read($wroot);
    $user    = site()->user();

    // fetch all top-level pages in the right order
    $blueprint = blueprint::find($site);
    $pages     = api::subpages($site->children(), $blueprint);

    foreach($wdirs as $dir) {
      $file = $wroot . DS . $dir . DS . $dir . '.php';
      if(file_exists($file)) {
        $widgets[$dir] = require($file);
      }
    }

    return view('dashboard/index', array(
      'topbar'        => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb'),
        'search'     => purl('pages/search/')
      )),
      'history'       => history::get(),
      'site'          => $site,
      'pages'         => $pages,
      'addbutton'     => !api::maxPages($site, $blueprint->pages()->max()) and
                         $user->hasPermission('page.create'),
      'editbutton'    => $user->hasPermission('page.update') or
                         $user->hasPermission('page.changeurl') or
                         $user->hasPermission('page.sort') or
                         $user->hasPermission('page.hide') or
                         $user->hasPermission('page.delete'),
      'sitesection'   => $user->hasPermission('site.update'),
      'widgets'       => $widgets,
      'user'          => $user,
    ));
  }

}
