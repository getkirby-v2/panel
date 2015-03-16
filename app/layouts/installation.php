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

      var $suggest = $('.pw-suggestion');
      var $input   = $('input[type=password]');

      $input.on('blur', function() {
        $input.attr('type', 'password');
      });

      $suggest.text($.suggestPassword(24)).on('click', function(e) {
        e.preventDefault();
        $input.attr('type', 'text').fillPassword().select();
      });

      $('.pw-reload').on('click', function(e) {
        e.preventDefault();
        $suggest.text($.suggestPassword(24));
      });

    </script>

  </body>
</html>
