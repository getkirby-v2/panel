<?php

class StructureController extends Controller {

  public function add($pageId, $fieldname) {

    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $form  = $this->form('structure/add', array($page, $store), function($form) use($page, $store, $self) {
      $store->add($form->serialize());
      $self->redirect($page, 'show');
    });

    return modal('structure/add', compact('form'));

  }

  public function update($pageId, $fieldname, $entryId) {

    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $entry = $store->find($entryId);
    $form  = $this->form('structure/update', array($page, $store, $entry), function($form) use($page, $store, $self, $entryId) {
      $store->update($entryId, $form->serialize());
      $self->redirect($page, 'show');
    });

    return modal('structure/update', compact('form'));
        
  }

  public function delete($pageId, $fieldname, $entryId) {
    
    $self  = $this;
    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $entry = $store->find($entryId);
    $form  = $this->form('structure/delete', $page, function() use($self, $page, $store, $entryId) {
      $store->delete($entryId);
      $self->redirect($page, 'show');
    });
    
    return modal('structure/delete', compact('form'));

  }

  public function sort($pageId, $fieldname) {

    $page  = $this->page($pageId);
    $store = $this->store($page, $fieldname);
    $store->sort(get('ids'));

    $this->redirect($page, 'show');

  }

  protected function store($page, $fieldname) {
    return new StructureStore($page, $fieldname);
  }

} 