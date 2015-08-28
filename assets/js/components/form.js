var Form = function(form, params) {

  var form = $(form);

  var defaults = {
    returnTo : false,
    url: form.attr('action'),
    redirect: function(response) {}
  };

  var options = $.extend({}, defaults, params);

  form.find('[data-focus=true]').fakefocus('input-is-focused');

  // setup all field plugins  
  form.find('[data-field]').each(function() {
    var el  = $(this);
    var key = el.data('field');
    if(el[key]) el[key]();
  });

  // don't setup a form submission action
  if(form.data('autosubmit') == 'native') {
    return true;
  }

  // hook up the form submission
  form.on('submit', function(e) {

    // auto submission can be switched off via a data attribute
    // to setup your own submission action
    if(form.data('autosubmit') == false) {
      return false;
    } 

    // on submit all errors should be removed. Looks weird otherwise
    form.find('.field-with-error').removeClass('field-with-error');

    // show the loading indicator
    if(app) app.isLoading(true);

    // handle the post request for the form and serialize all the data
    $.post(form.attr('action'), form.serializeObject(), function(response, message, xhr) {

      // hide the loading indicator
      if(app) app.isLoading(false);
    
      // handle redirection and replacement of data
      options.redirect(response);

    });

    return false;

  });

  form.find('[autofocus]').focus();

};