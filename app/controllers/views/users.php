<?php

class UsersController extends Controller {

  public function index() {
    $user    = site()->user();

    return view('users/index', array(
      'users'         => site()->users(),
      'addbutton'     => $user->hasPermission('user.add'),
      'editbutton'    => $user->hasPermission('user.edit') or
                         $user->hasPermission('user.role'),
      'deletebutton'  => $user->hasPermission('user.delete'),
      'adminsleft'    => site()->roles()->get('admin')->users()->count(),
      'topbar'        => new Snippet('topbar', array(
        'breadcrumb'  => new Snippet('breadcrumb', array(
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

    if(!site()->user()->hasPermission('user.add')) goToErrorView();

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
      'writable' => is_writable(kirby()->roots()->accounts()),
      'form'     => $form,
    ));

  }

  public function edit($username) {

    $puser  = site()->user();
    $user   = $this->user($username);
    $form   = $this->form($user);
    $form->back = purl('users');

    if(!$user->isCurrent() and
       !$puser->hasPermission('user.edit') and
       !$puser->hasPermission('user.role')) {
      goToErrorView();
    }

    if (!$puser->hasPermission('user.edit')) {
      foreach($form->fields() as $name => $field) {
        if($name != 'role') $field->readonly = true;
      }
    }

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
      'form'          => $form,
      'editbutton'    => $user->isCurrent() or
                         $puser->hasPermission('user.edit'),
      'deletebutton'  => $puser->hasPermission('user.delete') and
                         (!$user->isAdmin() or site()->roles()->get('admin')->users()->count() > 1),
      'writable'      => is_writable(kirby()->roots()->accounts()),
      'user'          => $user,
    ));

  }

  public function delete($username) {

    $user = $this->user($username);
    $back = array(
      'users'     => purl('users'),
      'user'      => purl($user, 'edit'),
      'dashboard' => purl('')
    );

    if(!site()->user()->hasPermission('user.delete') or ($user->isAdmin() and site()->roles()->get('admin')->users()->count() <= 1)) {
      goToErrorView('modal');
    }

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

    if(!$user->isCurrent() and !site()->user()->hasPermission('user.edit')) {
      goToErrorView('modal');
    }

    return view('users/avatar', array(
      'user'       => $user,
      'uploadable' => is_writable(kirby()->roots()->avatars()),
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
    $fields  = data::read(panel()->roots()->forms() . DS . 'user.' . $mode . '.php', 'yaml');
    $content = $user ? $user->data() : array();

    // add all languages
    $fields['language']['options'] = array();
    $fields['language']['default'] = kirby()->option('panel.language', 'en');

    foreach(panel()->languages() as $code => $lang) {
      $fields['language']['options'][$code] = $lang->title();
    }

    // add all roles
    $fields['role']['options'] = array();
    $fields['role']['default'] = site()->roles()->findDefault()->id();

    foreach(site()->roles() as $role) {
      $fields['role']['options'][$role->id()] = $role->name();
    }

    // make the role selector readonly when the user is not an admin
    if(!site()->user()->hasPermission('user.role') and $mode != 'add') {
      $fields['role']['readonly'] = true;
    }

    // make sure the password is never shown in the form
    unset($content['password']);

    return new Form($fields, $content);

  }

}
