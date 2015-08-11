/**
 *
 */
var FilesController = {
  index : function(uri) {

    app.main.view('files/index/' + uri, function(element) {

      if(element.find('.grid-item').length > 1) {
        element.find('.sortable').sortable({
          update: function() {
            FileModel.sort(uri, $(this).sortable('toArray'));
          }
        }).disableSelection();
      }

    });

  },
  upload : function(uri, to) {

    switch(to) {
      case 'page':
        PagesController.show(uri);
        break;
      case 'metatags':
        MetatagsController.index();
        break;
      default:
        FilesController.index(uri);
        break;
    }

    app.modal.view('files/upload/' + uri, {to: to}, function(element) {

      var dropzone = element.find('.dropzone');
      var url      = $http.endpoint + '/files/upload/' + uri + '?_csrf=' + dropzone.data('csrf');

      dropzone.dropzone(url, function() {
        app.main.data('current', false);
        app.modal.close();
      }, app.modal.alert);

    });

  },
  replace : function(uri) {

    FilesController.show(uri);

    var path = FilesController.path(uri);
    var url  = path.uri ? 'files/replace/' + path.uri : 'files/replace';

    app.modal.view(url + '/?filename=' + path.filename, function(element) {

      var dropzone = element.find('.dropzone');
      var url      = $http.endpoint + '/files/replace/' + path.uri + '?filename=' + path.filename + '&_csrf=' + dropzone.data('csrf');

      dropzone.dropzone(url, function() {
        app.main.data('current', false);
        app.modal.close();
      }, app.modal.alert, {
        maxFiles : 1
      });

    });

  },
  show : function(uri) {

    var path = FilesController.path(uri);
    var url  = path.uri ? 'files/show/' + path.uri : 'files/show';

    app.main.view(url + '/?filename=' + path.filename, function(element) {

      var sidebar = element.find('.fileview-sidebar');
      var form    = element.find('.form').form();
      var name    = form.find('[name=name]').val();

      form.on('submit', function() {

        var data = $(this).serializeObject();

        FileModel.update(path.uri, path.filename, data, function() {
          if(name !== data.name) {
            FileModel.rename(path.uri, path.filename, data.name, function(response) {
              window.location.href = '#/files/show/' + path.uri + '/' + response.data.filename;
            }, function(message) {
              sidebar.message('alert', message);
            });
          } else {
            sidebar.message();
            form.trigger('success');
          }
        }, function(message, response) {
          form.trigger('error', [response.data.fields]);
          sidebar.message('alert', message);
        });

        return false;

      });

      element.find('[data-element=public-link]').on('click', function() {
        $(this).select();
      });

    });

  },
  delete: function(uri, to) {

    var path = FilesController.path(uri);

    switch(to) {
      case 'index':
        FilesController.index(path.uri);
        break;
      default:
        FilesController.show(path.raw);
        break;
    }

    app.modal.view('files/delete/' + path.uri + '/?filename=' + path.filename, {to: to}, function(element) {
      element.find('.form').on('submit', function() {

        var data = $(this).serializeObject();

        FileModel.delete(path.uri, path.filename, function() {
          app.main.data('current', false);
          window.location.href = '#/files/index/' + data.page;
        }, app.modal.alert);

        return false;

      });
    });

  },
  path : function(path) {

    var arr = path.split('/');

    return {
      raw      : path,
      uri      : arr.slice(0, -1).join('/'),
      filename : arr.slice(-1)
    }

  }
};
