<?php

class AppController extends Controller {

  public function health($check = null) {

    $checks = array('accounts', 'thumbs', 'blueprints', 'content', 'avatars');

    if(is_null($check)) {

      $problems = array();

      foreach($checks as $c) {
        $method = 'check' . $c;

        if(!$this->$method()) {
          $problems[] = l('app.health.error.' . $c);
        }

      }

      if(!empty($problems)) {
        return response::error(l('app.health.error'), 400, $problems);
      } else {
        return response::success(l('app.health.success'));
      }

    } else {

      $method = 'check' . $check;
      if(!$this->$method()) {
        return response::error(l('app.health.error.' . $check));
      } else {
        return response::succes(l('app.health.success'));
      }

    }

  }

  protected function checkAccounts() {
    return is_writable(c::get('root.accounts'));
  }

  protected function checkThumbs() {
    return is_writable(thumb::$defaults['root']);
  }

  protected function checkBlueprints() {
    return is_dir(c::get('root.blueprints'));
  }

  protected function checkContent() {
    $folder = new Folder(c::get('root.content'));
    return $folder->isWritable(true);
  }

  protected function checkAvatars() {
    return is_writable(c::get('root') . DS . 'assets' . DS . 'avatars');
  }

}