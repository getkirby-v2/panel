<?php 

class FormController extends Controller {

  public function fields() {

    $site = app::$site;

    $page = get('uri') ? $site->find(get('uri')) : $site;

    if(!$page) return '';

    $blueprint = blueprint($page);

    $root = c::get('root.panel') . DS . 'fields';
    $html = array();

    foreach($blueprint->fields as $name => $field) {

      if(get('field') and $name !== get('field')) continue;

      $field['name'] = 'page.content.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      $html[] = f::load($file, $field);

    }

    return implode($html);

  }

}