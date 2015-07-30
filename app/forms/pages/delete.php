<?php 

return function($page) {

  $form = new Form(array(
    'page' => array(
      'label'    => 'pages.delete.headline',
      'type'     => 'text',
      'readonly' => true,
      'icon'     => false,
      'default'  => $page->title(),
      'help'     => $page->id(),
    )
  ));

  $form->style('delete');
  $form->cancel($page);

  return $form;

};