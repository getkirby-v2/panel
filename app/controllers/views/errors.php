<?php

class ErrorsController extends Controller {

  /**
   * Dynamic view errors
   */
  public function index($message = null) {

    if(is_null($message)) $message = 'The page could not be found';

    return view('errors/index', array(
      'topbar'  => new Snippet('topbar'),
      'message' => $message
    ));
  }

  /**
   * Modal errors
   */
  public function modal($message = null) {

    if(is_null($message)) $message = 'The item could not be found';

    return view('errors/modal', array(
      'message' => $message
    ));

  }

  /**
   * Page errors for entirely wrong-directed URLs
   */
  public function page() {

    // if the user is logged in show everything
    if(site()->user()) {

      $content = view('errors/index', array(
        'topbar'  => new Snippet('topbar'),
        'message' => 'The page could not be found'
      ));

    // if the user is logged out don't show the topbar
    } else {

      $content = view('errors/modal', array(
        'message' => 'The page could not be found'
      ));

    }

    return layout('error', array(
      'meta'    => new Snippet('meta'),
      'content' => $content
    ));

  }

}