<?php

class StructureController extends Controller {

  public function add($pageId, $fieldname) {

    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $form  = new Form($store->fields());

    $form->on('submit', function($form) use($page, $store, $self) {
      $store->add($form->serialize());
      $self->redirect($page, 'show');
    });

    $form->cancel($page, 'show');
    $form->buttons->submit->value = l('add');

    return modal('structure/add', compact('form'));

  }

  public function update($pageId, $fieldname, $entryId) {

    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $entry = $store->find($entryId);
    $form  = new Form($store->fields(), $entry->toArray());

    $form->on('submit', function($form) use($page, $store, $self, $entryId) {
      $store->update($entryId, $form->serialize());
      $self->redirect($page, 'show');
    });

    $form->cancel($page, 'show');
    $form->buttons->submit->value = l('add');

    return modal('structure/update', compact('form'));
        
  }

  public function delete($pageId, $fieldname, $entryId) {
    
    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $entry = $store->find($entryId);

    $form = panel()->form('structure/delete');
    
    $form->on('submit', function() use($self, $page, $store, $entryId) {
      $store->delete($entryId);
      $self->redirect($page, 'show');
    });
    
    $form->style('delete');
    $form->cancel($page, 'show');

    return modal('structure/delete', compact('form'));

  }

  public function sort($pageId, $fieldname) {

    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $store->sort(get('ids'));

    $this->redirect($page, 'show');

  }

  protected function page($pageId) {

    $page = $pageId == '/' ? site() : page($pageId);

    if($page) {
      return $page;
    } else {
      throw new Exception('The page could not be found');
    }

  }

  protected function store($page, $fieldname) {
    return new StructureStore($page, $fieldname);
  }

} 