<?php

class AuthController extends Controller {

  public function login() {

    $user    = app::$site->users()->find(get('username'));
    $message = l('login.error');

    if(!$user) {
      return response::error($message);
    }

    if(!$user->login(get('password'))) {
      return response::error($message);
    }

    return response::success(l('login.success'));

  }

}