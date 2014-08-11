<?php

class FilesController extends Controller {

  public function upload($id) {

    $page   = $this->page($id);
    $upload = new Upload($page->root() . DS . '{safeFilename}', array(
      'overwrite' => true,
      'accept'    => function($file) {

        if($file->mime() == 'text/plain') return false;

        $callback = c::get('panel.upload.accept');

        if(is_callable($callback)) {
          return call($callback, $file);
        } else {
          return true;
        }

      }
    ));

    if($upload->file()) {
      return response::success('success');
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function replace($id) {

    $filename = get('filename');
    $file     = $this->file($id, $filename);
    $upload   = new Upload($file->root(), array(
      'overwrite' => true,
      'accept' => function($upload) use($file) {
        if($upload->mime() != $file->mime()) {
          throw new Error(l('files.replace.error.type'));
        }
      }
    ));

    if($upload->file()) {
      return response::success('success');
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function rename($id) {

    $filename = get('filename');
    $file     = $this->file($id, $filename);

    if(!$file) {
      return response::error(l('files.error.missing.file'));
    }

    try {
      $filename = $file->rename(get('name'));
      return response::success('success', array(
        'filename' => $filename
      ));
    } catch(Exception $e) {
      return response::error(l('files.show.error.rename'));
    }

  }

  public function update($id) {

    $filename = get('filename');
    $page     = $this->page($id);

    if(!$page) {
      return response::error(l('files.error.missing.page'));
    }

    $file = $page->file($filename);

    if(!$file) {
      return response::error(l('files.error.missing.file'));
    }

    $blueprint = blueprint::find($page);
    $fields    = $blueprint->files()->fields()->toArray();
    $form      = new Form($fields);
    $data      = $form->serialize();

    // trigger the validation
    $form->validate();

    // stop at invalid fields
    if(!$form->isValid()) {
      return response::error(l('files.show.error.form'), 400, array(
        'fields' => $form->fields()->filterBy('error', true)->pluck('name')
      ));
    }

    try {


      $file->update($data, app::$language);
      return response::success('success', array(
        'data' => $data
      ));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function sort($id) {

    $page = $this->page($id);

    if(!$page) {
      return response::error(l('files.error.missing.page'));
    }

    $filenames = get('filenames');
    $counter   = 0;

    foreach($filenames as $filename) {

      $file = $page->file($filename);

      if(!$file) continue;

      $counter++;

      try {
        $file->update(array('sort' => $counter), app::$language);
      } catch(Exception $e) {

      }

    }

    return response::success('success');

  }

  public function delete($id) {

    $filename = get('filename');
    $file     = $this->file($id, $filename);

    if(!$file) {
      return response::error(l('files.error.missing.file'));
    }

    try {
      $file->delete();
      return response::success('success');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  protected function page($id) {
    return empty($id) ? site() : page($id);
  }

  protected function file($id, $filename) {
    if($page = $this->page($id)) {
      return $page->file($filename);
    } else {
      return false;
    }
  }

}