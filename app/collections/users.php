<?php

class UsersCollection extends Users {

  public function __construct() {

    parent::__construct();

    $this->map(function($user) {
      return new UserModel($user->username());
    });

  }
  
  public function topbar($topbar) {
    $topbar->append(purl('users'), l('users')); 
  }

  public function create($data) {

    if($data['password'] !== $data['passwordconfirmation']) {
      throw new Exception(l('users.form.error.password.confirm'));
    }

    unset($data['passwordconfirmation']);

    $user = parent::create($data);
    kirby()->trigger('panel.user.create', $user);
    return new UserModel($user->username());

  }


}