<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | ' . l('installation')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="app">

    <div class="modal-content"><?php echo $content ?></div>

    <?php echo assets::js() ?>

    <script>
      $('.message').on('click', function() {
        $(this).remove();
      });
    </script>

  </body>
</html>