<?php 

return function($model, $store, $entry) {
  
  $form = new Kirby\Panel\Form($store->fields(), $entry->toArray(), $store->field());

  $form->cancel($model);
  $form->buttons->submit->value = l('ok');

  return $form;

};