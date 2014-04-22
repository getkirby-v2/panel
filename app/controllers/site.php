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

  public function health() {

    $problems = array();

    if(!is_writable(c::get('root.accounts'))) {
      $problems[] = 'site/accounts is not writable';
    }

    if(!is_dir(c::get('root.blueprints'))) {
      $problems[] = 'Please add a site/blueprints folder';
    }

    $folder = new Folder(c::get('root.content'));
    if(!$folder->isWritable(true)) {
      $problems[] = 'The content folder and all contained files and folders must be writable.';
    }

    if(!empty($problems)) {
      return response::error('There are some issues!', 400, $problems);      
    } else {
      return response::success('Everything is fine!');      
    }


  }

}