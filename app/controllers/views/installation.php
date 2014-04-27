<?php

class InstallationController extends Controller {

  public function index() {
    $this->lock();
    return layout('installation', array(
      'meta' => new Snippet('meta')
    ));
  }

  public function check() {
    $this->lock();
    return view('installation/check');
  }

  public function signup() {
    $this->lock();
    return view('installation/signup', array(
      'languages' => app::languages()
    ));
  }

  protected function lock() {
    if(app::$site->users()->count() > 0) {
      go('panel/login');
    }
  }

}