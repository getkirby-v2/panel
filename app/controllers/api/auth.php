<?php

class AuthController extends Controller {

  public function login() {

    $user    = app::$site->users()->find(str::lower(get('username')));
    $message = l('login.error');

    if(!$user) {
      return response::error($message);
    }

    try {
      if(!$user->login(get('password'))) {
        throw new Exception($message);
      }
      return response::success(l('login.success'));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

}