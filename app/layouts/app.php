<!DOCTYPE html>
<html lang="en">
<head>

  <?php echo $meta ?>

  <title><?php __(site()->title()) ?> | Panel</title>

  <?php echo assets::css() ?>

  <style><?php echo form::css() ?></style>

  <!-- custom panel stylesheet -->
  <?php if($stylesheet = kirby()->option('panel.stylesheet')): ?>
  <?php echo css($stylesheet) ?>
  <?php endif ?>

</head>
<body class="app <?php echo panel()->direction() ?>" data-kirby-version="<?php echo kirby()->version() ?>" data-panel-version="<?php echo panel()->version() ?>">

  <div data-view="modal" class="modal"></div>
  <div data-view="main"  class="main"><i class="loader"></i></div>

  <?php echo assets::js() ?>
  <?php echo js(panel()->urls()->js() . '/apps/main.js?v=' . panel()->version()) ?>
  <script><?php echo form::js(false) ?></script>
  <!-- custom panel javascript -->
  <?php if($javascript = kirby()->option('panel.javascript')): ?>
  <?php echo js($javascript) ?>
  <?php endif ?>

</body>
</html>
