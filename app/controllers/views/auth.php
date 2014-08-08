<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = app::$site->user()) {
      go('panel');
    }

    return layout('login', array(
      'meta'    => new Snippet('meta'),
      'welcome' => $welcome ? l('login.welcome') : ''
    ));

  }

  public function logout() {

    if($user = app::$site->user()) {
      $user->logout();
    }

    go('panel/login');

  }

}