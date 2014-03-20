<?php 

class FilesController extends Controller {

  public function show() {

    $page = $this->page(get('uri'));
    $file = $page->file(get('filename'));

    if(!$file) {
      return response::error('No such file');
    } else {
      return response::json(fileResponse($file));
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

  public function update() {

    $page = $this->page(get('uri'));
    $file = $page->file(get('filename'));

    if(!$file) {
      return response::error('The file could not be found');
    }

    $meta   = get('meta'); 
    $fields = array_keys($page->blueprint()->filefields());
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
      $file->update($data);
      return response::success('The file has been updated', array(
        'file' => $store,
        'data' => $data
      ));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function delete() {

    $page = $this->page(get('uri'));
    $file = $page->file(get('filename'));

    if(!$file) {
      return response::error('No such file');
    }

    try {
      $file->delete();
      return response::success('The file has been removed');
    } catch(Exception $e) {
      return response::error('The file could not be removed');
    }
      
  }

  public function fields() {

    $page = $this->page(get('uri'));

    if(!$page) return '';

    $root = c::get('root.panel') . DS . 'fields';
    $html = array();

    foreach($page->blueprint()->filefields() as $name => $field) {

      $field['name'] = 'file.meta.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      $html[] = f::load($file, $field);

    }

    return implode($html);

  }

  protected function page($uri) {
    return !empty($uri) ? app::$site->find($uri) : app::$site;
  }

}