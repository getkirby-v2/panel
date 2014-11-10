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