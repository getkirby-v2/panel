/**
 *
 */
var DashboardController = {

  index : function() {
    app.main.view('dashboard/index');
  },

  metatags : function(uri, callback) {

    app.main.view('dashboard/metatags', function(element) {

      var form = element.find('.form').form();

      if(uri) {
        form.find('[name=' + uri + ']').focus();
      }

      form.on('submit', function() {

        PageModel.update('', form.serializeObject(), function(response) {

          app.main.data('current', false);

          DashboardController.metatags(uri, function(element) {
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