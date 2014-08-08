/**
 *
 */
var UsersController = {
  index : function() {

    app.main.view('users/index');

  },
  add : function() {

    app.main.view('users/add', function(element) {

      element.find('.sidebar').sidebar();

      var form = element.find('.form').form();

      form.find('[autofocus]').focus();

      form.on('submit', function() {

        UserModel.create(form.serializeObject(), function() {
          window.location.href = '#/users';
        }, function(message) {
          form.message('alert', message);
        });
        return false

      });

    });

  },
  edit : function(username, to, callback) {

    app.main.view('users/edit/' + username, {to: to}, function(element) {

      element.find('.sidebar').sidebar();

      var form = element.find('.form').form();

      form.find('[autofocus]').focus();

      form.on('submit', function() {
        UserModel.update(username, form.serializeObject(), function() {
          app.main.data('current', false);
          UsersController.edit(username, to, function(element) {
            element.find('.form').trigger('success');
          });
        }, function(message) {
          form.message('alert', message);
        });
        return false
      });

      if(callback) callback(element);

    });

  },
  avatar : function(username, to) {

    switch(to) {
      case 'users':
        UsersController.index();
        break;
      case 'dashboard':
        DashboardController.index();
        break;
      default:
        UsersController.edit(username);
        break;
    }

    app.modal.view('users/avatar/' + username, {to: to}, function(element) {

      element.find('.dropzone').dropzone($http.endpoint + '/avatars/upload/' + username, function() {
        app.main.data('current', false);
        app.modal.close();
      });

    });

  },
  deleteAvatar: function(username) {

    UsersController.edit(username);

    app.modal.view('users/delete-avatar/' + username, function(element) {

      element.find('.form').on('submit', function() {
        UserModel.deleteAvatar(username, function() {
          app.main.data('current', false);
          app.modal.close();
        }, app.modal.alert);
        return false;
      });

    });

  },
  delete : function(username, to) {

    switch(to) {
      case 'users':
        UsersController.index();
        break;
      case 'user':
        UsersController.edit(username);
        break;
    }

    app.modal.view('users/delete/' + username, {to: to}, function(element) {

      element.find('.form').on('submit', function() {
        UserModel.delete(username, function() {
          app.main.data('current', false);
          window.location.href = '#/users';
        }, app.modal.alert);
        return false;
      });

    });

  }
};