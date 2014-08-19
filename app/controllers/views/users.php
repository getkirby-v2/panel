<?php

class UsersController extends Controller {

  public function index() {
    return view('users/index', array(
      'users'  => site()->users(),
      'topbar' => new Snippet('topbar', array(
        'breadcrumb' => new Snippet('breadcrumb', array(
          'items' => array(
            array(
              'title' => l('users'),
              'url'   => purl('users')
            )
          )
        ))
      )),
    ));
  }

  public function add() {

    $form = $this->form();
    $form->back = purl('users');

    return view('users/edit', array(
      'topbar' => new Snippet('topbar', array(
        'breadcrumb' => new Snippet('breadcrumb', array(
          'items' => array(
            array(
              'title' => l('users'),
              'url'   => purl('users')
            ),
            array(
              'title' => l('users.index.add'),
              'url'   => purl('users/add')
            )
          )
        ))
      )),
      'user'     => null,
      'writable' => is_writable(c::get('root.accounts')),
      'form'     => $form,
    ));

  }

  public function edit($username) {

    $user = $this->user($username);
    $form = $this->form($user);
    $form->back = purl('users');

    return view('users/edit', array(
      'topbar' => new Snippet('topbar', array(
        'breadcrumb' => new Snippet('breadcrumb', array(
          'items' => array(
            array(
              'title' => l('users'),
              'url'   => purl('users')
            ),
            array(
              'title' => $user->username(),
              'url'   => purl($user, 'edit')
            )
          )
        ))
      )),
      'form'     => $form,
      'writable' => is_writable(c::get('root.accounts')),
      'user'     => $user,
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
    $fields['language']['default'] = c::get('panel.language', 'en');

    foreach(app::languages() as $code => $lang) {
      $fields['language']['options'][$code] = $lang->title();
    }

    // make sure the password is never shown in the form
    unset($content['password']);

    return new Form($fields, $content);

  }

}