app.controller('DeletePageController', function($rootScope, $scope, $state, $http, page) {

  $scope.page = page;

  $scope.submit = function() {

    $http.delete('api/pages/delete/?uri=' + page.uri)
      .success(function() {
        $state.go('page', {uri: page.parent.uri});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});
