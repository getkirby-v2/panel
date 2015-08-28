<?php

namespace Kirby\Panel;

use Folder;

class Installer {

  public function isCompleted() {
    return site()->users()->count() > 0;
  }

  public function problems() {

    $checks   = array('accounts', 'thumbs', 'blueprints', 'content', 'avatars');
    $problems = array();

    foreach($checks as $c) {
      $method = 'check' . $c;

      if(!$this->$method()) {
        $problems[] = l('installation.check.error.' . $c);
      }

    }
    
    return empty($problems) ? false : $problems;

  }

  protected function checkAccounts() {
    return is_writable(kirby()->roots()->accounts());
  }

  protected function checkThumbs() {
    return is_writable(kirby()->roots()->thumbs());
  }

  protected function checkBlueprints() {
    return is_dir(kirby()->roots()->blueprints());
  }

  protected function checkContent() {
    $folder = new Folder(kirby()->roots()->content());
    return $folder->isWritable(true);
  }

  protected function checkAvatars() {
    return is_writable(kirby()->roots()->avatars());
  }

}