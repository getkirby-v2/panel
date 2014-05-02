<?php

class FilesController extends Controller {

  public function show() {

    if($file = $this->file(get('uri'), get('filename'))) {
      return response::json(api::file($file));
    } else {
      return response::error(l('files.show.error'));
    }

  }

  public function upload() {

    $page   = $this->page(get('uri'));
    $upload = new Upload($page->root() . DS . '{safeFilename}', array(
      'overwrite' => true
    ));

    if($upload->file()) {
      return response::success(l('files.upload.success'));
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function replace() {

    $file   = $this->file(get('uri'), get('filename'));
    $upload = new Upload($file->root(), array(
      'overwrite' => true,
      'accept' => function($upload) use($file) {
        if($upload->mime() != $file->mime()) {
          throw new Error(l('files.replace.error.type'));
        }
      }
    ));

    if($upload->file()) {
      return response::success(l('files.replace.success'));
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function rename() {

    $file = $this->file(get('uri'), get('filename'));

    if(!$file) {
      return response::error(l('files.rename.error.missing'));
    }

    try {
      $filename = $file->rename(get('name'));
      return response::success(l('files.rename.error'), array(
        'filename' => $filename
      ));
    } catch(Exception $e) {
      return response::error(l('files.rename.success'));
    }

  }

  public function update() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error(l('files.update.error.page'));
    }

    $file = $page->file(get('filename'));

    if(!$file) {
      return response::error(l('files.update.error.missing'));
    }

    $meta   = get('meta');
    $fields = array_keys($page->blueprint()->files()->fields());
    $data   = array();

    foreach($fields as $key) {
      $value = a::get($meta, $key);
      if(is_array($value)) {
        $data[$key] = implode(', ', $value);
      } else {
        $data[$key] = $value;
      }
    }

    try {
      $file->update($data, app::$language);
      return response::success(l('files.update.success'), array(
        'data' => $data
      ));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function delete() {

    $file = $this->file(get('uri'), get('filename'));

    if(!$file) {
      return response::error(l('files.delete.error.missing'));
    }

    try {
      $file->delete();
      return response::success(l('files.delete.success'));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function form() {

    $page = $this->page(get('uri'));
    $html = array();

    if(!$page) return '';

    foreach($page->blueprint()->files()->fields() as $name => $field) {
      if(get('field') and $name !== get('field')) continue;
      $html[] = html::tag($field['type'] . 'field', '', array(
        'model'   => 'file.meta.' . $name,
        'options' => 'fields.' . $name
      ));
    }

    return implode($html);

  }

  public function fields() {

    $page = $this->page(get('uri'));

    if(!$page) return '';

    die(response::json($page->blueprint()->files()->fields()));

  }

  protected function page($uri) {
    return empty($uri) ? app::$site : app::$site->children()->find($uri);
  }

  protected function file($uri, $filename) {
    if($page = $this->page($uri)) {
      return $page->file($filename);
    } else {
      return false;
    }
  }

}