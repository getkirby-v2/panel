<?php 

class SiteController extends Controller {

  public function metatags() {

    $site      = app::$site;
    $blueprint = blueprint($site);
    $content   = array();

    foreach($blueprint->fields() as $key => $field) {
      $content[] = array(
        'key'   => $field['label'], 
        'value' => (string)$site->content()->get($key)
      );
    }

    return response::json($content);

  }

}