<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('login')) ?></title>

    <?php echo assets::css() ?>

    <!-- custom panel stylesheet -->
    <?php if($stylesheet = kirby()->option('panel.stylesheet')): ?>
    <?php echo css($stylesheet) ?>
    <?php endif ?>

  </head>
  <body class="login grey <?php echo panel()->direction() ?>">

    <div class="modal-content">

      <!--[if lt IE 10]>
      <div class="message message-is-alert">
        <span class="message-content">You are using an outdated browser. Please upgrade to the latest version of <a href="http://windows.microsoft.com/internet-explorer">Internet Explorer</a> or switch to <a href="http://mozilla.org/firefox">Firefox</a>, <a href="http://www.apple.com/safari/">Safari</a>, <a href="http://google.com/chrome">Google Chrome</a> or <a href="http://opera.com">Opera</a>.</span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>
      <![endif]-->

      <?php if($error): ?>
      <div class="message message-is-alert">
        <span class="message-content"><?php __($error) ?></span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>
      <?php elseif($welcome): ?>
      <div class="message message-is-notice">
        <span class="message-content"><?php __($welcome) ?></span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>
      <?php endif ?>

      <?php echo $form ?>

    </div>

    <?php echo assets::js() ?>

    <script>
      $('.message').on('click', function() {
        $(this).addClass('hidden');
      });
    </script>

  </body>
</html>
