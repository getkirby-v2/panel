var FileModel = {
  update: function(uri, filename, data, done, fail) {
    var url = uri ? 'files/update/' + uri : 'files/update';
    $http.post(url + '/?filename=' + filename, data, done, fail);
  },
  rename: function(uri, filename, newName, done, fail) {
    var url = uri ? 'files/rename/' + uri : 'files/rename';
    $http.post(url + '/?filename=' + filename, {name: newName}, done, fail);
  },
  sort: function(uri, filenames, done, fail) {
    $http.post('files/sort/' + uri, {filenames: filenames}, done, fail);
  },
  delete: function(uri, filename, done, fail) {
    var url = uri ? 'files/delete/' + uri : 'files/delete';
    $http.post(url + '/?filename=' + filename, {}, done, fail);
  }
};