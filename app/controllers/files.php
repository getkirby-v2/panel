<?php 

class FilesController extends Controller {

  public function show() {

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;    
    $file = $page->files()->find(get('filename'));

    if(!$file) {
      return response::error('No such file');
    } else {
      return response::json(fileResponse($file));
    }

  }

  public function upload() {

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;    
   
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

    $site      = app::$site;
    $page      = get('uri') ? $site->find(get('uri')) : $site;    
    $file      = $page->files()->find(get('filename'));
    $blueprint = blueprint($page);
    $store     = $page->root() . DS . $file->filename() . '.' . c::get('content.file.extension', 'txt');

    if(!$file) {
      return response::error('No such file');
    } else {

      $meta   = get('meta'); 
      $fields = array_keys((array)@$blueprint->files['fields']);
      $data   = array();

      foreach($fields as $key) {

        $value = a::get($meta, $key);

        if(is_array($value)) {
          $data[$key] = implode(', ', $value);
        } else {
          $data[$key] = $value;
        }

      }

      if(!data::write($store, $data, 'kd')) {
        return response::error('The data could not be safed');
      }

      return response::success('The file has been updated', array(
        'file' => $store,
        'data' => $data
      ));

    }

  }

  public function delete() {

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;    
    $file = $page->files()->find(get('filename'));

    if(!$file) {
      return response::error('No such file');
    } else if(!f::remove($file->root())) {
      return response::error('The file could not be removed');
    } else {
      return response::success('The file has been removed');
    }

  }


  public function fields() {

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;

    if(!$page) return '';

    $blueprint = blueprint($page);

    $root = c::get('root.panel') . DS . 'fields';
    $html = array();

    if(
      !isset($blueprint->files) || 
      !isset($blueprint->files['fields']) || 
      !is_array($blueprint->files['fields'])
    ) return '';

    foreach($blueprint->files['fields'] as $name => $field) {

      $field['name'] = 'file.meta.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      $html[] = f::load($file, $field);

    }

    return implode($html);

  }

}