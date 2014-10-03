var $content = $('.modal-content');
var $form    = $content.find('.form');
var $message = $content.find('.message');

$message.on('click', function() {
  $message.addClass('hidden');
});

$form.on('submit', function() {

  $http.post('auth/login', $form.serializeObject(), function(r) {
    window.location.reload();
  }, function(message) {
    $message.removeClass('hidden')
            .removeClass('message-is-notice')
            .addClass('message-is-alert');
    $message.find('.message-content')
            .text(message);
  });

  return false;

});