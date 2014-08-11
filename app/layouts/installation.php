<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('installation')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="grey">

    <div class="modal-content"><?php echo $content ?></div>

    <?php echo assets::js() ?>

    <script>

      $('.form').form();

      $('.message').on('click', function() {
        $(this).remove();
      });

    </script>

  </body>
</html>