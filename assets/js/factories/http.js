app.factory('httpRequestInterceptor', function($rootScope) {
  return {
    request: function($config) {
      $config.headers['language'] = $rootScope.language;
      return $config;
    }
  };
});