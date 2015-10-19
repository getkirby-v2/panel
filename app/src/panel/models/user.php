<?php

namespace Kirby\Panel\Models;

use A;
use Exception;
use Str;

use Kirby\Panel\Models\User\Avatar;
use Kirby\Panel\Models\User\Blueprint;
use Kirby\Panel\Models\User\History;

class User extends \User {

  public function uri($action = 'edit') {
    return 'users/' . $this->username() . '/' . $action;
  }

  public function url($action = 'edit') {
    if(empty($action)) $action = 'edit';
    return panel()->urls()->index() . '/' . $this->uri($action);
  }

  public function form($action, $callback) {    
    return panel()->form('users/' . $action, $this, $callback);
  }

  public function update($data = array()) {

    if(!panel()->user()->isAdmin() and !$this->isCurrent()) {
      throw new Exception('You are not allowed to update this user');
    }

    if(str::length(a::get($data, 'password')) > 0) {
      if(a::get($data, 'password') !== a::get($data, 'passwordconfirmation')) {
        throw new Exception(l('users.form.error.password.confirm'));
      }
    } else {
      unset($data['password']);
    }

    unset($data['passwordconfirmation']);

    if($this->isLastAdmin() and a::get($data, 'role') !== 'admin') {
      // check the number of left admins to not convert the last one
      throw new Exception('You are the only admin. This cannot be changed.');
    }

    parent::update($data);
    kirby()->trigger('panel.user.update', $this);

    return $this;

  }

  public function isLastAdmin() {
    if($this->isAdmin()) {
      if(panel()->users()->filterBy('role', 'admin')->count() == 1) {
        return true;
      }
    } else {
      return false;       
    }
  }

  public function delete() {

    if(!panel()->user()->isAdmin() and !$this->isCurrent()) {
      throw new Exception('You are not allowed to delete users');
    }

    if($this->isLastAdmin()) {
      // check the number of left admins to not delete the last one
      throw new Exception('You cannot delete the last admin');
    }

    parent::delete();

    kirby()->trigger('panel.user.delete', $this);

  }

  public function avatar() {
    return new Avatar($this, parent::avatar());
  }

  public function isCurrent() {
    return $this->is(panel()->user());
  }

  public function history() {
    return new History($this);
  }

  public function topbar($topbar) {

    $topbar->append(purl('users'), l('users'));
    $topbar->append($this->url(), $this->username());    

    // if($user === 'user') {
    //   $topbar->append(purl('users/add'), l('users.index.add'));    
    // }

  }

  public function blueprint() {
    return new Blueprint($this);
  }

  static public function current() {
    if($user = parent::current()) {
      if($user->hasPanelAccess()) {
        return $user;
      } else {
        $user->logout();
        return null;
      }
    } else {
      return null;
    }
  }

}