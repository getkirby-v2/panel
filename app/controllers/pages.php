<?php 

class PagesController extends Controller {

  public function show() {

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;

    if(!$page) {
      return response::error('The page could not be found');
    }

    return response::json(pageResponse($page));

  }

  public function create() {

    $site     = app::$site;
    $parent   = get('parent') ? $site->find(get('parent')) : $site;
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

    $page = get('uri') ? app::$site->find(get('uri')) : app::$site;

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

      $page->update($data);
  
      return response::success('The page has been updated', array(
        'file' => $page->content()->root(),
        'data' => $data
      ));

    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  public function delete() {

    $site = app::$site;
    $page = fetchPage($site, get('uri'));

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

    $page = get('uri') ? app::$site->find(get('uri')) : app::$site;
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

    $page = fetchPage(app::$site, get('uri'));

    if(!$page) return response::error('The page could not be found');

    try {
      $page->hide();
      return response::success('The pages has been hidden');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function templates() {

    $site  = app::$site;
    $page  = get('uri') ? $site->find(get('uri')) : $site;
    $pages = $page->blueprint()->pages();

    return response::json(array_map(function($item) {
      return array(
        'title' => $item->title(),
        'name'  => $item->name()
      );
    }, $pages['template']));

  }

  public function changeURL() {

    $site = app::$site;
    $page = fetchPage($site, get('uri'));
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

    $site = app::$site;
    $page = get('uri') ? $site->find(get('uri')) : $site;

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

}