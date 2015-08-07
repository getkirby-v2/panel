<?php

class UsersController extends Controller {

  public function index() {

    $users = panel()->users();
    $admin = panel()->user()->isAdmin();

    return screen('users/index', $users, array(
      'users'  => $users,
      'admin'  => $admin,
    ));

  }

  public function add() {

    if(!panel()->user()->isAdmin()) {
      $this->redirect('users');
    }

    $self = $this;
    $form = $this->form('users/user', null, function($form) use($self) {
      
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $data = $form->serialize();

      try {
        $user = UserModel::create($data);
        $self->notify(l('saved'));
        $self->redirect('users');
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

    });

    return screen('users/edit', 'user', array(
      'user'     => null,
      'form'     => $form,
      'writable' => is_writable(kirby()->roots()->accounts()),
    ));

  }

  public function edit($username) {

    $self = $this;
    $user = $this->user($username);

    if(!panel()->user()->isAdmin() and !$user->isCurrent()) {
      $this->redirect('users');
    }

    $form = $user->form('user', function($form) use($user, $self) {
      
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $data = $form->serialize();

      try {
        $user->update($data);
        $self->notify(l('saved'));
        $self->redirect($user, 'edit');
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }
        
    });

    return screen('users/edit', $user, array(
      'user'     => $user,
      'form'     => $form,
      'writable' => is_writable(kirby()->roots()->accounts()),
    ));

  }

  public function delete($username) {

    $user = $this->user($username);
    $self = $this;

    if(!panel()->user()->isAdmin() and !$user->isCurrent()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to delete this user', 
        'back'     => purl('users')
      ));
    } else {

      $form = $user->form('delete', function($form) use($user, $self) {

        try {
          $user->delete();
          $self->notify(':)');
          $self->redirect('users');
        } catch(Exception $e) {
          $form->alert($e->getMessage());
        }

      });

      return modal('users/delete', compact('form'));

    }

  }

}