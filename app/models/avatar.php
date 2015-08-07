<?php

class AvatarModel extends Media {

  public $user;

  public function __construct(UserModel $user, $avatar) {

    $this->user = $user;

    if($avatar) {
      parent::__construct($avatar->root(), $avatar->url());
    } else {
      parent::__construct($this->user->avatarRoot('{safeExtension}'));
    }

  }

  public function form($action, $callback) {
    return panel()->form('avatars/' . $action, $this, $callback);
  }

  public function url() {
    return $this->exists() ? parent::url() . '?' . $this->modified() : purl('assets/images/avatar.png');
  }

  public function upload() {

    if(!panel()->user()->isAdmin() and !$this->user->isCurrent()) {
      throw new Exception('You are not allowed to change the avatar');
    }

    $root = $this->exists() ? $this->root() : $this->user->avatarRoot('{safeExtension}');

    $upload = new Upload($root, array(
      'accept' => function($upload) {
        if($upload->type() != 'image') {
          throw new Error(l('users.avatar.error.type'));
        }
      }
    ));

    if(!$upload->file()) {
      throw $upload->error();
    }

    thumb::$defaults['root'] = dirname($upload->file()->root());

    $thumb = new Thumb($upload->file(), array(
      'filename'  => $upload->file()->filename(),
      'overwrite' => true,
      'width'     => 256,
      'height'    => 256,
      'crop'      => true
    ));

    kirby()->trigger('panel.avatar.upload', $this);

  }

  public function delete() {

    if(!panel()->user()->isAdmin() and !$this->user->isCurrent()) {
      throw new Exception('You are not allowed to delete the avatar of this user');
    } else if(!$this->exists()) {
      return true;
    }

    if(!parent::delete()) {
      throw new Exception(l('users.avatar.delete.error'));
    } 

    kirby()->trigger('panel.avatar.delete', $this);

  }

}