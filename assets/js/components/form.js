var Form = function(form, params) {

  var form = $(form);

  var defaults = {
    returnTo : false,
    url: form.attr('action'),
    redirect: function(response) {
      if($.type(response) == 'object' && response.url) {
        app.content.open(response.url);                        
      } else {
        app.content.replace(response);
      }
    }
  };

  var options = $.extend({}, defaults, params);

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

  // hook up the form submission
  form.on('submit', function(e) {

    // auto submission can be switched off via a data attribute
    // to setup your own submission action
    if(form.data('autosubmit') == false) {
      return false;

    // if the autosubmit data attribute is set to native
    // the form submission will not be intercepted
    } else if(form.data('autosubmit') == 'native') {
      return true;
    }

    // on submit all errors should be removed. Looks weird otherwise
    form.find('.field-with-error').removeClass('field-with-error');

    // show the loading indicator
    app.isLoading(true);

    // handle the post request for the form and serialize all the data
    $.post(form.attr('action'), form.serialize(), function(response, message, xhr) {

      // hide the loading indicator
      app.isLoading(false);
    
      // handle redirection and replacement of data
      options.redirect(response);

    });

    return false;

  });

  // focus the right root in the form
  form.find('[autofocus]').trigger('focus');

};