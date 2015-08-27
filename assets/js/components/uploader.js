(function($) {

  $.support.uploader = $.support.upload && $.support.fileReader;

  $.fn.uploader = function(complete) {

    if(!$.support.uploader) return false;

    var form   = $(this);
    var upload = function(uploads) {

      var done = false;

      app.isLoading(true);
      $('body').addClass('loading');

      $.upload(uploads, {
        url: form.attr('action') + '?_csrf=' + form.find('[name=_csrf]').val(),
        complete: function() {
          if(done == false) {
            done = true;
            app.isLoading(false);
            $('body').removeClass('loading');
            complete();
          }
        }
      })

    };

    $(document).filedrop('destroy').filedrop({
      files : function(uploads) {
        upload(uploads);
      }
    });

    $('[data-upload]').on('click', function() {
      form.find('input[type=file]').trigger('click').on('change', function() {
        upload(this.files);
      });
      return false;
    });

  };

})(jQuery);