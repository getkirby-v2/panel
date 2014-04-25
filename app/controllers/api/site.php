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

  public function health() {

    $problems = array();

    if(!is_writable(c::get('root.accounts'))) {
      $problems[] = l('site.health.error.accounts');
    }

    if(!is_dir(c::get('root.blueprints'))) {
      $problems[] = l('site.health.error.blueprints');
    }

    $folder = new Folder(c::get('root.content'));
    if(!$folder->isWritable(true)) {
      $problems[] = l('site.health.error.content');
    }

    if(!empty($problems)) {
      return response::error(l('site.health.error'), 400, $problems);
    } else {
      return response::success(l('site.health.success'));
    }


  }

}