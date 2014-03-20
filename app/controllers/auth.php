<?php 

class AuthController extends Controller {

  public function login() {
    if($user = app::$site->user()) {      
      go('panel');
    }
    return layout('login');
  }

  public function auth() {

    $user    = app::$site->users()->find(get('username'));
    $message = 'Invalid username or password';

    if(!$user) {
      return response::error($message);
    } 

    if(!$user->login(get('password'))) {
      return response::error($message);
    }

    return response::success('The user has been logged in');

  }

  public function logout() {

    if($user = app::$site->user()) {
      $user->logout();
    } 

    go('panel/login');

  }

}