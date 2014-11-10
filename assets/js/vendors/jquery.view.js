(function($) {

  $.fn.view = function(url, data, callback, error) {

    return this.each(function() {

      var view = $(this);
      var id   = url;

      if($.type(url) == 'string') {

        if($.type(data) == 'function') {
          var d = false;
          var c = data;
          var e = callback;
        } else {
          var d = data;
          var c = callback;
          var e = error;
        }

        // build a full identifier with all data params
        if(d) id += '?' + $.param(d);

        view.trigger('view:beforeload');

        // check if the view has to be reloaded
        if(view.data('current') === id) {
          return true;
        }

        var endpoint = view.data('endpoint') + '/' + url;

        view.load(endpoint, d, function(response, status) {
          if(status == 'error') {
            view.trigger('view:error', [response, url, d]);
            view.data('current', false);
            if($.type(e) == 'function') e(response);
          } else {
            view.trigger('view:load');
            view.data('current', id);
            if($.type(c) == 'function') c(view);
          }
        });

      } else {

        view.on('view:empty', function() {
          view.data('current', false);
          view.empty();
        });

        view.on('view:hide', function() {
          view.data('current', false);
          view.hide();
        });

        view.trigger('view:ready');

      }

    });

  };

})(jQuery);