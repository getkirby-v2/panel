<?php

class ErrorController extends Kirby\Panel\Controller {

  public function index($text = null, $exception = null) {

    $this->auth();

    if(is_null($text)) {
      $text = 'The page could not be found';
    }

    if(server::get('HTTP_MODAL')) {
      return $this->modal('error', array(
        'text' => $text, 
        'back' => url::last(),
      ));
    } else {
      return $this->screen('error/index', 'error', array(
        'text'      => $text, 
        'exception' => $exception
      ));      
    }

  }

  public function auth() {
    try {
      $user = panel()->user();      
    } catch(Exception $e) {
      $this->redirect('login');
    }
  }

}