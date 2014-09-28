<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('login')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="grey">

    <div class="modal-content">

      <div class="message <?php e(!empty($welcome), 'message-is-notice', 'message-is-alert hidden') ?>">
        <span class="message-content"><?php __($welcome) ?></span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>

      <?php echo $form ?>

    </div>

    <?php echo assets::js() ?>
    <?php echo js(panel()->urls()->js() . '/apps/login.js') ?>

  </body>
</html>