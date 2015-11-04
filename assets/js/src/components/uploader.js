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
        url: form.attr('action') + '?csrf=' + form.find('[name=csrf]').val(),
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
      dragenter : function(e) {      
        $('body').addClass('over');
      },
      drop: function() {
        $('body').removeClass('over');
      },
      dragleave: function() {
        $('body').removeClass('over');
      },
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