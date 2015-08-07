<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    try {
      $user = panel()->user();
      $this->redirect();
    } catch(Exception $e) {

    }

    $self = $this;
    $form = $this->form('auth/login', $welcome, function($form) use($self) {

      $data = $form->serialize();
      $user = panel()->user(str::lower($data['username']));

      if(!$user or !$user->hasPanelAccess() or !$user->login($data['password'])) {
        $form->alert(l('login.error'));
        $form->fields->username->error = true;
        $form->fields->password->error = true;
      } else {        
        $self->redirect();
      }

    });

    return layout('base', array(
      'content' => view('auth/login', compact('form'))
    ));

  }

  public function logout() {

    if($user = panel()->user()) {
      $user->logout();
    }

    $this->redirect('login');

  }

}