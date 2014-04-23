<?php

class PageData {

  static public function defaultValue($field) {

    $default = a::get($field, 'default');

    if(empty($default)) {
      return '';
    } else if(is_string($default)) {
      return $default;
    } else {
      $type = a::get($default, 'type');

      switch($type) {
        case 'date':
          $format = a::get($default, 'format', 'Y-m-d');
          return date($format);
          break;
        case 'datetime':
          $format = a::get($default, 'format', 'Y-m-d H:i:s');
          return date($format);
          break;
        case 'user':
          $user = isset($default['user']) ? site()->users()->find($default['user']) : site()->user();
          if(!$user) return '';
          return (isset($default['field']) and $default['field'] != 'password') ? $user->{$default['field']}() : $user->username();
          break;
        default:
          return '';
          break;
      }

    }

  }

  static public function createByBlueprint($blueprint, $input = array()) {

    $bp = new Blueprint(c::get('root.blueprints') . DS . $blueprint . '.php');

    if(!$bp) return $input;

    $data = array();

    foreach($bp->fields() as $key => $field) {
      $data[$key] = static::defaultValue($field);
    }

    return array_merge($data, $input);

  }

}
