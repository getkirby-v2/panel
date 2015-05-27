<?php

class UsersController extends Controller {

  public function index() {

    $users = $this->users()->map(function($user) {
      return api::user($user);
    });

    return response::json(array_values($users->toArray()));

  }

  public function create() {
    $usersOptions = new UsersOptions();

    if(!$usersOptions->canAdd())
      return response::error('You are not allowed to create new users');

    $form = $this->form();
    $data = $form->toArray();

    if($data['password'] !== $data['passwordconfirmation']) {
      return response::error(l('users.form.error.password.confirm'));
    }

    unset($data['passwordconfirmation']);

    try {
      $user = $this->users()->create($data);
      return response::success('success');
    } catch(Exception $e) {
      return response::error(l('users.form.error.create'));
    }

  }

  public function update($username) {

    $user         = $this->user($username);
    $usersOptions = new UsersOptions();

    if(!$user) {
      return response::error(l('users.edit.error.missing'));
    } else {

      if(!$usersOptions->canEdit() and !$user->isCurrent())
        return response::error('You are not allowed to edit this user');

      $form = $this->form($user);
      $data = $form->toArray();

      if(str::length($data['password']) > 0) {
        if($data['password'] !== $data['passwordconfirmation']) {
          return response::error(l('users.form.error.password.confirm'));
        }
      } else {
        unset($data['password']);
      }

      unset($data['passwordconfirmation']);

      if($user->update($data)) {
        return response::success('success');
      } else {
        return response::error(l('users.form.error.update'));
      }

    }

  }

  public function delete($username) {

    $user         = $this->user($username);
    $usersOptions = new UsersOptions();

    if(!$user) {
      return response::error(l('users.error.missing'));
    }

    if(!$usersOptions->canDelete() or
      ($user->isAdmin() and $usersOptions->lastAdmin()) {
      return response::error('You are not allowed to delete this user');
    }

    try {
      $user->delete();
      return response::success('success');
    } catch(Exception $e) {
      return response::error(l('users.delete.error'));
    }

  }

  protected function users() {
    return panel()->site()->users();
  }

  protected function user($username) {
    return panel()->site()->users()->find($username);
  }

  protected function form($user = null) {
    $mode = $user ? 'edit' : 'add';
    return panel()->form('user.' . $mode);
  }

}
