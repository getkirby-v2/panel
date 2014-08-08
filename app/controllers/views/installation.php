<?php

class InstallationController extends Controller {

  public function index() {

    if(app::$site->users()->count() > 0) {
      go('panel/login');
    }

    // check for installation issues
    $problems = installation::check();

    if(!empty($problems)) {
      $content = view('installation/check', array(
        'problems' => $problems
      ));
    } else {

      $alert = null;

      if(r::is('post')) {

        try {
          app::$site->users()->create(get());
          go('panel/login');
        } catch(Exception $e) {
          $alert = $e->getMessage();
        }

      }

      $content = view('installation/signup', array(
        'languages' => app::languages(),
        'alert'     => $alert
      ));

    }

    return layout('installation', array(
      'meta'    => new Snippet('meta'),
      'content' => $content
    ));

  }

}