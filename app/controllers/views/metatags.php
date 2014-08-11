<?php

class MetatagsController extends Controller {

  public function index() {

    $site      = site();
    $blueprint = blueprint::find($site);
    $fields    = $blueprint->fields()->toArray();
    $content   = $site->content()->toArray();

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
      'form' => new Form($fields, $content),
      's'    => $site,
    ));

  }

}