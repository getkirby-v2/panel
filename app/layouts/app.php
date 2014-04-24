<!DOCTYPE html>
<html lang="en" ng-app="app" ng-click="clicks()" ng-keydown="keys($event)">
  <head>

    <?php echo $meta ?>

    <title>Kirby Panel</title>

    <?php

    echo css(array(
      'panel/assets/css/grid.css',
      'panel/assets/css/app.css',
      'panel/assets/css/form.css',
      'panel/assets/css/font-awesome.css',
      'panel/assets/css/tagbox.css',
      'panel/assets/css/dropzone.css',
      'panel/assets/css/pickaday.css',
      'panel/assets/css/codemirror.css',
      'panel/assets/css/codemirror.theme.css',
    ));

    echo html::shiv();

    ?>

    <script>
      var defaultLanguage = <?php echo $defaultLanguage ?>;
      var publishHook     = <?php echo $publishHook ?>;
    </script>

  </head>
  <body ng-controller="AppController" ng-class="{'has-dropdown': dropdown.current}">

    <div ui-view autoscroll="false"></div>

    <section class="modal" ng-show="modal" autoscroll="false" ng-controller="ModalController">
      <div class="modal__shim" ng-click="close()"></div>
      <div class="modal__box" ui-view="modal"></div>
    </section>

    <?php

    echo js(array(

      // libs
      'panel/assets/js/lib/dropzone.js',
      'panel/assets/js/lib/moment.js',
      'panel/assets/js/lib/jquery.js',
      'panel/assets/js/lib/jquery.ui.js',
      'panel/assets/js/lib/jquery.pikaday.js',

      // codemirror
      'panel/assets/js/lib/codemirror.js',
      'panel/assets/js/lib/codemirror/addon/display/placeholder.js',
      'panel/assets/js/lib/codemirror/addon/mode/overlay.js',
      'panel/assets/js/lib/codemirror/mode/markdown/markdown.js',
      'panel/assets/js/lib/codemirror/mode/gfm/gfm.js',

      // angular
      'panel/assets/js/lib/angular.js',
      'panel/assets/js/lib/angular.ui.router.js',

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

    ));

    $fields = new Folder(c::get('root.panel') . DS . 'fields');

    foreach($fields->children() as $dir) {
      echo js('panel/fields/' . $dir->name() . '/directive.js');
    }

    ?>

  </body>
</html>