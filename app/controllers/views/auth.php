<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = panel()->site()->user()) {
      $this->redirect();
    }

    $self = $this;
    $form = $this->form('auth/login', $welcome, function($form) use($self) {

      $data = $form->serialize();
      $user = site()->user(str::lower($data['username']));

      if(!$user or !$user->hasPanelAccess() or !$user->login($data['password'])) {
        $form->alert(l('login.error'));
        $form->fields->username->error = true;
        $form->fields->password->error = true;
      } else {        
        $self->redirect('/');
      }

    });

    return layout('base', array(
      'content' => view('auth/login', compact('form'))
    ));

  }

  public function logout() {

    if($user = panel()->site()->user()) {
      $user->logout();
    }

    $this->redirect('login');

  }

}