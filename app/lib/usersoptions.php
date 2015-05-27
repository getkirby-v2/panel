<?php

class UsersOptions {

  public $user;

  public function __construct() {
    $this->user = site()->user();
  }

  /**
   *  Helpers for permissions checking
   */

  public function canAdd() {
    return $this->user->hasPermission('user.add');
  }

  public function canEdit() {
    return $this->canEditInfo() or $this->canEditRole();
  }

  public function canEditInfo() {
    return $this->user->hasPermission('user.edit');
  }

  public function canEditRole() {
    return $this->user->hasPermission('user.role');
  }

  public function canDelete() {
    return $this->user->hasPermission('user.delete');
  }

  public function lastAdmin() {
    return site()->roles()->get('admin')->users()->count() <= 1;
  }

}
