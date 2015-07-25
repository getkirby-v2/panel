<?php

class UsersController extends Controller {

  public function index() {

    $users = site()->users();
    $admin = site()->user()->isAdmin();

    return screen('users/index', $users, array(
      'users'  => $users,
      'admin'  => $admin,
    ));

  }

  public function add() {

    if(!site()->user()->isAdmin()) {
      $this->redirect('users');
    }

    $self = $this;
    $form = $this->form();

    // make the password a requirement
    $form->fields->password->required = true;

    $form->on('submit', function($form) use($self) {
      
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $data = $form->serialize();

      if($data['password'] !== $data['passwordconfirmation']) {
        return $form->alert(l('users.form.error.password.confirm'));
      }

      unset($data['passwordconfirmation']);

      try {
        $user = site()->users()->create($data);
        kirby()->trigger('panel.user.create', $user);
        panel()->notify(l('saved'));
        $self->redirect($user, 'edit');
      } catch(Exception $e) {
        panel()->alert($e->getMessage());
      }

    });

    return screen('users/edit', 'user', array(
      'user'     => null,
      'writable' => is_writable(kirby()->roots()->accounts()),
      'form'     => $form,
    ));

  }

  public function edit($username) {

    $user = $this->user($username);
    $form = $this->form($user);
    $self = $this;

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      $this->redirect('users');
    }

    $form->on('submit', function($form) use($user, $self) {
      
      $form->validate();

      if(!$form->isValid()) {
        return false;
      }

      $data = $form->serialize();

      if(str::length($data['password']) > 0) {
        if($data['password'] !== $data['passwordconfirmation']) {
          return $form->alert(l('users.form.error.password.confirm'));
        }
      } else {
        unset($data['password']);
      }

      unset($data['passwordconfirmation']);

      try {
        $user->update($data);
        kirby()->trigger('panel.user.update', $user);
        panel()->notify(l('saved'));
        $self->redirect($user, 'edit');
      } catch(Exception $e) {
        panel()->alert($e->getMessage());
      }
        
    });

    return screen('users/edit', $user, array(
      'form'     => $form,
      'writable' => is_writable(kirby()->roots()->accounts()),
      'user'     => $user,
    ));

  }

  public function delete($username) {

    $user = $this->user($username);
    $self = $this;

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to delete this user'
      ));
    } else {

      $form = panel()->form('users/delete');
      $form->fields->username->value = $user->username();
      $form->fields->username->help  = $user->email();

      $form->on('submit', function($form) use($user, $self) {

        try {
          $user->delete();
          kirby()->trigger('panel.user.delete', $user);
          panel()->notify(':)');
          $self->redirect('users');
        } catch(Exception $e) {
          $form->alert(l('users.delete.error'));
        }

      });

      $form->style('delete');
      $form->cancel($user, 'edit');

      return modal('users/delete', compact('form'));

    }

  }

  public function avatar($username) {

    $user = $this->user($username);
    $root = $user->avatar() ? $user->avatar()->root() : $user->avatarRoot('{safeExtension}');

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      panel()->alert('You are not allowed to change the avatar');
    } else {

      $upload = new Upload($root, array(
        'accept' => function($upload) {
          if($upload->type() != 'image') {
            throw new Error(l('users.avatar.error.type'));
          }
        }
      ));

      if($upload->file()) {
        thumb::$defaults['root'] = dirname($upload->file()->root());
        $thumb = new Thumb($upload->file(), array(
          'filename'  => $upload->file()->filename(),
          'overwrite' => true,
          'width'     => 256,
          'height'    => 256,
          'crop'      => true
        ));
        kirby()->trigger('panel.avatar.upload', $user->avatar());
        panel()->notify(':)');
      } else {
        panel()->alert($upload->error()->getMessage());
      }

    }

    if(!r::ajax()) {
      $this->redirect($user, 'edit');        
    }

  }

  public function deleteAvatar($username) {

    $self   = $this;
    $user   = $this->user($username);
    $form   = panel()->form('users/delete-avatar');
    $avatar = $user->avatar();

    if(!site()->user()->isAdmin() and !$user->isCurrent()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to delete the avatar of this user',
      ));
    } else if(!$avatar) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'This user has no avatar',
      ));
    }

    $form->on('submit', function($form) use($user, $avatar, $self) {

      if(f::remove($avatar->root())) {
        kirby()->trigger('panel.avatar.delete', $avatar);
        $self->redirect($user, 'edit');
      } else {
        $form->alert(l('users.avatar.delete.error'));
      }

    });

    $form->fields->image->text = '(image: ' . $user->avatar()->url() . '?' . $user->avatar()->modified() . ' class: avatar avatar-full avatar-centered)';
    $form->centered = true;
    $form->style('delete');

    return modal('users/delete-avatar', array(
      'form' => $form,
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
    $content = $user ? $user->data() : array();
    
    // make sure the password is never shown in the form
    unset($content['password']);

    $defaults = array(
      'language' => kirby()->option('panel.language', 'en'),
      'role'     => site()->roles()->findDefault()->id()
    );

    // create the form
    $form = panel()->form('users/' . $mode, array_merge($defaults, $content));

    // add all languages
    foreach(panel()->languages() as $code => $lang) {
      $form->fields->language->options[$code] = $lang->title();
    }

    // add all roles
    foreach(site()->roles() as $role) {
      $form->fields->role->options[$role->id()] = $role->name();
    }

    // make the role selector readonly when the user is not an admin
    if(!site()->user()->isAdmin()) {
      $form->fields->role->readonly = true;
    }

    $form->fields->email->autocomplete = false;

    $form->cancel('users');

    return $form;

  }

}