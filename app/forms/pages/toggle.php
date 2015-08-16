<?php 

return function($page) {

  $form = new Kirby\Panel\Form(array(
    'confirmation' => array(
      'type' => 'info'
    )
  ));

  $form->buttons->submit->value     = l('change');
  $form->buttons->submit->autofocus = true;

  $form->cancel($page);

  if($page->isVisible()) {
    $form->fields->confirmation->text = l('pages.toggle.hide');      
  } else {
    
    $form->fields->confirmation->text = l('pages.toggle.publish');      

    $parent    = $page->parent();
    $blueprint = $parent->blueprint();
    $siblings  = $parent->children()->visible();

    if($blueprint->pages()->num()->mode() == 'default' and $siblings->count() > 0) {

      $position = new Brick('ul');
      $position->addClass('position-list');

      $n = 0;

      foreach($siblings as $sibling) {
        $n++;
        $position->append('<li class="position-list-input"><label><input id="page-position-' . $n . '" name="position" value="' . $n . '" type="radio"></label></li>');
        $position->append('<li class="position-list-label"><label for="page-position-' . $n . '"><small>' . $n . '.</small> ' . $sibling->title()->html() . '</label></li>');
      }

      $n++;
      $position->append('<li class="position-list-input"><label><input checked name="position" value="' . $n . '" type="radio"></label></li>');
      
      $form->fields->confirmation->text .= $position;

    }

  }

  return $form;

};