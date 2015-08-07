<?php

class ErrorController extends Controller {

  public function index($text = null, $exception = null) {

    $this->auth();

    if(is_null($text)) {
      $text = 'The page could not be found';
    }

    if(server::get('HTTP_MODAL')) {
      return modal('error', array(
        'text' => $text, 
        'back' => url::last(),
      ));
    } else {
      return screen('error/index', 'error', array(
        'text'      => $text, 
        'exception' => $exception
      ));      
    }

  }

  public function auth() {

    $user = kirby()->site()->user();

    if(!$user or !$user->hasPanelAccess()) {
      if($user) $user->logout();
      $this->redirect('login');
    }

  }

}