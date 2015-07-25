<?php

class Controller extends Obj {

  public function redirect() {    

    $url = call('purl', func_get_args());

    if(r::ajax()) {

      // set the username of the current user
      if($user = site()->user()) {
        header('Panel-User: ' . $user->username());      
      }

      die(response::json(array('url' => $url)));

    } else {
      go($url);            
    }

  }

}