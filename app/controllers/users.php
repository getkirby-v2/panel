<?php 

class UsersController extends Controller {
  
  public function index() {  

    $ctrl  = $this;    
    $users = $this->users()->map(function($user) use($ctrl) {
      return $ctrl->userToArray($user);
    });

    return response::json($users->toArray());        

  }

  public function create() {

    try {
      $user = $this->users()->create(get());    
      return response::json($this->userToArray($user));      
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  public function show($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error('The user could not be found');
    } else {
      return response::json($this->userToArray($user));      
    }

  }

  public function delete($username) {

    $user = $this->user($username);

    if(!$user) {
      return response::error('The user could not be found');
    } 

    try {
      $user->delete();
      return response::success('The user has been deleted');
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

  protected function users() {
    return app::$site->users();
  }

  protected function user($username) {
    return app::$site->users()->find($username);
  }

  protected function userToArray($user) {

    return array(
      'username' => $user->username,
      'email'    => $user->email,
      'avatar'   => $user->avatar() ? $user->avatar()->url() : false
    );

  }

}