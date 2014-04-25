<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title>Kirby Panel</title>

    <?php

    echo css(array(
      'panel/assets/css/app.css',
      'panel/assets/css/font-awesome.css',
      'panel/assets/css/error.css'
    ));

    echo html::shiv();

    ?>

  </head>
  <body>
    An unexpected error occured.<br />
    <a href="./">Back home…</a>
  </body>
</html>