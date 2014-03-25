<!DOCTYPE html>
<html lang="en" ng-app="app" ng-click="clicks()" ng-keydown="keys($event)">
  <head>

    <meta charset="utf-8" />  
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow" />

    <base href="<?php echo url('panel') ?>/"></base>
    <title>Kirby Panel</title>

    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/tagbox.css">
    <link rel="stylesheet" href="assets/css/dropzone.css">
    <link rel="stylesheet" href="assets/css/pickaday.css">
    <link rel="stylesheet" href="assets/css/codemirror.css">
    <link rel="stylesheet" href="assets/css/codemirror.theme.css">

    <script>
      var defaultLanguage = '<?php echo $defaultLanguage ?>';
    </script>

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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

      // directives
      'panel/assets/js/directives/date.js',
      'panel/assets/js/directives/dropzone.js',
      'panel/assets/js/directives/editor.js',
      'panel/assets/js/directives/focus.js',
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
      'panel/assets/js/controllers/page/metatags.js',

      'panel/assets/js/controllers/users/add.js',
      'panel/assets/js/controllers/users/delete.js',
      'panel/assets/js/controllers/users/edit.js',
      'panel/assets/js/controllers/users/index.js',

    ));

    ?>    
        
  </body>
</html>