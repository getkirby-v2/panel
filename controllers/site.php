<?php 

return array(

  'metatags' => function() use($site) {

    $blueprint = blueprint($site);
    $content   = array();

    foreach($blueprint->fields() as $key => $field) {
      $content[] = array(
        'key'   => $field['label'], 
        'value' => (string)$site->content()->get($key)
      );
    }

    echo response::json($content);

  }

);