<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('installation')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="grey <?php echo panel()->direction() ?>">

    <div class="modal-content"><?php echo $content ?></div>

    <?php echo assets::js() ?>

    <script>

      $('.form').form();

      $('.message').on('click', function() {
        $(this).remove();
      });

      $('.pw-suggestion').text($('.form').suggestPassword());

      $('.pw-fill').click(function(e) {
        e.preventDefault();
        $('input[type=password]').fillPassword();
      });

    </script>

  </body>
</html>
