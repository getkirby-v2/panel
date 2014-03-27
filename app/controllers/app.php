<?php

class AppController extends Controller {

  public function index() {
    return layout('app', array(
      'defaultLanguage' => app::$site->multilang() ? app::$site->defaultLanguage->code : ''
    ));
  }

  public function error() {
    return layout('error', array(
      'defaultLanguage' => app::$site->multilang() ? app::$site->defaultLanguage->code : ''
    ));
  }

}