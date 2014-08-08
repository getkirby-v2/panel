<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | ' . l('error')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="app">

    <?php echo $content ?>
    <?php echo assets::js() ?>

    <script>

      // init all global dropdowns
      $(document).dropdown();

    </script>

  </body>
</html>