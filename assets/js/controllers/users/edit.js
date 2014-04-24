app.controller('EditUserController', function($rootScope, $scope, $state, $stateParams, $http, user) {

  $scope.user   = user;
  $scope.submit = function() {

    $http.post('api/users/update/' + user.username, $.param($scope.user))
      .success(function() {
        $state.go('users', null, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});
