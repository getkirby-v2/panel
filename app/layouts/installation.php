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
      <div class="modal__box login">
        <form class="form" ng-class="{loading: loading}" ng-submit="submit()">

          <div class="form__alert" ng-show="message" ng-click="alert('')">
            {{message}}
          </div>

          <div class="form__field">
            <label class="form__label">Installation</label>
            <p>
              Welcome to the Kirby Panel<br />
              Please create your first user…
            </p>
          </div>

          <div class="form__field">
            <label class="form__label">Username</label>
            <input class="form__input" autofocus type="text" ng-model="user.username">
          </div>
          
          <div class="form__field">
            <label class="form__label">Email</label>
            <input class="form__input" type="email" ng-model="user.email">
          </div>

          <div class="form__field">
            <label class="form__label">Password</label>
            <input class="form__input" type="password" ng-model="user.password">
          </div>

          <div class="form__buttons">
            <input type="submit" class="form__button form__button--submit" value="Create your account">
          </div>
        </form>
      </div>
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