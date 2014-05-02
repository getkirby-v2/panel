<?php

class UsersController extends Controller {

  public function index() {

    $users = $this->users()->map(function($user) {
      return api::user($user);
    });

    return response::json($users->toArray());

  }

  public function create() {

    try {
      $user = $this->users()->create(get());
      return response::json(api::user($user));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function show($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error(l('users.show.error.missing'));
    } else {
      return response::json(api::user($user));
    }

  }

  public function update($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error(l('users.edit.error.missing'));
    } else {

      $data = array(
        'email' => get('email'),
        'language' => get('language', c::get('panel.language', 'en')),
      );

      if(str::length(get('password')) > 0) {
        $data['password'] = get('password');
      }

      if($user->update($data)) {
        return response::success(l('users.edit.success'));
      } else {
        return response::error(l('users.edit.error'));
      }

    }

  }

  public function delete($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error(l('users.delete.error.missing'));
    }

    try {
      $user->delete();
      return response::success(l('users.delete.success'));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function avatar() {

    $user = $this->user(get('username'));

    if(!$user) {
      return response::error(l('users.avatar.error.missing'));
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

  public function deleteAvatar() {

    $user = $this->user(get('username'));

    if(!$user) {
      return response::error(l('users.avatar.delete.error.missing'));
    }

    if($avatar = $user->avatar()) {
      if(f::remove($avatar->root())) {
        return response::success(l('users.avatar.delete.success'));
      }
    }

    return response::error(l('users.avatar.delete.error'));

  }

  protected function users() {
    return app::$site->users();
  }

  protected function user($username) {
    return app::$site->users()->find($username);
  }

}