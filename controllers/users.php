<?php 

return array(

  'index' => function() use($site) {
    echo response::json(user::all());
  },

  'create' => function() {

    try {
      $user = user::create(get());
      return response::json((array)$user);      
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  },

  'show' => function($username) {

    $user = user::find($username);

    if(!$user) {
      return response::error('The user could not be found');
    } else {
      return response::json((array)$user);      
    }

  },

  'delete' => function($username) {
    
    $user = user::find($username);

    if(!$user) {
      return response::error('The user could not be found');
    } 

    if(!$user->delete()) {
      return response::error('The user could not be deleted');
    } else {
      return response::success('The user has been deleted');
    }

  }

);