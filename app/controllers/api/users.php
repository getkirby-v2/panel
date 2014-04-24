<?php

class UsersController extends Controller {

  public function index() {

    $ctrl  = $this;
    $users = $this->users()->map(function($user) use($ctrl) {
      return $ctrl->userToArray($user);
    });

    return response::json($users->toArray());

  }

  public function create() {

    try {
      $user = $this->users()->create(get());
      return response::json($this->userToArray($user));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function show($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error('The user could not be found');
    } else {
      return response::json($this->userToArray($user));
    }

  }

  public function update($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error('The user could not be found');
    } else {

      $data = array(
        'email' => get('email'),
      );

      if(str::length(get('password')) > 0) {
        $data['password'] = get('password');
      }

      if($user->update($data)) {
        return response::success('The user has been updated');
      } else {
        return response::error('The update failed');
      }

    }

  }

  public function delete($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error('The user could not be found');
    }

    try {
      $user->delete();
      return response::success('The user has been deleted');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function avatar() {

    $user = $this->user(get('username'));

    if(!$user) {
      return response::error('The user could not be found');
    }

    $root = $user->avatar() ? $user->avatar()->root() : $user->avatarRoot('{extension}');

    $upload = new Upload($root, array(
      'accept' => function($upload) {
        if($upload->type() != 'image') {
          throw new Error('Only images can be uploaded');
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

      return response::success('The file has been uploaded');
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function deleteAvatar() {

    $user = $this->user(get('username'));

    if(!$user) {
      return response::error('The user could not be found');
    }

    if($avatar = $user->avatar()) {
      if(f::remove($avatar->root())) {
        return response::success('The avatar has been removed');
      }
    }

    return response::error('The avatar could not be removed');

  }

  protected function users() {
    return app::$site->users();
  }

  protected function user($username) {
    return app::$site->users()->find($username);
  }

  protected function userToArray($user) {

    return array(
      'username' => $user->username,
      'email'    => $user->email,
      'avatar'   => $user->avatar() ? $user->avatar()->url() : false
    );

  }

}