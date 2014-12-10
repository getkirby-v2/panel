$.toSlug = function(string, callback) {
  $http.get('slug/?string=' + encodeURIComponent(string), callback);
};