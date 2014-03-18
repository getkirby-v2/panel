<?php 

return array(

  'fields' => function() use($site) {

    $page = get('uri') ? $site->find(get('uri')) : $site;

    if(!$page) return '';

    $blueprint = blueprint($page);

    $root = c::get('root.panel') . DS . 'fields';

    foreach($blueprint->fields as $name => $field) {
      
      if(get('field') and $name !== get('field')) continue;

      $field['name'] = 'page.content.' . $name;

      $file = $root . DS . $field['type'] . DS . 'html.php';

      if(!file_exists($file)) continue;

      f::load($file, $field);

    }

  }

);