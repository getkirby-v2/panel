<?php

class AuthController extends Controller {

  public function login() {

    if($user = app::$site->user()) {
      go('panel');
    }

    return layout('login', array(
      'meta' => new Snippet('meta')
    ));

  }

  public function logout() {

    if($user = app::$site->user()) {
      $user->logout();
    }

    go('panel/login');

  }

}