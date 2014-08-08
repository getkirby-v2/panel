<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php _l('login') ?></title>

    <?php

    echo css(array(
      'panel/assets/css/app.css',
      'panel/assets/css/font-awesome.css'
    ));

    ?>

  </head>
  <body class="app">

    <div class="modal-content">

      <div class="message <?php e(!empty($welcome), 'message-is-notice', 'message-is-alert hidden') ?>">
        <span class="message-content"><?php __($welcome) ?></span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>

      <form class="form" method="post">

        <div class="field">
          <label class="label"><?php _l('login.username.label') ?></label>
          <input class="input" autofocus type="text" name="username" required>
        </div>

        <div class="field">
          <label class="label"><?php _l('login.password.label') ?></label>
          <input class="input" type="password" name="password" required>
        </div>

        <div class="buttons buttons-centered cf">
          <input type="submit" class="btn btn-rounded btn-submit" value="<?php _l('login.button') ?>">
        </div>
      </form>
    </div>

    <?php echo assets::js() ?>

    <script>

    var $content = $('.modal-content');
    var $form    = $content.find('.form');
    var $message = $content.find('.message');

    $message.on('click', function() {
      $message.addClass('hidden');
    });

    $form.on('submit', function() {

      $http.post('auth/login', $form.serializeObject(), function(r) {
        window.location.href = '#/'
      }, function(message) {
        $message.removeClass('hidden')
                .removeClass('message-is-notice')
                .addClass('message-is-alert');
        $message.find('.message-content')
                .text(message);
      });

      return false;

    });

    </script>

  </body>
</html>