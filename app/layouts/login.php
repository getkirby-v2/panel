<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('login')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="grey">

    <div class="modal-content">

      <!--[if lt IE 10]>
      <div class="message message-is-alert">
        <span class="message-content">You are using an outdated browser. Please upgrade to the latest version of <a href="http://windows.microsoft.com/internet-explorer">Internet Explorer</a> or switch to <a href="http://mozilla.org/firefox">Firefox</a>, <a href="http://www.apple.com/safari/">Safari</a>, <a href="http://google.com/chrome">Google Chrome</a> or <a href="http://opera.com">Opera</a>.</span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>
      <![endif]-->

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