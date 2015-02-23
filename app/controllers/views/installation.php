<?php

class InstallationController extends Controller {

  public function index() {

    if(site()->users()->count() > 0) {
      go(panel()->urls()->login());
    }

    if($problems = installation::check()) {
      $content = view('installation/check', array(
        'problems' => $problems
      ));
    } else {

      $form = panel()->form('installation', array('language' => kirby()->option('panel.language', 'en')));
      $form->cancel   = false;
      $form->save     = l('installation.signup.button');
      $form->centered = true;

      foreach(panel()->languages() as $lang) {
        $form->fields()->get('language')->options[$lang->code()] = $lang->title();
      }

      $form->on('submit', function($form) {

        try {

          // fetch all the form data
          $data = $form->serialize();

          // make sure that the first user is an admin
          $data['role'] = 'admin';

          // try to create the new user
          $user = panel()->site()->users()->create($data);

          // store the new username for the login screen
          s::set('username', $user->username());

          // redirect to the login
          go(panel()->urls()->login() . '/welcome');

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