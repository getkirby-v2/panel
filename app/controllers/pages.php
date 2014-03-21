<?php 

class PagesController extends Controller {

  public function show() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page could not be found');
    }

    return response::json(pageResponse($page));

  }

  public function create() {

    $parent   = $this->page(get('parent'));
    $title    = get('title');
    $template = get('template');
    $slug     = str::slug($title);

    if(empty($title)) {
      return response::error('The title is missing');      
    }

    if(empty($template)) {
      return response::error('The template is missing');
    }

    try {
    
      $parent->children()->create($slug, $template, array(
        'title' => $title
      ));

      return response::success('The page has been created', array(
        'uid' => $slug,
        'uri' => $parent->uri() . '/' . $slug
      ));
    
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function update() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page does not exist');
    }

    $fields = array_keys($page->blueprint()->fields());
    $data   = array();

    foreach($fields as $key) {

      $value = get($key);

      if(is_array($value)) {
        $data[$key] = implode(', ', $value);
      } else {
        $data[$key] = $value;
      }

    }

    try {

      $page->update($data, app::$language);
  
      return response::success('The page has been updated', array(
        'file' => $page->content()->root(),
        'data' => $data
      ));

    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  public function delete() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page does not exist');
    }

    try {
      $page->delete();
      return response::success('The page has been removed');
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  public function sort() {

    $page = $this->page(get('uri'));
    $uids = get('uids');
    $num  = 1;

    foreach($uids as $uid) {        
      try {
        $child = $page->children()->find($uid);
        $child->sort($num);
        $num++;   
      } catch(Exception $e) {

      }
    }

    return response::success('The pages have been sorted');

  }

  public function hide() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page could not be found');
    }

    try {
      $page->hide();
      return response::success('The pages has been hidden');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function templates() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error('The page could not be found');
    }

    $pages = $page->blueprint()->pages();

    if(!$page->blueprint()->pages()) {
      return response::error('This page is not allowed to have subpages');
    }

    return response::json(array_map(function($item) {
      return array(
        'title' => $item->title(),
        'name'  => $item->name()
      );
    }, $pages->template()));

  }

  public function changeURL() {

    $page = $this->page(get('uri'));
    $uid  = str::slug(get('uid'));

    if(!$page) {
      return response::error('The page does not exist');
    }

    if($page->uid() === $uid) {
      return response::success('Nothing to change', array(
        'uid' => $page->uid(),
        'uri' => $page->uri()
      ));
    }

    if($page->visible()) {
      $dir = $page->num() . '-' . $uid;
    } else {
      $dir = $uid;
    }

    $root = dirname($page->root()) . DS . $dir;

    if(is_dir($root)) {
      return response::error('A page with the same appendix already exists');
    }

    if(!dir::move($page->root(), $root)) {
      return response::error('The appendix could not be changed');
    }

    return response::success('The appendix has been changed', array(
      'uid' => $uid,
      'uri' => $page->parent()->uri() . '/' . $uid
    ));


  }

  public function fields() {

    $page = $this->page(get('uri'));

    if(!$page) return '';

    $root = c::get('root.panel') . DS . 'fields';
    $html = array();

    foreach($page->blueprint()->fields() as $name => $field) {

      if(get('field') and $name !== get('field')) continue;

      $field['name'] = 'page.content.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      $html[] = f::load($file, $field);

    }

    return implode($html);

  }

  protected function page($uri) {
    return empty($uri) ? app::$site : app::$site->children()->find($uri);
  }

}