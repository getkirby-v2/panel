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
    $dir      = $parent->root() . DS . $slug;
    $file     = $dir . DS . $template . '.' . c::get('content.file.extension', 'txt');

    if(empty($title) or empty($slug)) {
      return response::error('The title is missing');
    } 

    if(empty($template)) {
      return response::error('The template is missing');
    }

    if(is_dir($dir)) {
      return response::error('The page already exists');
    }

    if(!dir::make($dir)) {
      return response::error('The page could not be created');
    }

    if(!data::write($file, array('title' => $title))) {
      return response::error('The data for this page could not be saved');
    }        

    return response::success('The page has been created', array(
      'uid' => $slug,
      'uri' => $parent->uri() . '/' . $slug
    ));

  }

  public function update() {

    $site = app::$site;
    $page = fetchPage($site, get('uri'));

    if(!$page) {
      return response::error('The page does not exist');
    }

    $blueprint = blueprint($page);
    $fields    = array_keys($blueprint->fields());
    $data      = array();

    foreach($fields as $key) {

      $value = get($key);

      if(is_array($value)) {
        $data[$key] = implode(', ', $value);
      } else {
        $data[$key] = $value;
      }

    }

    if(!data::write($page->content()->root(), $data, 'kd')) {
      return response::error('The data could not be safed');
    }

    return response::success('The page has been updated', array(
      'file' => $page->content()->root(),
      'data' => $data
    ));

  }

  public function delete() {

    $site = app::$site;
    $page = fetchPage($site, get('uri'));

    if(!$page) {
      return response::error('The page does not exist');
    }

    if($page->isErrorPage()) {
      return response::error('The error page cannot be deleted');
    }

    if($page->isHomePage()) {
      return response::error('The home page cannot be deleted');
    }

    if($page->children()->count() > 0) {
      return response::error('This page still has subpages and cannot be deleted');
    }    

    if(!dir::remove($page->root())) {
      return response::error('The page could not be deleted');
    }

    return response::success('The page has been removed');

  }

  public function templates() {

    $site       = app::$site;
    $page       = get('uri') ? $site->find(get('uri')) : $site;
    $blueprint  = blueprint($page);

    if(is_string($blueprint->subpages)) {

      $blueprint  = blueprint(c::get('root.blueprints') . DS . $blueprint->subpages . '.php');
      $blueprints = array(
        array(
          'title' => $blueprint->title(),
          'name'  => $blueprint->name(),
        )
      );

    } else if(is_array($blueprint->subpages)) {

      $blueprints = array();

      foreach($blueprint->subpages as $subpageBlueprint) {
        $blueprint    = blueprint(c::get('root.blueprints') . DS . $subpageBlueprint . '.php');
        $blueprints[] = array(
          'title' => $blueprint->title(),
          'name'  => $blueprint->name(),
        );
      }

    } else {

      $blueprints = array_values(array_map(function($item) {
        if(f::extension($item) == 'php') {
          $blueprint = blueprint(c::get('root.blueprints') . DS . $item);

          return array(
            'title' => $blueprint->title(),
            'name'  => $blueprint->name(),
          );

        } else {
          return false;        
        }

      }, dir::read(c::get('root.blueprints'))));

    }

    return response::json($blueprints);

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

}