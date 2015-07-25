<?php

class FilesController extends Controller {

  public function index($id) {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);
    $files     = api::files($page, $blueprint);
    $back      = purl($page, 'show');

    // don't create the view if the page is not allowed to have files
    if($blueprint->files()->max() === 0) {
      throw new Exception('The page is not allowed to have any files');
    }

    // sort action
    $this->sort($page);

    return screen('files/index', $files, array(
      'page'     => $page,
      'files'    => $files,
      'back'     => $back,
      'sortable' => $blueprint->files()->sortable(),
    ));

  }

  public function upload($id) {

    $page = $this->page($id);

    try {
      new PageUploader($page);        
      panel()->notify(':)');
    } catch(Exception $e) {
      panel()->alert($e->getMessage());
    }

    if(!r::ajax()) {
      $this->redirect($page, 'show');
    }

  }

  public function show($id, $filename) {

    $page      = $this->page($id);
    $file      = $this->file($page, $filename);
    $blueprint = blueprint::find($page);
    $meta      = $file->meta()->toArray();
    $files     = api::files($page, $blueprint);
    $index     = $files->indexOf($file);

    // returnTo after delete
    $returnTo = url::last() == purl($page, 'files') ? purl($page, 'files') : purl($page, 'show');

    // file info display
    $info = array();

    $info[] = $file->type();
    $info[] = $file->niceSize();

    if((string)$file->dimensions() != '0 x 0') {
      $info[] = $file->dimensions();      
    }

    $fields = array(
      '_name' => array(
        'label'     => 'files.show.name.label',
        'type'      => 'filename',
        'extension' => $file->extension(), 
        'required'  => true,
      ),
      '_info' => array(
        'label'    => 'files.show.info.label',
        'type'     => 'text',
        'readonly' => true,
        'icon'     => 'info'
      ),
      '_link' => array(
        'label'    => 'files.show.link.label',
        'type'     => 'text',
        'readonly' => true,
        'icon'     => 'chain'
      )
    );

    // add the custom fields
    $fields = array_merge($fields, $blueprint->files()->fields($page)->toArray());

    // create the form
    $form = new Form($fields, $meta);
    $form->centered = true;

    $form->fields->_name->value = $file->name();
    $form->fields->_info->value = implode(' / ', $info);
    $form->fields->_link->value = $file->url();

    unset($form->buttons->cancel);

    $self = $this;

    // form action
    $form->on('submit', function($form) use($file, $page, $self) {

      $form->validate();

      if(!$form->isValid()) {
        return panel()->alert(l('files.show.error.form'));
      }

      // fetch the form data
      $data = filedata::createByInput($file, $form->serialize());

      try {

        if($data['_name'] != $file->name()) {

          // rename and get the new filename          
          $filename = $file->rename($data['_name']);
          
          // restore all page caches
          $page->reset();

          // search the new file
          $file = $page->file($filename);

          // missing file for some reason
          if(!$file) {
            throw new Exception('The file could not be properly renamed');
          }

          // trigger the rename hook
          kirby()->trigger('panel.file.rename', $file);          

        } else {
          $filename = $file->filename();
        }

        // remove the name url and info
        unset($data['_name']);
        unset($data['_info']);
        unset($data['_link']);

        $file->update($data);

        kirby()->trigger('panel.file.update', $file);

        panel()->notify(l('saved'));

        go(purl($page, 'file/' . urlencode($filename) . '/show'));

      } catch(Exception $e) {
        return panel()->alert($e->getMessage());
      }

    });

    return screen('files/show', $file, array(
      'form'     => $form,
      'p'        => $page,
      'f'        => $file,
      'returnTo' => $returnTo,
      'next'     => $files->nth($index + 1),
      'prev'     => $files->nth($index - 1),
    ));

  }

  public function replace($id, $filename) {

    $page = $this->page($id);
    $file = $this->file($page, $filename);

    if(r::is('post')) {

      try {
        new PageUploader($page, $file);        
      } catch(Exception $e) {
        panel()->alert($e->getMessage());
      }

      $this->redirect($file, 'show');

    }

    return modal('files/upload', array(
      'mode' => 'replace',
      'url'  => purl($file, 'replace'),
      'back' => purl($file, 'show')
    ));

  }

  public function context($id, $filename) {

    $page = $this->page($id);
    $file = $this->file($page, $filename);

    return new FileMenu($file);

  }

  public function delete($id, $filename) {

    $page = $this->page($id);
    $file = $this->file($page, $filename);
    $self = $this;

    $form = panel()->form('files/delete');
    $form->fields->file->value = $file->filename();
    $form->style('delete');
    $form->cancel($file, 'show');

    $form->on('submit', function($form) use($file, $page, $self) {

      try {
        $file->delete();
        kirby()->trigger('panel.file.delete', $file);
        panel()->notify(':)');
        $self->redirect($page, 'show');
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return modal('files/delete', compact('form'));

  }

  protected function sort($page) {

    if(!r::is('post') or get('action') != 'sort') return;

    $filenames = get('filenames');
    $counter   = 0;

    foreach($filenames as $filename) {

      if($file = $page->file($filename)) {

        $counter++;

        try {
          $file->update(array('sort' => $counter));
          kirby()->trigger('panel.file.sort', $file);
        } catch(Exception $e) {

        }

      }

    }

    $this->redirect($page, 'files');

  }

  protected function page($id) {

    if($id == '/') {
      return site();
    } else if($page = page($id)) {
      return $page;
    } else {
      throw new Exception(l('files.error.missing.page'));
    }

  }

  protected function file($page, $filename) {

    if($file = $page->file($filename)) {
      return $file;
    } else {
      throw new Exception(l('files.error.missing.file'));
    }

  }

}