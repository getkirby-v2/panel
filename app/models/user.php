<?php

class UserModel {

  public $source;

  public function __construct($username) {

    if(is_a($username, 'User')) {
      $this->source = $username;
    } else {
      $this->source = panel()->site()->user($username);
    }

    if(!$this->source) {
      throw new Exception('The user could not be found');
    }

  }

  public function source() {
    return $this->source;
  }

  public function url($action = 'edit') {
    if(empty($action)) $action = 'edit';
    return panel()->urls()->index() . '/users/' . $this->source->username() . '/' . $action;
  }

  public function form($action, $callback) {    
    return panel()->form('users/' . $action, $this, $callback);
  }

  public function update($data) {

    if(str::length($data['password']) > 0) {
      if($data['password'] !== $data['passwordconfirmation']) {
        throw new Exception(l('users.form.error.password.confirm'));
      }
    } else {
      unset($data['password']);
    }

    unset($data['passwordconfirmation']);

    $this->source->update($data);
    kirby()->trigger('panel.user.update', $this->source);

  }

  public function delete() {

    if(!panel()->user()->isAdmin() and !$this->isCurrent()) {
      throw new Exception('You are not allowed to delete users');
    }

    if($this->isAdmin()) {
      // check the number of left admins to not delete the last one
      if(panel()->users()->filterBy('role', 'admin')->count() == 1) {
        throw new Exception('You cannot delete the last admin');
      }
    }

    $this->source->delete();

    kirby()->trigger('panel.user.delete', $this->source);

  }

  public function avatar() {
    return new AvatarModel($this);
  }

  public function __call($method, $args = null) {
    return call(array($this->source, $method), $args);
  }

  public function isCurrent() {
    return $this->source()->is(panel()->user()->source());
  }

  static public function create($data) {

    if($data['password'] !== $data['passwordconfirmation']) {
      throw new Exception(l('users.form.error.password.confirm'));
    }

    unset($data['passwordconfirmation']);

    $user = panel()->site()->users()->create($data);
    kirby()->trigger('panel.user.create', $user);
    return new static($user);

  }

}