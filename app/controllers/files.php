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
    $upload = new Upload;
    $upload->to($page->root() . DS . '{safeFilename}');
    $upload->success(function($file) {      
      return response::success('The file has been uploaded');
    });      
    $upload->error(function($exception) {
      return response::error($exception->getMessage());
    });

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

  public function fields() {

    $page = $this->page(get('uri'));

    if(!$page) return '';

    $root = c::get('root.panel') . DS . 'fields';
    $html = array();

    foreach($page->blueprint()->files()->fields() as $name => $field) {

      $field['name'] = 'file.meta.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      $html[] = f::load($file, $field);

    }

    return implode($html);

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