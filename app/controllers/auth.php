<?php 

class AuthController extends Controller {

  public function login() {

    $user    = user::find(get('username'));
    $message = 'Invalid username or password';

    if(!$user) {
      return response::error($message);
    } 

    if($user->password !== get('password')) {
      return response::error($message);
    }

    return response::success('The user has been logged in');

  }

  public function logout() {
    return 'logout';    
  }

}