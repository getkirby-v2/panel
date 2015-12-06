<?php 

return function($page) {

  $options = array();

  foreach($page->parent()->blueprint()->pages()->template() as $template) {
    $options[$template->name()] = $template->title();
  }

  // create the form
  $form = new Kirby\Panel\Form(array(
    'template' => array(
      'label'     => 'pages.add.template.label',
      'type'      => 'select',
      'options'   => $options,
      'default'   => key($options),
      'required'  => true,
      'readonly'  => count($options) == 1 ? true : false,
      'icon'      => count($options) == 1 ? 'file-o' : 'chevron-down',
      'autofocus' => true
    )
  ), array(
    'template' => $page->intendedTemplate()
  ));

  $form->buttons->submit->val(l('change'));
  $form->cancel($page);

  return $form;

};