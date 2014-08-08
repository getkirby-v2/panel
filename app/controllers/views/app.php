<?php

class AppController extends Controller {

  public function index() {

    return layout('app', array(
      'topbar' => new Snippet('topbar'),
      'meta'   => new Snippet('meta')
    ));
  }

}