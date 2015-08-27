<?php 

return function($page) {

  $options = array();

  foreach($page->blueprint()->pages()->template() as $template) {
    $options[$template->name()] = $template->title();
  }

  $form = new Kirby\Panel\Form(array(
    'template' => array(
      'label'    => 'pages.add.template.label',
      'type'     => 'select',
      'options'  => $options,
      'default'  => key($options),
      'required' => true
    )
  ));

  $form->buttons->submit->value = l('add');
  
  $form->cancel($page);

  return $form;

};