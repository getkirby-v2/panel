var $http = {
  endpoint : '',
  request : function(type, uri, data, done, fail) {
    $[type]($http.endpoint + '/' + uri, data, done).fail(function(r) {
      if(fail) {
        if(r.responseJSON && r.responseJSON.message) {
          fail(r.responseJSON.message, r.responseJSON);
        } else {
          fail('unexpected error', {});
        }
      }
    });
  },
  get : function(uri, data, done, fail) {
    $http.request('get', uri, data, done, fail);
  },
  post : function(uri, data, done, fail) {
    $http.request('post', uri, data, done, fail);
  }
};