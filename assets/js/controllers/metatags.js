/**
 *
 */
var MetatagsController = {

  index : function(uri, callback) {

    app.main.view('metatags/index', function(element) {

      var form = element.find('.form').form();

      if(uri) {
        form.find('[name=' + uri + ']').focus();
      }

      form.on('submit', function() {

        PageModel.update('', form.serializeObject(), function(response) {

          app.main.data('current', false);

          MetatagsController.index(uri, function(element) {
            element.find('.form').trigger('success');
          });

        }, function(message, response) {
          form.trigger('error', [response.data.fields]);
          form.message('alert', message);
        });

        return false;

      });

      if($.type(callback) == 'function') callback(element);

    });

  }

};