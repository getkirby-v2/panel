<?php if(r::ajax()): ?>

  <title><?php __($title) ?></title>

  <?php if(isset($topbar))  echo $topbar ?>
  <?php if(isset($content)) echo $content ?>

<?php else: ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __($title) ?></title>

    <?php echo $css ?>
    <style><?php echo $formcss ?></style>

    <!-- custom panel stylesheet -->
    <?php if($stylesheet = kirby()->option('panel.stylesheet')): ?>
    <?php echo css($stylesheet) ?>
    <?php endif ?>

    <?php echo $js ?>
    <?php echo $appjs ?>

    <script><?php echo $formjs ?></script>

  </head>
  <body class="app <?php __($direction) ?>">

    <div class="main">
      <?php if(isset($topbar))  echo $topbar ?>
      <?php if(isset($content)) echo $content ?>
    </div>

  </body>
  </html>
<?php endif ?>