<?php

class DashboardController extends Controller {

  public function index() {

    return view('dashboard/index', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb'),
        'search'     => purl('pages/search/')
      )),
      'widgets' => new Widgets()
    ));

  }

}