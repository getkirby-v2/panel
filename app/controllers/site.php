<?php 

class SiteController extends Controller {

  public function metatags() {

    $site    = app::$site;
    $content = array();

    foreach($site->blueprint()->fields() as $key => $field) {
      $content[] = array(
        'key'   => $field['label'], 
        'value' => (string)$site->content()->get($key)
      );
    }

    return response::json($content);

  }

}