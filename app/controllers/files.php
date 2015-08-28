<?php

class FilesController extends Kirby\Panel\Controller {

  public function index($id) {

    $page  = $this->page($id);
    $files = $page->files();

    // don't create the view if the page is not allowed to have files
    if(!$page->canHaveFiles()) {
      throw new Exception('The page is not allowed to have any files');
    }

    // sort action
    $this->sort($page);

    return $this->screen('files/index', $files, array(
      'page'     => $page,
      'files'    => $files,
      'back'     => $page->url('edit'),
      'sortable' => $page->canSortFiles(),
      'uploader' => $this->snippet('uploader', array('url' => $page->url('upload')))
    ));

  }

  public function edit($id, $filename) {

    $self = $this;
    $page = $this->page($id);
    $file = $page->file($filename);

    // setup the form and form action
    $form = $file->form('edit', function($form) use($file, $page, $self) {

      $form->validate();

      if(!$form->isValid()) {
        return $self->alert(l('files.show.error.form'));
      }

      try {
        $file->update($form->serialize());
        $self->notify(l('saved'));
        $self->redirect($file);
      } catch(Exception $e) {
        $self->alert($e->getMessage());
      }

    });

    return $this->screen('files/edit', $file, array(
      'form'     => $form,
      'page'     => $page,
      'file'     => $file,
      'returnTo' => url::last() == $page->url('files') ? $page->url('files') : $page->url('edit'),
      'uploader' => $this->snippet('uploader', array(
        'url'      => $file->url('replace'), 
        'accept'   => $file->mime(),
        'multiple' => false
      ))
    ));

  }

  public function upload($id) {

    $page = $this->page($id);

    try {
      $page->upload();        
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($page);

  }

  public function replace($id, $filename) {

    $file = $this->page($id)->file($filename);

    try {
      $file->replace();        
      $this->notify(':)');
    } catch(Exception $e) {
      $this->alert($e->getMessage());
    }

    $this->redirect($file);

  }

  public function context($id, $filename) {
    return $this->page($id)->file($filename)->menu();
  }

  public function delete($id, $filename) {

    $self = $this;
    $page = $this->page($id);
    $file = $page->file($filename);
    $form = $this->form('files/delete', $file, function($form) use($file, $page, $self) {

      try {
        $file->delete();
        $self->notify(':)');
        $self->redirect($page, 'edit');
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('files/delete', compact('form'));

  }

  protected function sort($page) {

    if(!r::is('post') or get('action') != 'sort') return;

    $filenames = get('filenames');
    $counter   = 0;

    foreach($filenames as $filename) {
      if($file = $page->file($filename)) {
        $counter++;
        try {
          $file->update('sort', $counter);
        } catch(Exception $e) {

        }
      }
    }

    $this->redirect($page, 'files');

  }

}