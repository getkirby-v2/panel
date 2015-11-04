<?php 

return function($page) {

  $options = array();

  foreach($page->blueprint()->pages()->template() as $template) {
    $options[$template->name()] = $template->title();
  }

  $form = new Kirby\Panel\Form(array(
    'title' => array(
      'label'        => 'pages.add.title.label',
      'type'         => 'title',
      'placeholder'  => 'pages.add.title.placeholder',
      'autocomplete' => false,
      'autofocus'    => true,
      'required'     => true
    ),
    'uid' => array(
      'label'        => 'pages.add.url.label',
      'type'         => 'text',
      'icon'         => 'chain',
      'autocomplete' => false,
      'required'     => true,
    ),
    'template' => array(
      'label'    => 'pages.add.template.label',
      'type'     => 'select',
      'options'  => $options,
      'default'  => key($options),
      'required' => true,
      'readonly' => count($options) == 1 ? true : false,
      'icon'     => count($options) == 1 ? 'file-o' : 'chevron-down',
    )
  ));

  $form->buttons->submit->removeClass('btn-submit');

  $addButton = new Brick('button');
  $addButton->addClass('btn btn-rounded');
  $addButton->attr('type', 'submit');
  $addButton->attr('title', l('add'));
  $addButton->html(l('add'));

  $editButton = new Brick('button');
  $editButton->addClass('btn btn-rounded btn-addit');
  $editButton->attr('type', 'submit');
  $editButton->attr('title', l('addit'));
  $editButton->data('action', $page->url('add/edit'));
  $editButton->html(l('addit'));

  $form->buttons->submit = new Brick('span');
  $form->buttons->submit->addClass('btn-submit');
  
  $form->buttons->submit->append($addButton);
  $form->buttons->submit->append($editButton);

  $form->cancel($page->isSite() ? '/' : $page);

  return $form;

};