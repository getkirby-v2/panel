<?php

class HelpersController extends Kirby\Panel\Controller {

  public function slug() {
    return $this->json(array(
      'slug' => str::slug(get('string'))
    ));
  }

  public function autocomplete($method) {
    
    try {
      $auto   = new Kirby\Panel\Autocomplete(panel(), $method, get());
      $result = $auto->result();
    } catch(Exception $e) {
      $result = array();
    }

    return $this->json(array(
      'data' => $result
    ));

  }

}