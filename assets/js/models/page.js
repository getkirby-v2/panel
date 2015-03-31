var PageModel = {
  create : function(uri, data, done, fail) {
    $http.post('pages/create/' + uri, data, done, fail);
  },
  update : function(uri, data, done, fail) {
    $http.post('pages/update/' + uri, data, done, fail);
  },
  keep : function(uri, data, done, fail) {
    $http.post('pages/keep/' + uri, data, done, fail);
  },
  discard : function(uri, data, done, fail) {
    $http.post('pages/discard/' + uri, data, done, fail);
  },
  delete : function(uri, done, fail) {
    $http.post('pages/delete/' + uri, {}, done, fail);
  },
  sort : function(uri, id, to, done, fail) {
    var uri = uri ? uri + '/' + id : id;
    $http.post('pages/sort/' + uri, {to: to}, done, fail);
  },
  publish : function(uri, done, fail) {
    $http.post('pages/publish/' + uri, {}, done, fail);
  },
  unpublish : function(uri, done, fail) {
    $http.post('pages/hide/' + uri, {}, done, fail);
  },
  hide : function(uri, uid, done, fail) {
    $http.post('pages/hide/' + uri + '/' + uid, {}, done, fail);
  },
  url : function(uri, data, done, fail) {
    $http.post('pages/url/' + uri, data, done, fail);
  }
};