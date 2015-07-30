<?php 

return function($welcome) {

  $form = new Form(array(
    'username' => array(
      'label'     => 'login.username.label',
      'type'      => 'text',
      'icon'      => 'user',
      'required'  => true,
      'autofocus' => true,
      'default'   => s::get('username')
    ),
    'password' => array(
      'label'     => 'login.password.label',
      'type'      => 'password',
      'required'  => true
    )
  ));

  $form->data('autosubmit', 'native');
  $form->style('centered');
  
  $form->buttons->submit->value = l('login.button');

  if($welcome) {
    $form->notify(l('login.welcome'));
  }

  return $form;

};

