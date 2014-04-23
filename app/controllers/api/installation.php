<?php 

class InstallationController extends Controller {

  public function index() {
    $this->lock();
    return layout('installation');
  }

  public function run() {
    $this->lock();    
    try {
      app::$site->users()->create(get());    
      return response::success('The first user has been created');      
    } catch(Exception $e) {
      return response::error($e->getMessage());      
    }
  }

  protected function lock() {
    if(app::$site->users()->count() > 0) {
      go('panel/login');        
    }
  }

}