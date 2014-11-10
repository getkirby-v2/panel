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