app.controller('AddUserController', function($rootScope, $scope, $state, $stateParams, $http) {

  $scope.user = {};

  $scope.submit = function() {

    $http.post('api/users/create', $.param($scope.user))
      .success(function() {
        $state.go('users', null, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});
