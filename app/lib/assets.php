<?php

class Assets {

  static public function css() {
    return css(panel()->urls()->css() . '/panel.css?v=' . panel()->version());
  }

  static public function js() {

    $files = array(
      // vendors
      'vendors/dropzone.js',
      'vendors/jquery.js',
      'vendors/jquery.hotkeys.js',
      'vendors/jquery.ui.js',
      'vendors/jquery.ui.touch.js',
      'vendors/jquery.autocomplete.js',
      'vendors/jquery.editorHelpers.js',
      'vendors/jquery.passwordsuggestion.js',

      // components
      'components/shortcuts.js',
      'components/message.js',
      'components/delay.js',
      'components/content.js',
      'components/modal.js',
      'components/breadcrumb.js',
      'components/dropdown.js',
      'components/dropzone.js',
      'components/form.js',
      'components/sidebar.js',

    );

    return static::combine('js', $files, false);

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
      if($compress) $content = static::compress($type, $content);
      f::write($root . DS . 'panel.' . $type, $content);
    }

    if($cache->exists()) {
      return $type(panel()->urls()->$type() . '/panel.' . $type . '?v=' . panel()->version());
    }

    return $type(array_map(function($item) use($type) {
      return 'panel/assets/' . $type . '/' . $item;
    }, $files));

  }

  static public function compress($type, $output) {

    if($type == 'css') {
      $output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);
      $output = trim(str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $output));
    } else {
      $output = \JShrink\Minifier::minify($output, array('flaggedComments' => false));
    }

    return $output;      

  }

}
