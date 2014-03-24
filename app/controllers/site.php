<?php 

class SiteController extends Controller {

  public function metatags() {

    $site    = app::$site;
    $content = array();

    foreach($site->blueprint()->fields() as $key => $field) {
      $content[] = array(
        'key'   => $field['label'], 
        'value' => (string)$site->content(app::$language)->get($key)
      );
    }

    return response::json($content);

  }

  public function languages() {

    $site = app::$site;

    if(!$site->multilang()) return response::error('This is a single-language site');

    $languages = $site->languages()->map(function($lang) {
      return array(
        'code'    => $lang->code(),
        'label'   => $lang->name(),
        'default' => $lang->default(),
      );
    });

    return response::json(array_values($languages->toArray()));

  }

}