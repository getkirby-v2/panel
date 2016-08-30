<?php

namespace Kirby\Panel\Collections;

use Exception;
use Kirby\Panel\Event;
use Kirby\Panel\Models\User;

class Users extends \Users {

  public function __construct() {

    parent::__construct();

    $this->map(function($user) {
      return new User($user->username());
    });

  }
  
  public function topbar($topbar) {
    $topbar->append(purl('users'), l('users')); 
  }

  public function create($data) {

    $event = new Event('panel.user.create');
    $event->checkPermissions([], true);

    if($data['password'] !== $data['passwordconfirmation']) {
      throw new Exception(l('users.form.error.password.confirm'));
    }

    unset($data['passwordconfirmation']);

    $user = parent::create($data);
    kirby()->trigger($event, $user);
    return new User($user->username());

  }


}