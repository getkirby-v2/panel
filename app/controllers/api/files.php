<?php

class FilesController extends Controller {

  public function show() {

    if($file = $this->file(get('uri'), get('filename'))) {
      return response::json(fileResponse($file));
    } else {
      return response::error('No such file');
    }

  }

  public function upload() {

    $page   = $this->page(get('uri'));
    $upload = new Upload($page->root() . DS . '{safeFilename}');

    if($upload->file()) {
      return response::success('The file has been uploaded');
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
          throw new Error('The uploaded file must have the same file type');
        }
      }
    ));

    if($upload->file()) {
      return response::success('The file has been replaced');
    } else {
      return response::error($upload->error()->getMessage());
    }

  }

  public function rename() {

    $file = $this->file(get('uri'), get('filename'));

    if(!$file) {
      return response::error('The file could not be found');
    }

    try {
      $filename = $file->rename(get('name'));
      return response::success('The file has been renamed', array(
        'filename' => $filename
      ));
    } catch(Exception $e) {
      return response::error('The file could not be renamed');
    }

  }

  public function update() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page could not be found');
    }

    $file = $page->file(get('filename'));

    if(!$file) {
      return response::error('The file could not be found');
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
      return response::success('The file has been updated', array(
        'data' => $data
      ));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function delete() {

    $file = $this->file(get('uri'), get('filename'));

    if(!$file) {
      return response::error('No such file');
    }

    try {
      $file->delete();
      return response::success('The file has been removed');
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
      $html[] = html::tag($field['type'] . 'field', '', array('model' => 'file.meta.' . $name, 'options' => 'fields.' . $name));
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