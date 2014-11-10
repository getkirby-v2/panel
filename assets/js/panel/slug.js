$.toSlug = function(string, callback) {
  $http.get('slug/?string=' + string, callback);
};