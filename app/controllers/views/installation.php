<?php

class InstallationController extends Controller {

  public function index() {

    if(app::$site->users()->count() > 0) {
      go('panel/login');
    }

    if($problems = installation::check()) {
      $content = view('installation/check', array(
        'problems' => $problems
      ));
    } else {

      $form = app::form('installation', array('language' => c::get('panel.language', 'en')));
      $form->cancel   = false;
      $form->save     = l::get('installation.signup.button');
      $form->centered = true;

      foreach(app::languages() as $lang) {
        $form->fields()->get('language')->options[$lang->code()] = $lang->title();
      }

      $form->on('submit', function($form) {

        try {
          app::$site->users()->create($form->serialize());
          go('panel/login/welcome');
        } catch(Exception $e) {
          $form->alert($e->getMessage());
        }

      });

      $content = view('installation/signup', array(
        'form' => $form
      ));

    }

    return layout('installation', array(
      'meta'    => new Snippet('meta'),
      'content' => $content
    ));

  }

}