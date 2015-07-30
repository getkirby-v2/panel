<?php

class AvatarModel {

  public $user;
  public $source;

  public function __construct(UserModel $user) {
    $this->user   = $user;
    $this->source = $user->source()->avatar();
  }

  public function form($action, $callback) {
    return panel()->form('avatars/' . $action, $this, $callback);
  }

  public function url() {
    return $this->exists() ? $this->source->url() . '?' . $this->source->modified() : purl('assets/images/avatar.png');
  }

  public function exists() {
    return $this->source;
  }

  public function upload() {

    if(!panel()->user()->isAdmin() and !$this->user->isCurrent()) {
      throw new Exception('You are not allowed to change the avatar');
    }

    $root = $this->source ? $user->source->root() : $this->user->avatarRoot('{safeExtension}');

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

    kirby()->trigger('panel.avatar.upload', $this->user->avatar());

  }

  public function delete() {

    if(!panel()->user()->isAdmin() and !$this->user->isCurrent()) {
      throw new Exception('You are not allowed to delete the avatar of this user');
    } else if(!$this->exists()) {
      throw new Exception('This user has no avatar');
    }

    if(!$this->source->delete()) {
      throw new Exception(l('users.avatar.delete.error'));
    } 

    kirby()->trigger('panel.avatar.delete', $this->source);

  }

  public function __call($method, $args = null) {
    if($this->source) {
      return call(array($this->source, $method), $args);      
    }
  }

}