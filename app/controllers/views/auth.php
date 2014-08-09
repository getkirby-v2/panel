<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = app::$site->user()) {
      go('panel');
    }

    $form = app::form('login');
    $form->cancel   = false;
    $form->save     = l('login.button');
    $form->centered = true;

    return layout('login', array(
      'meta'    => new Snippet('meta'),
      'welcome' => $welcome ? l('login.welcome') : '',
      'form'    => $form
    ));

  }

  public function logout() {

    if($user = app::$site->user()) {
      $user->logout();
    }

    go('panel/login');

  }

}