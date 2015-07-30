<?php 

return function($page, $store) {

  $form = new Form($store->fields());

  $form->cancel($page, 'show');
  $form->buttons->submit->value = l('add');

  return $form;

};