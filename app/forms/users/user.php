<?php

return function($user) {

  $mode      = $user ? 'edit' : 'add';
  $content   = $user ? $user->data() : array();
  $languages = array();
  $roles     = array();

  // make sure the password is never shown in the form
  unset($content['password']);

  // add all languages
  foreach(panel()->languages() as $code => $lang) {
    $languages[$code] = $lang->title();
  }

  // add all roles
  foreach(site()->roles() as $role) {
    $roles[$role->id()] = $role->name();
  }

  // setup the form with all fields
  $form = new Kirby\Panel\Form(array(

    'username' => array(
      'label'     => 'users.form.username.label',
      'type'      => 'text',
      'icon'      => 'user',
      'autofocus' => $mode != 'edit',
      'required'  => true,
      'help'      => $mode == 'edit' ? 'users.form.username.readonly' : 'users.form.username.help',
      'readonly'  => $mode == 'edit',
    ),

    'firstName' => array(
      'label'     => 'users.form.firstname.label',
      'autofocus' => $mode == 'edit',
      'type'      => 'text',
      'width'     => '1/2',
    ),

    'lastName' => array(
      'label' => 'users.form.lastname.label',
      'type'  => 'text',
      'width' => '1/2',
    ),

    'email' => array(
      'label'        => 'users.form.email.label',
      'type'         => 'email',
      'required'     => true,
      'autocomplete' => false
    ),

    'password' => array(
      'label'      => $mode == 'edit' ? 'users.form.password.new.label' : 'users.form.password.label',
      'required'   => $mode == 'add',
      'type'       => 'password',
      'width'      => '1/2',
      'suggestion' => true,
    ),

    'passwordConfirmation' => array(
      'label'    => $mode == 'edit' ? 'users.form.password.new.confirm.label' : 'users.form.password.confirm.label',
      'required' => $mode == 'add',
      'type'     => 'password',
      'width'    => '1/2',
    ),

    'language' => array(
      'label'    => 'users.form.language.label',
      'type'     => 'select',
      'required' => true,
      'width'    => '1/2',
      'default'  => kirby()->option('panel.language', 'en'),
      'options'  => $languages
    ),

    'role' => array(
      'label'    => 'users.form.role.label',
      'type'     => 'select',
      'required' => true,
      'width'    => '1/2',
      'default'  => site()->roles()->findDefault()->id(),
      'options'  => $roles,
      'readonly' => ($user ? (!panel()->user()->isAllowed('roleUser') or $user->isLastAdmin()) : false)



    ),

  ), $content);

  $form->cancel('users');

  if($mode == 'add') {
    $form->buttons->submit->value = l('add');
  }

  return $form;

};

