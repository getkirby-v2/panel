<?php

class AppController extends Controller {

  public function index() {

    // check for a publish hook setup
    $publish = a::get(c::get('panel.hooks'), 'publish');

    return layout('app', array(
      'defaultLanguage' => app::$site->multilang() ? '"' . app::$site->defaultLanguage->code . '"' : 'false',
      'publishHook'     => $publish ? '"' . url($publish) . '"' : 'false',
      'meta'            => new Snippet('meta')
    ));
  }

  public function error() {
    return layout('error', array(
      'defaultLanguage' => app::$site->multilang() ? app::$site->defaultLanguage->code : '',
      'meta'            => new Snippet('meta')
    ));
  }

}