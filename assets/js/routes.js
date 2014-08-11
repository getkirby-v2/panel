// register all routes
var routes = {
  '/' : function() {
    PagesController.show('');
  },
  '/metatags/?*' : function(uri) {
    MetatagsController.index(uri);
  },
  '/pages/add/*' : function(uri) {
    PagesController.add(uri, 'page');
  },
  '/pages/url/*' : function(uri) {
    PagesController.url(uri);
  },
  '/pages/show/*/p:*' : function(uri, page) {
    PagesController.show(uri, page);
  },
  '/pages/show/*' : function(uri) {
    PagesController.show(uri);
  },
  '/pages/delete/*' : function(uri) {
    PagesController.delete(uri, 'page');
  },
  '/pages/upload/*' : function(uri) {
    FilesController.upload(uri, 'page');
  },
  '/pages/search/*' : function(uri) {
    PagesController.search(uri);
  },
  '/subpages/index/*/visible:*/invisible:*' : function(uri, visible, invisible) {
    SubpagesController.index(uri, visible, invisible);
  },
  '/subpages/index/visible:*/invisible:*' : function(visible, invisible) {
    SubpagesController.index('', visible, invisible);
  },
  '/subpages/index/*' : function(uri) {
    SubpagesController.index(uri);
  },
  '/subpages/add/*' : function(uri) {
    PagesController.add(uri, 'subpages');
  },
  '/subpages/delete/*' : function(uri) {
    PagesController.delete(uri, 'subpages');
  },
  '/files/index/*' : function(uri) {
    FilesController.index(uri);
  },
  '/files/upload/*' : function(uri) {
    FilesController.upload(uri, 'files');
  },
  '/files/replace/*' : function(uri) {
    FilesController.replace(uri);
  },
  '/files/show/*' : function(uri) {
    FilesController.show(uri);
  },
  '/files/delete/*' : function(uri) {
    FilesController.delete(uri, 'file');
  },
  '/files/delete-from-index/*' : function(uri) {
    FilesController.delete(uri, 'index');
  },
  '/users' : function() {
    UsersController.index();
  },
  '/users/add' : function() {
    UsersController.add();
  },
  '/users/edit/:username' : function(username) {
    UsersController.edit(username, 'users');
  },
  '/users/avatar/:username/via:index' : function(username) {
    UsersController.avatar(username, 'users');
  },
  '/users/avatar/:username' : function(username) {
    UsersController.avatar(username, 'user');
  },
  '/users/delete-avatar/:username' : function(username) {
    UsersController.deleteAvatar(username);
  },
  '/users/delete/:username/via:index' : function(username) {
    UsersController.delete(username, 'users');
  },
  '/users/delete/:username' : function(username) {
    UsersController.delete(username, 'user');
  },
  '' : function() {
    window.location.replace('#/');
  },
  '*' : function() {
    ErrorsController.index();
  }
};