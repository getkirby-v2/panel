<?php

class OptionsController extends Controller {

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

    return layout('app', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb', array(
          'items' => array(
            array(
              'title' => l('metatags'),
              'url'   => purl('options')
            )
          )
        )),
        'search' => purl('pages/search/')
      )),
      'content' => view('options/index', array(
        'form'    => new Form($fields, $content),
        's'       => $site,
        'files'   => $files,
        'license' => panel()->license(),
      ))
    ));

  }

}