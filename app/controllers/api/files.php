<?php

class FilesController extends Controller {

  public function upload($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesAdd())
      return response::error('You are not allowed to upload new files');

    $filename  = $blueprint->files()->sanitize() ? '{safeFilename}' : '{filename}';

    $upload = new Upload($page->root() . DS . $filename, array(
      'overwrite' => true,
      'accept'    => function($file) {

        $callback = kirby()->option('panel.upload.accept');

        if(is_callable($callback)) {
          return call($callback, $file);
        } else {
          return true;
        }

      }
    ));

    if($file = $upload->file()) {
      try {
        $this->checkUpload($file, $blueprint);
        return response::success('success');
      } catch(Exception $e) {
        $file->delete();
        return response::error($e->getMessage());
      }
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function replace($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesReplace())
      return response::error('You are not allowed to replace files');

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

    if($file = $upload->file()) {
      try {
        $this->checkUpload($file);
        return response::success('success');
      } catch(Exception $e) {
        $file->delete();
        return response::error($e->getMessage());
      }
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function rename($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesSave()) {
      return response::error('You are not allowed to rename files');

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

  public function update($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesSave()) {
      return response::error('You are not allowed to update files');

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
    $fields    = $blueprint->files()->fields($page);

    // trigger the validation
    $form = new Form($fields->toArray());
    $form->validate();

    // fetch the form data
    $data = filedata::createByInput($file, $form->serialize());

    // stop at invalid fields
    if(!$form->isValid()) {
      return response::error(l('files.show.error.form'), 400, array(
        'fields' => $form->fields()->filterBy('error', true)->pluck('name')
      ));
    }

    try {
      $file->update($data);
      return response::success('success', array(
        'data' => $data
      ));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function sort($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesSave()) {
      return response::error('You are not allowed to sort files');

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
        $file->update(array('sort' => $counter));
      } catch(Exception $e) {

      }

    }

    return response::success('success');

  }

  public function delete($id = null) {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canFilesDelete()) {
      return response::error('You are not allowed to delete files');

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

  protected function checkUpload($file, $blueprint) {

    if(strtolower($file->extension()) == kirby()->option('content.file.extension', 'txt')) {
      throw new Exception('Content files cannot be uploaded');
    } else if(strtolower($file->extension()) == 'php' or
              in_array($file->mime(), f::$mimes['php'])) {
      throw new Exception('PHP files cannot be uploaded');
    } else if(strtolower($file->extension()) == 'html' or
              $file->mime() == 'text/html') {
      throw new Exception('HTML files cannot be uploaded');
    } else if(strtolower($file->extension()) == 'exe' or
              $file->mime() == 'application/x-msdownload') {
      throw new Exception('EXE files cannot be uploaded');
    } else if(strtolower($file->filename()) == '.htaccess') {
      throw new Exception('htaccess files cannot be uploaded');
    } else if(str::startsWith($file->filename(), '.')) {
      throw new Exception('Invisible files cannot be uploaded');

    // Files blueprint option 'type'
    } else if(count($blueprint->files()->type()) > 0 and
              !in_array($file->type(), $blueprint->files()->type())) {
      throw new Exception('Page only allows: '.implode(', ', $blueprint->files()->type()));

    // Files blueprint option 'size'
    } else if($blueprint->files()->size() and
              f::size($file->root()) > $blueprint->files()->size()) {
      throw new Exception('Page only allows file size of '.f::niceSize($blueprint->files()->size()));

    // Files blueprint option 'width'
    } else if($file->type() == 'image' and
              $blueprint->files()->width() and
              $file->width() > $blueprint->files()->width()) {
      throw new Exception('Page only allows image width of '.$blueprint->files()->width().'px');

    // Files blueprint option 'height'
    } else if($file->type() == 'image' and
              $blueprint->files()->height() and
              $file->height() > $blueprint->files()->height()) {
      throw new Exception('Page only allows image height of '.$blueprint->files()->height().'px');
    }

  }

}
