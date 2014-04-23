app.controller('MetatagsController', function($rootScope, $scope, $state, $stateParams, $http, page) {

  $scope.page     = page;
  $scope.limit    = 15;
  $scope.metatags = true;
  $scope.page.uri = '';

  $http.get('api/pages/fields').then(function(response) {
    $scope.fields = response.data;
    $scope.main   = 'api/pages/form';
  });

  $scope.breadcrumb = [
    {
      label: 'Metatags',
      url: $state.href('metatags')
    }
  ];

  // hacky way to connect the form with the breadcrumb
  $scope.page.content.title = page.title;

  $scope.pageIconClass = function(page) {
    if(page.home)  return 'fa-home';
    if(page.error) return 'fa-exclamation-circle';
    return 'fa-file-text-o';
  };

  $scope.submit = function() {

    $http.post('api/pages/update/', $.param($scope.page.content))
      .success(function() {
        $rootScope.status.success();
        $state.reload();
      })
      .error(function() {
        $rootScope.status.error();
      })

  };

});