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