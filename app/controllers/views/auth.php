<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = panel()->site()->user()) {
      go(panel()->urls()->index());
    }

    $form = panel()->form('login');
    $form->cancel   = false;
    $form->save     = l('login.button');
    $form->centered = true;

    if($username = s::get('username')) {
      $form->fields->username->value = html($username, false);
    }

    return layout('login', array(
      'meta'    => new Snippet('meta'),
      'welcome' => $welcome ? l('login.welcome') : '',
      'form'    => $form
    ));

  }

  public function logout() {

    if($user = panel()->site()->user()) {
      $user->logout();
    }

    go(panel()->urls()->login());

  }

}