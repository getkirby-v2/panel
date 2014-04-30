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
      'panel/assets/js/lib/jquery.js',
      'panel/assets/js/lib/angular.js',
      'panel/assets/js/libs.js',

      // app
      'panel/assets/js/app.js',
      'panel/assets/js/fields.js'
    ));

    ?>

  </body>
</html>