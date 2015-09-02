<?php

class StructureFieldController extends Kirby\Panel\Controllers\Field {

  public function add() {

    $self  = $this;
    $page  = $this->model();
    $store = $this->store($page);
    $form  = $this->form('add', array($page, $store), function($form) use($page, $store, $self) {
      $store->add($form->serialize());
      $self->notify(':)');
      $self->redirect($page);
    });

    return $this->modal('add', compact('form'));

  }

  public function update($entryId) {

    $self  = $this;
    $page  = $this->model();
    $store = $this->store($page);
    $entry = $store->find($entryId);
    $form  = $this->form('update', array($page, $store, $entry), function($form) use($page, $store, $self, $entryId) {
      $store->update($entryId, $form->serialize());
      $self->notify(':)');
      $self->redirect($page);
    });

    return $this->modal('update', compact('form'));
        
  }

  public function delete($entryId) {
    
    $self  = $this;
    $page  = $this->model();
    $store = $this->store($page);
    $entry = $store->find($entryId);
    $form  = $this->form('delete', $page, function() use($self, $page, $store, $entryId) {
      $store->delete($entryId);
      $self->notify(':)');
      $self->redirect($page);
    });
    
    return $this->modal('delete', compact('form'));

  }

  public function sort() {
    $page  = $this->model();
    $store = $this->store($page);
    $store->sort(get('ids'));
    $this->redirect($page);
  }

  protected function store($page) {
    return $page->structure($this->fieldname());
  }

}