<?php 

return function($page, $store, $entry) {

  $form = new Form($store->fields(), $entry->toArray());

  $form->cancel($page, 'show');
  $form->buttons->submit->value = l('ok');

  return $form;

};