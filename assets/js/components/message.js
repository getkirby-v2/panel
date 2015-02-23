$.fn.message = function(type, message) {

  return this.each(function() {
    var parent = $(this);

    if(!message) {

      parent.find('.message').remove();
      errors = parent.find('.field-with-error .input');

      if(errors.length) {
        errors.focus();
      } else {
        parent.find('[autofocus]').focus();
      }

    } else {
      parent.message();

      var element = $('<div class="message message-is-' + type + ' cf"><p class="message-content">' + message + '</p><span class="message-toggle"><i>&times;</i></span></div>');

      element.on('click', function() {
        parent.message();
      });

      parent.prepend(element);

    }

  });

};