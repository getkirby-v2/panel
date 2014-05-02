<?php

class PagesController extends Controller {

  public function show() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error(l('pages.show.error'));
    }

    return response::json(api::page($page));

  }

  public function create() {

    $parent   = $this->page(get('parent'));
    $title    = get('title');
    $template = get('template');
    $slug     = str::slug($title);

    if(empty($title)) {
      return response::error(l('pages.add.error.title'));
    }

    if(empty($template)) {
      return response::error(l('pages.add.error.template'));
    }

    try {

      $data = pagedata::createByBlueprint($template, array(
        'title' => $title
      ));

      $parent->children()->create($slug, $template, $data);

      return response::success(l('pages.add.success'), array(
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
      return response::error(l('pages.update.error.missing'));
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

      return response::success(l('pages.update.success'), array(
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
      return response::error(l('pages.delete.error.missing'));
    }

    try {
      $page->delete();
      return response::success(l('pages.delete.success'));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function sort() {

    $page = $this->page(get('uri'));
    $uids = get('uids');
    $n    = 1;

    // check for the numbering mode for subpages
    $num = $page->blueprint()->num();

    foreach($uids as $uid) {
      try {

        $child = $page->children()->find($uid);

        switch($num->mode()) {
          case 'zero':
            $n = 0;
            break;
          case 'date':
            $field  = $num->field() ? $num->field() : 'date';
            $format = $num->format() ? $num->format() : 'Ymd';
            $n      = date($format, strtotime($child->$field()));
            break;
        }

        $child->sort($n);
        $n++;
      } catch(Exception $e) {

      }
    }

    return response::success(l('pages.sort.success'));

  }

  public function hide() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error(l('pages.hide.error.missing'));
    }

    try {
      $page->hide();
      return response::success(l('pages.hide.success'));
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function templates() {

    $page = $this->page(get('uri'));

    if(!$page) {
      return response::error(l('pages.templates.error.missing'));
    }

    $pages = $page->blueprint()->pages();

    if(!$page->blueprint()->pages()) {
      return response::error(l('pages.templates.error.nosubpages'));
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
      return response::error(l('pages.url.error.missing'));
    }

    if($page->uid() === $uid) {
      return response::success(l('pages.url.idle'), array(
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
      return response::error(l('pages.url.error.exists'));
    }

    if(!dir::move($page->root(), $root)) {
      return response::error(l('pages.url.error.move'));
    }

    return response::success(l('pages.url.success'), array(
      'uid' => $uid,
      'uri' => $page->parent()->uri() . '/' . $uid
    ));

  }

  public function form() {

    $page = $this->page(get('uri'));
    $html = array();

    if(!$page) return '';

    if($blueprint = $page->blueprint()) {
      $fields = $blueprint->fields();
    } else {
      $fields = array();

      foreach($page->content()->fields() as $field) {
        $fields[$field] = array(
          'type' => 'textarea'
        );
      }

    }

    foreach($fields as $name => $field) {

      if(get('field') and $name !== get('field')) continue;

      if($name == 'title') {
        $field['type'] = 'title';
      }

      $html[] = html::tag($field['type'] . 'field', '', array(
        'model'   => 'page.content.' . $name,
        'options' => 'fields.' . $name
      ));

    }

    return view('pages/form', array(
      'fields' => implode($html)
    ));

  }

  public function fields() {

    $page = $this->page(get('uri'));

    if(!$page) return '';

    if($blueprint = $page->blueprint()) {
      $fields = $blueprint->fields();
    } else {
      $fields = array();
      foreach($page->content()->fields() as $field) {
        $fields[$field] = array(
          'label' => ucfirst($field),
          'type'  => 'text'
        );
      }
    }

    die(response::json($fields));

  }

  protected function page($uri) {
    return empty($uri) ? app::$site : app::$site->children()->find($uri);
  }

}