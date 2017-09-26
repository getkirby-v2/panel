<?php

namespace Kirby\Panel\Models;

use A;
use Exception;
use Str;

use Kirby\Panel\Event;
use Kirby\Panel\Structure;
use Kirby\Panel\Models\User\Avatar;
use Kirby\Panel\Models\User\Blueprint;
use Kirby\Panel\Models\User\History;
use Kirby\Panel\Models\User\UI;

class User extends \User {

  public function ui() {
    return new UI($this);
  }

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

    // create the user update event
    $event = $this->event('update:action');

    // check for update permissions
    $event->check();

    // keep the old state of the user object
    $old = clone $this;

    // users which are not an admin cannot change their role
    if(!panel()->user()->isAdmin()) {
      unset($data['role']);
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
      throw new Exception(l('user.error.lastadmin'));
    }

    parent::update($data);

    // flush the cache in case if the user data is 
    // used somewhere on the site (i.e. for profiles)
    kirby()->cache()->flush();

    kirby()->trigger($event, [$this, $old]);

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

    // create the delete event
    $event = $this->event('delete:action');
    
    // check for permissions
    $event->check();

    if($this->isLastAdmin()) {
      // check the number of left admins to not delete the last one
      throw new Exception(l('users.delete.error.lastadmin'));
    }

    // delete the user
    parent::delete();

    // flush the cache in case if the user data is 
    // used somewhere on the site (i.e. for profiles)
    kirby()->cache()->flush();

    kirby()->trigger($event, $this);

  }

  public function avatar($crop = null) {
    if($crop === null) {
      return new Avatar($this);      
    } else {
      $avatar = $this->avatar();
      if($avatar->exists()) {
        return $avatar->crop($crop);
      } else {
        return $avatar;
      }
    }
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

  }

  public function getBlueprintFields() {
    return $this->blueprint()->fields($this);
  }

  public function blueprint() {
    return new Blueprint($this);
  }

  public function structure() {
    return new Structure($this, 'user_' . $this->username());
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

  public function event($type, $args = []) {  
    return new Event('panel.user.' . $type, array_merge([
      'user' => $this
    ], $args));
  }

}
