<?php

class AvatarsController extends Controller {

  public function upload($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error(l('users.avatar.error.missing'));
    }

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      return response::error('You are not allowed to upload an avatar for this user');
    }

    $root = $user->avatar() ? $user->avatar()->root() : $user->avatarRoot('{safeExtension}');

    $upload = new Upload($root, array(
      'accept' => function($upload) {
        if($upload->type() != 'image') {
          throw new Error(l('users.avatar.error.type'));
        }
      }
    ));

    if($upload->file()) {

      thumb::$defaults['root']   = dirname($upload->file()->root());
      thumb::$defaults['driver'] = 'im';

      $thumb = new Thumb($upload->file(), array(
        'filename'  => $upload->file()->filename(),
        'overwrite' => true,
        'width'     => 256,
        'height'    => 256,
        'crop'      => true
      ));

      return response::success(l('users.avatar.success'));
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function delete($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error(l('users.avatar.delete.error.missing'));
    }

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      return response::error('You are not allowed to delete the avatar of this user');
    }

    if($avatar = $user->avatar()) {
      if(f::remove($avatar->root())) {
        return response::success(l('users.avatar.delete.success'));
      }
    }

    return response::error(l('users.avatar.delete.error'));

  }

  protected function user($username) {
    return panel()->site()->users()->find($username);
  }

}