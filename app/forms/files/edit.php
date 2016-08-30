<?php 

use Kirby\Panel\Event;

return function($file) {

  // file info display
  $info = array();

  $info[] = $file->type();
  $info[] = $file->niceSize();

  if((string)$file->dimensions() != '0 x 0') {
    $info[] = $file->dimensions();      
  }

  $renameEvent = new Event('panel.file.rename', ['page' => $file->page()]);
  $updateEvent = new Event('panel.file.update', ['page' => $file->page()]);

  // setup the default fields
  $fields = array(
    '_name' => array(
      'label'     => 'files.show.name.label',
      'type'      => 'filename',
      'extension' => $file->extension(), 
      'required'  => true,
      'default'   => $file->name(),
      'readonly'  => !$renameEvent->checkPermissions($file)
    ),
    '_info' => array(
      'label'    => 'files.show.info.label',
      'type'     => 'text',
      'readonly' => true,
      'icon'     => 'info',
      'default'  => implode(' / ', $info),
    ),
    '_link' => array(
      'label'    => 'files.show.link.label',
      'type'     => 'text',
      'readonly' => true,
      'icon'     => 'chain',
      'default'  => $file->url()
    )
  );

  $form = new Kirby\Panel\Form(array_merge($fields, $file->getFormFields()), $file->getFormData());

  $form->centered = true;
  $form->buttons->cancel = '';

  if(!$updateEvent->checkPermissions($file)) {

    // switch all fields to readonly
    foreach($form->fields as $field) {
      $field->readonly = true;
    }

    // disable the save button
    $form->buttons->submit = '';

  }

  return $form;

};