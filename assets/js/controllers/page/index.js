app.controller('PageController', function($rootScope, $scope, $state, $stateParams, $timeout, $http, page) {

  $scope.page     = page;
  $scope.limit    = $scope.page.settings.pages ? $scope.page.settings.pages.limit : 20;
  $scope.fields   = null;
  $scope.sections = null;

  // hacky way to connect the form with the breadcrumb
  $scope.page.content.title = page.title;

  if(!page.parent) {
    $http.get('api/site/metatags').then(function(response) {
      $scope.sections = response.data;
      $scope.main     = 'views/pages/metatags.html';
    });
  } else {
    $http.get('api/pages/fields?uri=' + page.uri).then(function(response) {
      $scope.fields = response.data;
      $scope.main   = 'api/pages/form?uri=' + page.uri;
    });
  }

  $scope.pageIconClass = function(page) {
    if(page.home)  return 'fa-home';
    if(page.error) return 'fa-exclamation-circle';
    return 'fa-file-text-o';
  };

  $scope.submit = function() {

    $http.post('api/pages/update/?uri=' + $scope.page.uri, $.param($scope.page.content))
      .success(function() {
        $rootScope.status.success();
        $state.reload();
      })
      .error(function() {
        $rootScope.status.error();
      })

  };

  $scope.upload = function() {
    $state.transitionTo($state.current, {uri: page.uri}, {reload: true});
  };

  $scope.reload = function() {
    window.location.reload();
  }

});