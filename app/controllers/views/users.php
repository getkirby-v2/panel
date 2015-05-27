<?php

class UsersController extends Controller {

  public function index() {
    $usersOptions = new UsersOptions();

    return view('users/index', array(
      'users'         => site()->users(),
      'addbutton'     => $usersOptions->canAdd(),
      'editbutton'    => $usersOptions->canEdit(),
      'deletebutton'  => $usersOptions->canDelete(),
      'lastadmin'     => $usersOptions->lastAdmin(),
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
    $usersOptions = new UsersOptions();

    if(!$usersOptions->canAdd()) goToErrorView();

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

    $usersOptions = new UsersOptions();
    $user         = $this->user($username);
    $form         = $this->form($user);
    $form->back   = purl('users');

    if(!$user->isCurrent() and !$usersOptions->canEdit()) goToErrorView();

    if (!$user->isCurrent() and !$usersOptions->canEditInfo()) {
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
                         $usersOptions->canEditInfo(),
      'deletebutton'  => $usersOptions->canDelete() and
                         !($user->isAdmin() and $usersOptions->lastAdmin()),
      'writable'      => is_writable(kirby()->roots()->accounts()),
      'user'          => $user,
    ));

  }

  public function delete($username) {

    $usersOptions = new UsersOptions();
    $user         = $this->user($username);
    $back         = array(
      'users'     => purl('users'),
      'user'      => purl($user, 'edit'),
      'dashboard' => purl('')
    );

    if(!$usersOptions->canDelete() or ($user->isAdmin() and $usersOptions->lastAdmin())) {
      goToErrorView('modal');
    }

    return view('users/delete', array(
      'user' => $user,
      'back' => a::get($back, get('to'))
    ));

  }

  public function avatar($username) {

    $usersOptions = new UsersOptions();
    $user         = $this->user($username);
    $back         = array(
      'users'     => purl('users'),
      'user'      => purl($user, 'edit'),
      'dashboard' => purl('')
    );

    if(!$user->isCurrent() and !$usersOptions->canEditInfo()) {
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

    $mode         = $user ? 'edit' : 'add';
    $fields       = data::read(panel()->roots()->forms() . DS . 'user.' . $mode . '.php', 'yaml');
    $content      = $user ? $user->data() : array();
    $usersOptions = new UsersOptions();

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

    // make the role selector readonly when the user has no permission
    if(!$usersOptions->canEditRole() and $mode != 'add') {
      $fields['role']['readonly'] = true;
    }

    // make sure the password is never shown in the form
    unset($content['password']);

    return new Form($fields, $content);

  }

}
