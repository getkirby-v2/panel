// Pages
var PageModel = {
  create : function(uri, data, done, fail) {
    $http.post('pages/create/' + uri, data, done, fail);
  },
  update : function(uri, data, done, fail) {
    $http.post('pages/update/' + uri, data, done, fail);
  },
  delete : function(uri, done, fail) {
    $http.post('pages/delete/' + uri, {}, done, fail);
  },
  sort : function(uri, index, uids, done, fail) {
    $http.post('pages/sort/' + uri, {index: index, uids : uids}, done, fail);
  },
  hide : function(uri, uid, done, fail) {
    $http.post('pages/hide/' + uri + '/' + uid, {}, done, fail);
  },
  url : function(uri, data, done, fail) {
    $http.post('pages/url/' + uri, data, done, fail);
  }
};

// Files
var FileModel = {
  update: function(uri, filename, data, done, fail) {
    $http.post('files/update/' + uri + '/?filename=' + filename, data, done, fail);
  },
  rename: function(uri, filename, newName, done, fail) {
    $http.post('files/rename/' + uri + '/?filename=' + filename, {name: newName}, done, fail);
  },
  sort: function(uri, filenames, done, fail) {
    $http.post('files/sort/' + uri, {filenames: filenames}, done, fail);
  },
  delete: function(uri, filename, done, fail) {
    $http.post('files/delete/' + uri + '/?filename=' + filename, {}, done, fail);
  }
};

// Users
var UserModel = {
  create : function(data, done, fail) {
    $http.post('users/create', data, done, fail);
  },
  update : function(username, data, done, fail) {
    $http.post('users/update/' + username, data, done, fail);
  },
  delete : function(username, done, fail) {
    $http.post('users/delete/' + username, {}, done, fail);
  },
  deleteAvatar: function(username, done, fail) {
    $http.post('avatars/delete/' + username, {}, done, fail);
  }
};