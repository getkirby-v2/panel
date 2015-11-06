<?php 

return function($page) {

  // create the form
  $form = new Kirby\Panel\Form($page->getFormFields(), $page->getFormData());

  // add the blueprint name as css class
  $form->addClass('form-blueprint-' . $page->blueprint()->name());

  // center the submit button
  $form->centered = true;

  // set the keep api    
  $form->data('keep', $page->url('keep'));

  // remove the cancel button
  $form->buttons->cancel = '';

  // set the autofocus on the title field
  $form->fields->title->autofocus = true;

  // add the changes alert
  if($page->changes()->differ()) {

    // display unsaved changes
    $alert = new Brick('div');
    $alert->addClass('text marginalia');
    $alert->attr('style', 'margin-top: 1.5rem');
    $alert->append(l('pages.show.changes.text') . '<br>');
    $alert->append('<a href="' . $page->url('discard') . '">' . l('pages.show.changes.button') . '</a>');

    $form->buttons->append('changes', $alert);

  }

  // check for untranslatable fields
  if(panel()->site()->language() != panel()->site()->defaultLanguage()) {

    foreach($form->fields() as $field) {
      if($field->translate() == false) {
        $field->readonly = true;
        $field->disabled = true;
      }
    }

  }

  return $form;

};