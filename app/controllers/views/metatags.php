<?php

class MetatagsController extends Controller {

  public function index() {

    $site      = site();
    $blueprint = blueprint::find($site);
    $fields    = $blueprint->fields($site)->toArray();
    $content   = $site->content()->toArray();
    $files     = null;

    // create the files
    if($blueprint->files()->max() !== 0 and $blueprint->files()->hide() == false) {

      $files = new Snippet('pages/sidebar/files', array(
        'page'  => $site,
        'files' => api::files($site, $blueprint),
      ));

    }

    return view('metatags/index', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb', array(
          'items' => array(
            array(
              'title' => l('metatags'),
              'url'   => purl('metatags/')
            )
          )
        )),
        'search' => purl('pages/search/')
      )),
      'form'    => new Form($fields, $content),
      's'       => $site,
      'files'   => $files,
      'license' => panel()->license(),
    ));

  }

}