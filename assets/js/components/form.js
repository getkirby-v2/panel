$.fn.form = function() {

  return this.each(function() {

    var form = $(this);

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

    form.on('submit', function() {
      form.find('.field-with-error').removeClass('field-with-error');
    });

    form.find('[data-field]').each(function() {
      var el  = $(this);
      var key = el.data('field');
      if(el[key]) el[key]();
    });

    var submit = form.find('.btn-submit');
    var save   = submit.val();

    form.on('success', function() {
      submit.addClass('btn-positive').val(submit.data('saved')).focus();
      setTimeout(function() {
        submit.removeClass('btn-positive').val(save).blur();
      }, 1000);
    });

    form.on('error', function(e, fields) {

      if(fields) {
        $.each(fields, function(i, field) {
          $('#form-field-' + field).parents('.field').addClass('field-with-error');
        });
      }

      setTimeout(function() {
        form.find('.field-with-error .input').focus();
      }, 1);

    });

  });

};