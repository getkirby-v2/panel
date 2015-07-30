<?php 

return function($page) {

  // label option
  $option = new Brick('a', icon('plus-circle', 'left') . l('pages.url.uid.label.option'), array(
    'class'      => 'btn btn-icon label-option',
    'href'       => '#',
    'data-title' => $page->title()
  ));

  // url preview
  $preview = new Brick('div', '', array('class' => 'uid-preview'));
  $preview->append(ltrim($page->parent()->uri() . '/', '/'));
  $preview->append('<span>' . $page->slug() . '</span>');

  // create the form
  $form = new Form(array(
    'uid' => array(
      'label'     => l('pages.url.uid.label') . $option,
      'type'      => 'text',
      'icon'      => 'chain',
      'autofocus' => true,
      'help'      => $preview,
      'default'   => $page->slug()
    )
  ));

  $form->buttons->submit->val(l('change'));
  $form->cancel($page->url());

  return $form;

};