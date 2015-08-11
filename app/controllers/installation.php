<?php

class InstallationController extends Kirby\Panel\Controller {

  public function index() {

    if(site()->users()->count() > 0) {
      $this->redirect('login');
    } else if($problems = installation::check()) {
      return $this->problems($problems);
    } else {
      return $this->signup();
    }

  }

  protected function problems($problems) {
    $form = $this->form('installation/check', $problems);        
    return $this->modal('installation/index', compact('form'));
  }

  protected function signup() {

    $self = $this;
    $form = $this->form('installation/signup', null, function($form) use($self) {

      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      try {

        // fetch all the form data
        $data = $form->serialize();

        // make sure that the first user is an admin
        $data['role'] = 'admin';

        // try to create the new user
        $user = panel()->site()->users()->create($data);

        // store the new username for the login screen
        s::set('username', $user->username());

        // try to login the user automatically
        if($user->hasPanelAccess()) {
          $user->login($data['password']);
        }

        // redirect to the login
        $self->redirect('login/welcome');

      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('installation/index', compact('form'));

  }

}