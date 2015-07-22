<?php

namespace Blueprint;

use Collection;

class Fields extends Collection {

  public function __construct($fields = array(), $page = null) {

    if(empty($fields) or !is_array($fields)) $fields = array();

    foreach($fields as $name => $field) {
      if($field['type'] == 'snippet'){
          // Import blueprint snippets
          $snippets = is_array($field['file']) ? $field['file'] : array($field['file']);
          foreach($snippets AS $snippet){
              foreach(\blueprint::find('snippets' . DS . $snippet)->fields($page) AS $file){
                  $this->append($file->name, $file);
              }
          }
          // Handle next field
          continue;
      }
      
      // add the name to the field
      $field['name'] = $name;
      $field['page'] = $page;

      // creat the field object
      $field = new Field($field);

      // append it to the collection
      $this->append($name, $field);

    }

  }

  public function toArray($callback = null) {
    $result = array();
    foreach($this->data as $field) {
      $result[$field->name()] = $field->toArray();
    }
    return $result;
  }

}
