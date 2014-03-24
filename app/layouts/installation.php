<!DOCTYPE html>
<html lang="en" ng-app="app">
  <head>

    <meta charset="utf-8" />  
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow" />

    <base href="<?php echo url('panel') ?>/"></base>
    <title>Kirby Panel</title>

    <?php 

    echo css(array(
      'panel/assets/css/app.css',
      'panel/assets/css/font-awesome.css'
    )); 

    echo html::shiv();

    ?>

  </head>
  <body ng-controller="InstallationController">

    <div class="modal">
      <div class="modal__box login" ng-include="view" onload="reposition()"></div>
    </div>

    <?php 

    echo js(array(
      'panel/assets/js/lib/jquery.js',
      'panel/assets/js/lib/angular.js',
      'panel/assets/js/apps/installation.js',
      'panel/assets/js/factories/reposition.js',
      'panel/assets/js/controllers/installation/index.js',
    ));

    ?>    
    
  </body>
</html>