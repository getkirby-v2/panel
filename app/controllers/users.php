<?php 

class UsersController extends Controller {
  
  public function index() {  
    return response::json(user::all());        
  }

  public function create() {

    try {
      $user = user::create(get());
      return response::json((array)$user);      
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  public function show($username) {

    $user = user::find($username);

    if(!$user) {
      return response::error('The user could not be found');
    } else {
      return response::json((array)$user);      
    }

  }

  public function delete($username) {

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

}