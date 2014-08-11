<!DOCTYPE html>
<html lang="en">
  <head>

    <?php echo $meta ?>

    <title><?php __(site()->title() . ' | Panel | ' . l('login')) ?></title>

    <?php echo assets::css() ?>

  </head>
  <body class="grey">

    <div class="modal-content">

      <div class="message <?php e(!empty($welcome), 'message-is-notice', 'message-is-alert hidden') ?>">
        <span class="message-content"><?php __($welcome) ?></span>
        <span class="message-toggle"><i>&times;</i></span>
      </div>

      <?php echo $form ?>

    </div>

    <?php echo assets::js() ?>

    <script>

    var $content = $('.modal-content');
    var $form    = $content.find('.form');
    var $message = $content.find('.message');

    $message.on('click', function() {
      $message.addClass('hidden');
    });

    $form.on('submit', function() {

      $http.post('auth/login', $form.serializeObject(), function(r) {
        window.location.href = '#/'
      }, function(message) {
        $message.removeClass('hidden')
                .removeClass('message-is-notice')
                .addClass('message-is-alert');
        $message.find('.message-content')
                .text(message);
      });

      return false;

    });

    </script>

  </body>
</html>