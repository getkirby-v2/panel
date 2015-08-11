<?php 

return function() {

  $languages = array();

  foreach(panel()->languages() as $lang) {
    $languages[$lang->code()] = $lang->title();
  }

  $form = new Kirby\Panel\Form(array(

    'username' => array(
      'label'        => 'installation.signup.username.label',
      'type'         => 'text',
      'icon'         => 'user',
      'placeholder'  => 'installation.signup.username.placeholder',
      'required'     => true,
      'autocomplete' => false,
      'autofocus'    => true,
    ),

    'email' => array(
      'label'        => 'installation.signup.email.label',
      'placeholder'  => 'installation.signup.email.placeholder',
      'type'         => 'email',
      'required'     => true,
      'autocomplete' => false,
    ),

    'password' => array(
      'label'        => 'installation.signup.password.label',
      'type'         => 'password',
      'required'     => true,
      'autocomplete' => false,
      'suggestion'   => true,
    ),

    'language' => array(
      'label'        => 'installation.signup.language.label',
      'type'         => 'select',
      'required'     => true,
      'autocomplete' => false,
      'default'      => kirby()->option('panel.language', 'en'),
      'options'      => $languages
    )

  ));

  $form->data('autosubmit', 'native');
  $form->style('centered');

  $form->buttons->submit->value = l('installation.signup.button');

  return $form;

};