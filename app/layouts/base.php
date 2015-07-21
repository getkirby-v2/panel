<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo new Snippet('meta') ?>

  <title><?php __(site()->title()) ?> | Panel</title>

  <?php echo assets::css() ?>

  <?php if($stylesheet = kirby()->option('panel.stylesheet')): ?>
  <?php echo css($stylesheet) ?>
  <?php endif ?>

  <?php echo assets::js() ?>

</head>
<body class="app <?php echo panel()->direction() ?>">
  <?php echo $content ?>
</body>
</html>