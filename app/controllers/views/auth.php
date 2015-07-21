<?php

class AuthController extends Controller {

  public function login($welcome = null) {

    if($user = panel()->site()->user()) {
      $this->redirect();
    }

    $self = $this;
    $form = panel()->form('auth/login');
    
    $form->data('autosubmit', 'native');
    $form->style('centered');
    
    $form->buttons->submit->value = l('login.button');
  
    $form->on('submit', function($form) use($self) {

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

    if($username = s::get('username')) {
      $form->fields->username->value = html($username, false);
    }

    if($welcome) {
      $form->notify(l('login.welcome'));
    }

    return layout('base', array(
      'content' => view('auth/login', array(
        'form' => $form
      ))
    ));

  }

  public function logout() {

    if($user = panel()->site()->user()) {
      $user->logout();
    }

    $this->redirect('login');

  }

}