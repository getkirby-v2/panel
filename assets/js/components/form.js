var Form = function(form, params) {

  var defaults = {
    returnTo : false,
    url: window.location.href,
    redirect: function(destination, response) {

      if(options.returnTo) {
        app.content.open(options.returnTo);                        
      } else if(options.url != destination) {
        app.content.open(destination);                        
      } else {
        app.content.replace(response);
      }

    }
  };

  var options = $.extend( {}, defaults, params);
  var form    = $(form);

  form.find('[data-focus=true]').on({
    'click' : function() {
      $(this).find('input, textarea, select').focus();
    },
    'focusin' : function() {
      $(this).addClass('input-is-focused');
    },
    'focusout' : function() {
      $(this).removeClass('input-is-focused');
    }
  });

  // setup all field plugins  
  form.find('[data-field]').each(function() {
    var el  = $(this);
    var key = el.data('field');
    if(el[key]) el[key]();
  });

  if(form.data('keep')) {
    form.find('input, textarea').on('change', function() {
      $.post(form.data('keep'), form.serialize());
    });
  }

  form.on('submit', function(e) {

    if(form.data('autosubmit') == false) {
      return false;
    } else if(form.data('autosubmit') == 'native') {
      return true;
    }

    form.find('.field-with-error').removeClass('field-with-error');

    // handle the post request for the form and serialize all the data
    $.post(options.url, form.serialize(), function(response, message, xhr) {

      // check for the final url to handle redirects appropriately
      var destination = xhr.getResponseHeader('X-Panel-Location');
    
      // handle redirection and replacement of data
      options.redirect(destination, response);

    });

    return false;

  });

  // focus the right root in the form
  form.find('[autofocus]').trigger('focus');

};