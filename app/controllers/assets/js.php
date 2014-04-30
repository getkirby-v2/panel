<?php

class JsController extends Controller {

  public function app() {

    $scripts = array(
      // app setup
      'panel/assets/js/apps/main.js',

      'panel/assets/js/routes/pages.js',
      'panel/assets/js/routes/children.js',
      'panel/assets/js/routes/files.js',
      'panel/assets/js/routes/users.js',

      // factories
      'panel/assets/js/factories/focus.js',
      'panel/assets/js/factories/http.js',
      'panel/assets/js/factories/reposition.js',
      'panel/assets/js/factories/field.js',

      // directives
      'panel/assets/js/directives/date.js',
      'panel/assets/js/directives/dropzone.js',
      'panel/assets/js/directives/editor.js',
      'panel/assets/js/directives/focus.js',
      'panel/assets/js/directives/field.js',
      'panel/assets/js/directives/tagbox.js',

      // controllers
      'panel/assets/js/controllers/app.js',
      'panel/assets/js/controllers/modal.js',

      'panel/assets/js/controllers/children/index.js',

      'panel/assets/js/controllers/files/delete.js',
      'panel/assets/js/controllers/files/edit.js',
      'panel/assets/js/controllers/files/index.js',
      'panel/assets/js/controllers/files/upload.js',

      'panel/assets/js/controllers/page/add.js',
      'panel/assets/js/controllers/page/changeUrl.js',
      'panel/assets/js/controllers/page/delete.js',
      'panel/assets/js/controllers/page/index.js',
      'panel/assets/js/controllers/page/publish.js',
      'panel/assets/js/controllers/page/metatags.js',

      'panel/assets/js/controllers/users/add.js',
      'panel/assets/js/controllers/users/delete.js',
      'panel/assets/js/controllers/users/edit.js',
      'panel/assets/js/controllers/users/index.js',
      'panel/assets/js/controllers/users/avatar.js',
    );

    return $this->combine($scripts);

  }

  public function libs() {

    $scripts = array(
      'panel/assets/js/lib/angular.ui.router.js',
      'panel/assets/js/lib/dropzone.js',
      'panel/assets/js/lib/moment.js',
      'panel/assets/js/lib/jquery.ui.js',
      'panel/assets/js/lib/jquery.pikaday.js',
      'panel/assets/js/lib/codemirror.js',
      'panel/assets/js/lib/codemirror/addon/display/placeholder.js',
      'panel/assets/js/lib/codemirror/addon/mode/overlay.js',
      'panel/assets/js/lib/codemirror/mode/markdown/markdown.js',
      'panel/assets/js/lib/codemirror/mode/gfm/gfm.js',
    );

    return $this->combine($scripts);

  }

  public function fields() {

    $fields  = new Folder(root('panel.fields'));
    $scripts = array();

    foreach($fields->children() as $dir) {
      $scripts[] = 'panel/fields/' . $dir->name() . '/directive.js';
    }

    return $this->combine($scripts);

  }

  protected function combine($scripts) {

    $js = array();

    foreach($scripts as $script) {
      $js[] = f::read(c::get('root') . DS . $script);
    }

    $js = implode(PHP_EOL, $js);
    return new Response($js, 'application/javascript');

  }

}