<?php

class HelpersController extends Kirby\Panel\Controller {

  public function slug() {
    return str::slug(get('string'));
  }

  public function autocomplete($method) {
    try {
      $autocomplete = new Kirby\Panel\Autocomplete(panel(), $method, get());
      return response::json($autocomplete->result());      
    } catch(Exception $e) {
      return response::json(array());
    }
  }

}