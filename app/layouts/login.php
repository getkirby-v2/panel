<!DOCTYPE html>
<html lang="en" ng-app="app">
  <head>

    <?php echo $meta ?>

    <title><?php echo l('login.title') ?></title>

    <?php

    echo css(array(
      'panel/assets/css/app.css',
      'panel/assets/css/form.css',
      'panel/assets/css/font-awesome.css'
    ));

    echo html::shiv();

    ?>

  </head>
  <body ng-controller="LoginController">

    <div class="modal">
      <div class="modal__box login">
        <form class="form" ng-class="{loading: loading}" ng-submit="submit()">

          <div class="form__alert" ng-show="message" ng-click="alert('')">
            {{message}}
          </div>

          <div class="form__field">
            <label class="form__label"><?php echo l('login.username') ?></label>
            <input class="form__input" autofocus type="text" ng-model="user.username">
          </div>

          <div class="form__field">
            <label class="form__label"><?php echo l('login.password') ?></label>
            <input class="form__input" type="password" ng-model="user.password">
          </div>

          <div class="form__buttons">
            <input type="submit" class="form__button form__button--submit" value="<?php echo l('login.button') ?>">
          </div>
        </form>
      </div>
    </div>

    <?php

    echo js(array(
      'panel/assets/js/lib/jquery.js',
      'panel/assets/js/lib/angular.js',
      'panel/assets/js/apps/login.js',
      'panel/assets/js/factories/reposition.js',
      'panel/assets/js/controllers/login/index.js',
    ));

    ?>

  </body>
</html>