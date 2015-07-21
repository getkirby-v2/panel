<?php if(r::ajax()): ?>

  <title><?php __(site()->title()) ?> | Panel</title>

  <?php if(isset($topbar))  echo $topbar ?>
  <?php if(isset($content)) echo $content ?>

<?php else: ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>

    <?php echo new Snippet('meta') ?>

    <title><?php __(site()->title()) ?> | Panel</title>

    <?php echo assets::css() ?>
    <style><?php echo form::css() ?></style>

    <!-- custom panel stylesheet -->
    <?php if($stylesheet = kirby()->option('panel.stylesheet')): ?>
    <?php echo css($stylesheet) ?>
    <?php endif ?>

    <?php echo assets::js() ?>
    <?php echo js(panel()->urls()->js() . '/app.js?v=' . panel()->version()) ?>

    <script><?php echo form::js(false) ?></script>

  </head>
  <body class="app <?php echo panel()->direction() ?>">

    <div class="main">
      <?php if(isset($topbar))  echo $topbar ?>
      <?php if(isset($content)) echo $content ?>
    </div>

  </body>
  </html>
<?php endif ?>