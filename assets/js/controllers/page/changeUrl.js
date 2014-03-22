app.controller('ChangeUrlController', function($rootScope, $scope, $state, $http, page, $timeout, focus) {

  $scope.page = page;

  $scope.submit = function() {

    $http.post('api/pages/change-url/?uri=' + page.uri + '&uid=' + page.slug)
      .success(function(response) {
        $state.go('page', {uri: response.data.uri});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

  $scope.convertTitle = function() {

    $http.get('api/slug?string=' + $scope.page.title)
      .success(function(response) {
        $scope.page.slug = response
      });

    focus('ChangeUrlController.page.slug');

  };

});