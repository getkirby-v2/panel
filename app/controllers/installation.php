<?php 

class InstallationController extends Controller {

  public function index() {
    return layout('installation');
  }

  public function run() {
    
    try {
      app::$site->users()->create(get());    
      return response::success('The first user has been created');      
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }

  }

}