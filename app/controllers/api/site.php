<?php

class SiteController extends Controller {

  public function metatags() {

    $site    = app::$site;
    $content = array();

    if($blueprint = $site->blueprint()) {
      foreach($blueprint->fields() as $key => $field) {
        $content[] = array(
          'key'   => $field['label'],
          'value' => (string)$site->content(app::$language)->get($key)
        );
      }
    }

    return response::json($content);

  }

  public function languages() {

    $site = app::$site;

    if(!$site->multilang()) return response::error(l('site.languages.error'));

    $languages = $site->languages()->map(function($lang) {
      return array(
        'code'    => $lang->code(),
        'label'   => strtoupper($lang->code()),
        'default' => $lang->default(),
      );
    });

    return response::json(array_values($languages->toArray()));

  }

}