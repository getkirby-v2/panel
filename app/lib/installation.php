<?php

class Installation {

  static public function old() {

    $panel = c::get('root.site') . DS . 'panel';

    return (is_dir($panel) or
            is_dir($panel . DS . 'blueprints') or
            is_dir($panel . DS . 'accounts')) ? true : false;

  }

  static public function migration() {





  }

  static public function check() {

    $checks   = array('accounts', 'thumbs', 'blueprints', 'content', 'avatars');
    $problems = array();

    foreach($checks as $c) {
      $method = 'check' . $c;

      if(!static::$method()) {
        $problems[] = l('installation.check.error.' . $c);
      }

    }

    return empty($problems) ? false : $problems;

  }

  static protected function checkAccounts() {
    return is_writable(c::get('root.accounts'));
  }

  static protected function checkThumbs() {
    return is_writable(thumb::$defaults['root']);
  }

  static protected function checkBlueprints() {
    return is_dir(c::get('root.site') . DS . 'blueprints');
  }

  static protected function checkContent() {
    $folder = new Folder(c::get('root.content'));
    return $folder->isWritable(true);
  }

  static protected function checkAvatars() {
    return is_writable(c::get('root') . DS . 'assets' . DS . 'avatars');
  }

}