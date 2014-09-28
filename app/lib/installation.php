<?php

class Installation {

  static public function old() {

    $panel = kirby()->roots()->site() . DS . 'panel';

    return (is_dir($panel) or
            is_dir($panel . DS . 'blueprints') or
            is_dir($panel . DS . 'accounts')) ? true : false;

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
    return is_writable(kirby()->roots()->accounts());
  }

  static protected function checkThumbs() {
    return is_writable(kirby()->roots()->thumbs());
  }

  static protected function checkBlueprints() {
    return is_dir(kirby()->roots()->blueprints());
  }

  static protected function checkContent() {
    $folder = new Folder(kirby()->roots()->content());
    return $folder->isWritable(true);
  }

  static protected function checkAvatars() {
    return is_writable(kirby()->roots()->avatars());
  }

}