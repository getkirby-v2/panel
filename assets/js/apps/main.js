var app = angular.module('app', ['ui.router']);

// disable scrolling on state changes
app.value('$anchorScroll', angular.noop);

// TODO: understand services/factories and convert this into one
app.fetchPage = function($http, $stateParams) {
  return $http.get('api/pages/show?' + $.param({uri: $stateParams.uri})).then(function(response) {
    return response.data
  }, function() {
    window.location.href = './'
  });
};

app.fetchUser = function($http, $stateParams) {
  return $http.get('api/users/show/' + $stateParams.username).then(function(response) {
    return response.data;
  }, function() {
    window.location.href = './'          
  });
};

app.fetchFile = function($http, $stateParams) {
  return $http.get('api/files/show?' + $.param({uri: $stateParams.uri, filename: $stateParams.filename})).then(function(response) {
    return response.data;
  }, function() {
    window.location.href = './'          
  });
};

app.fetchTemplates = function($http, $stateParams) {
  return $http.get('api/pages/templates?' + $.param({uri: $stateParams.uri})).then(function(response) {
    return response.data;
  }, function() {
    window.location.href = './'          
  });
};

// configure the application
app.config(function($httpProvider, $stateProvider, $urlRouterProvider) {

  // global settings for $http
  $httpProvider.interceptors.push('httpRequestInterceptor');

  $stateProvider.state('layout', {
    abstract : true
  });

  // Fallback for invalid routes 
  $urlRouterProvider.otherwise('/');

});
