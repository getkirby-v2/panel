<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo $meta ?>

  <title><?php __(site()->title()) ?> | Panel</title>

  <?php echo assets::css() ?>

  <style><?php echo form::css() ?></style>

</head>
<body class="app">

  <div class="progressbar"></div>

  <div data-view="modal" class="modal"></div>
  <div data-view="main"  class="main"><i class="loader"></i></div>

  <?php echo assets::js() ?>
  <script><?php echo form::js(false) ?></script>

</body>
</html>