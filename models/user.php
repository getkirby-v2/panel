<?php 

class User extends Obj {

  public function __construct($data) {

    parent::__construct($data);

    // fetch the avatar

    $avatarRoot   = c::get('root') . DS . 'assets' . DS . 'avatars' . DS . $this->username . '.jpg';
    $avatarURL    = url('assets/avatars/' . $this->username . '.jpg');
    $avatarExists = is_file($avatarRoot);

    $this->avatar = array(
      'root'   => $avatarRoot,
      'url'    => $avatarURL,
      'exists' => $avatarExists,
    ); 

  }

  public function avatar() {

    $this->avatar = '/assets/avatars/' . $this->username . '.jpg';

  }

  public function delete() {

    $file = c::get('root.accounts') . DS . $this->username . '.txt';

    // TODO: check if the user is deletable
    // TODO: delete avatar
    return f::remove($file);

  }

  static public function create($data) {

    $data = array_merge(array(
      'username' => null,
      'email'    => null,
      'password' => null
    ), $data);

    if(empty($data['username']))  throw new Exception('Missing username');
    if(!v::email($data['email'])) throw new Exception('Invalid email');
    if(empty($data['password']))  throw new Exception('Missing password');

    // sanitize the username
    $data['username'] = str::slug($data['username']);
    
    $file = c::get('root.accounts') . DS . $data['username'] . '.txt';

    if(!data::write($file, $data, 'kd')) throw new Exception('The user file could not be created');

    return new static($data);

  }

  static public function all() {

    $users = array();

    foreach(dir::read(c::get('root.accounts')) as $filename) {

      $file = c::get('root.accounts') . DS . $filename;

      if(!is_file($file) or f::extension($file) != 'txt') continue;

      $user = new User(data::read($file, 'kd'));

      $users[] = $user;

    }

    return $users;

  }

  static public function find($username) {

    foreach(static::all() as $user) {
      if($user->username == $username) return $user;
    }

    return false;

  } 

}