<?php

class UsersController extends Controller {

  public function index() {
    return view('users/index', array(
      'topbar' => new Snippet('users/topbar', array(
        'menu' => new Snippet('menu'),
        'breadcrumb' => new Snippet('users/breadcrumb', array(
          'user' => null
        ))
      )),
      'users' => site()->users(),
    ));
  }

  public function add() {

    $back = array(
      'users'     => purl('users'),
      'dashboard' => purl('')
    );

    return view('users/edit', array(
      'topbar' => new Snippet('users/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('users/breadcrumb', array(
          'user' => false
        ))
      )),
      'user'     => null,
      'writable' => is_writable(c::get('root.accounts')),
      'form'     => $this->form(),
      'save'     => l('add'),
      'back'     => a::get($back, get('to'))
    ));

  }

  public function edit($username) {

    $user = $this->user($username);
    $back = array(
      'users'     => purl('users'),
      'dashboard' => purl('')
    );

    return view('users/edit', array(
      'topbar' => new Snippet('users/topbar', array(
        'menu'       => new Snippet('menu'),
        'breadcrumb' => new Snippet('users/breadcrumb', array(
          'user' => $user
        ))
      )),
      'form'     => $this->form($user),
      'writable' => is_writable(c::get('root.accounts')),
      'user'     => $user,
      'save'     => l('save'),
      'back'     => a::get($back, get('to'))
    ));

  }

  public function delete($username) {

    $user = $this->user($username);
    $back = array(
      'users'     => purl('users'),
      'user'      => purl($user, 'edit'),
      'dashboard' => purl('')
    );

    return view('users/delete', array(
      'user' => $user,
      'back' => a::get($back, get('to'))
    ));

  }

  public function avatar($username) {

    $user = $this->user($username);
    $back = array(
      'users'     => purl('users'),
      'user'      => purl($user, 'edit'),
      'dashboard' => purl('')
    );

    return view('users/avatar', array(
      'user'       => $user,
      'uploadable' => is_writable(c::get('root') . DS . 'assets' . DS . 'avatars'),
      'back'       => a::get($back, get('to'))
    ));

  }

  public function deleteAvatar($username) {

    $user = $this->user($username);

    return view('users/delete-avatar', array(
      'user' => $user,
    ));

  }

  protected function user($username) {
    if($user = site()->user($username)) {
      return $user;
    } else {
      throw new Exception(l('users.error.missing'));
    }
  }

  protected function form($user = null) {

    $mode    = $user ? 'edit' : 'add';
    $fields  = data::read(root('panel.app') . DS . 'forms' . DS . 'user.' . $mode . '.php', 'yaml');
    $content = $user ? $user->data() : array();

    // add all languages
    $fields['language']['options'] = array();

    foreach(app::languages() as $code => $lang) {
      $fields['language']['options'][$code] = $lang->title();
    }

    // make sure the password is never shown in the form
    unset($content['password']);

    return new Form($fields, $content);

  }

}