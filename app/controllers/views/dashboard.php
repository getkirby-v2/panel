<?php

class DashboardController extends Controller {

  public function index() {

    return layout('app', array(
      'topbar' => new Snippet('pages/topbar', array(
        'breadcrumb' => new Snippet('breadcrumb'),
        'search'     => purl(panel()->site(), 'search')
      )),
      'content' => view('dashboard/index', array(
        'widgets' => new Widgets()
      ))
    ));

  }

}