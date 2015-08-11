<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = panel()->site()->user()) {
      go(panel()->urls()->index());
    }

    $message        = l('login.error');
    $error          = false;
    $form           = panel()->form('login');
    $form->cancel   = false;
    $form->save     = l('login.button');
    $form->centered = true;
    
    if(r::is('post') and get('_csfr') and csfr(get('_csfr'))) {

      $data = $form->serialize();
      $user = site()->user(str::lower($data['username']));

      if(!$user) {
        $error = true;
      } else if(!$user->hasPanelAccess()) {
        $error = true;
      } else if(!$user->login(get('password'))) {
        $error = true;
      } else {
        go(panel()->urls()->index());
      }

    }

    if($username = s::get('username')) {
      $form->fields->username->value = html($username, false);
    }

    return layout('login', array(
      'meta'    => new Snippet('meta'),
      'welcome' => $welcome ? l('login.welcome') : '',
      'form'    => $form,
      'error'   => $error ? $message : false,
    ));

  }

  public function logout() {

    s::restart();

    if($user = panel()->site()->user()) {
      $user->logout();
    }

    go(panel()->urls()->login());

  }

}