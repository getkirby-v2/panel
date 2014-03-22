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

    <div ui-view></div>

    <section class="modal" ng-show="modal" ng-controller="ModalController">
      <div class="modal__shim" ng-click="close()"></div>
      <div class="modal__box" ui-view="modal"></div>
    </section>

    <script src="assets/js/dropzone.js"></script>
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery.ui.js"></script>
    <script src="assets/js/jquery.pikaday.js"></script>
    <script src="assets/js/dropzone.js"></script>
    
    <!-- code mirror -->
    <script src="assets/js/codemirror.js"></script>
    <script src="assets/js/codemirror/addon/display/placeholder.js"></script>
    <script src="assets/js/codemirror/addon/mode/overlay.js"></script>
    <script src="assets/js/codemirror/mode/markdown/markdown.js"></script>
    <script src="assets/js/codemirror/mode/gfm/gfm.js"></script>
    
    <!-- angular -->
    <script src="assets/js/angular.js"></script>
    <script src="assets/js/angular.ui.router.js"></script>
    <script src="assets/js/angular.editor.js"></script>
    <script src="assets/js/angular.tagbox.js"></script>
    <script src="assets/js/angular.date.js"></script>
    <script src="assets/js/angular.dropzone.js"></script>
    <script src="assets/js/app.js"></script>

    <!-- controllers -->
    <script src="assets/js/controllers/page.js"></script>
    <script src="assets/js/controllers/files.js"></script>
    <script src="assets/js/controllers/children.js"></script>
    <script src="assets/js/controllers/users.js"></script>

    <!-- routes -->
    <script src="assets/js/routes.js"></script>
    
  </body>
</html>