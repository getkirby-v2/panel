<?php

class DashboardController extends Controller {

  public function index() {

    $site    = site();
    $widgets = array();
    $wroot   = kirby()->roots()->widgets();
    $wdirs   = dir::read($wroot);
    $user    = site()->user();

    // fetch all top-level pages in the right order
    $blueprint   = blueprint::find($site);
    $pages       = api::subpages($site->children(), $blueprint);
    $siteOptions = new PageOptions($site);

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
      'addbutton'     => $siteOptions->canSubpagesAdd(),
      'editbutton'    => $blueprint->pages()->max() !== 0 and
                         ($siteOptions->canSubpagesEdit() or
                         $siteOptions->canSubpagesSort()),
      'sitesection'   => $siteOptions->canSave(),
      'widgets'       => $widgets,
      'user'          => $user,
    ));
  }

}
