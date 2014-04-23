<?php 

class HelpersController extends Controller {

  public function slug() {
    return str::slug(get('string'));
  }

}