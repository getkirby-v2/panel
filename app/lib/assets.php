<?php

class Assets {

  static public function css() {

    $files = array(
      'app.css',
      'fontawesome.css',
      'autocomplete.css',
      'hacks.css'
    );

    return static::combine('css', $files, true);

  }

  static public function js() {

    $files = array(
      'lib/handlebars.js',
      'lib/routie.js',
      'lib/dropzone.js',
      'lib/jquery.js',
      'lib/jquery.hotkeys.js',
      'lib/jquery.ui.js',
      'lib/jquery.ui.touch.js',
      'lib/jquery.autocomplete.js',
      'lib/kirby.js',
      'controllers/users.js',
      'controllers/pages.js',
      'controllers/metatags.js',
      'controllers/dashboard.js',
      'controllers/subpages.js',
      'controllers/files.js',
      'controllers/errors.js',
      'controllers/editor.js',
      'models.js',
      'routes.js',
      'setup.js',
    );

    return static::combine('js', $files);

  }

  static public function combine($type, $files, $compress = false) {

    $root  = panel::instance()->roots()->assets() . DS . $type;
    $cache = new Media($root . DS . 'panel.' . $type);
    $media = new Collection(array_map(function($file) use($root) {
      return new Media($root . DS . str_replace('/', DS, $file));
    }, $files));

    // get the max modification date
    $modified = max($media->pluck('modified'));

    if(is_writable($root) and (!$cache->exists() or $cache->modified() < $modified)) {
      $cache->remove();
      $content = '';
      foreach($media as $asset) $content .= $asset->read() . PHP_EOL;
      if($compress) $content = static::compress($content);
      f::write($root . DS . 'panel.' . $type, $content);
    }

    if($cache->exists()) {
      return $type(panel()->urls()->$type() . '/panel.' . $type);
    }

    return $type(array_map(function($item) use($type) {
      return 'panel/assets/' . $type . '/' . $item;
    }, $files));

  }

  static public function compress($output) {
    $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
    $output = trim(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $output));
    return $output;
  }

}