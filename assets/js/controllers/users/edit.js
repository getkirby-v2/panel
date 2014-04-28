app.controller('EditUserController', function($rootScope, $scope, $state, $stateParams, $http, user) {

  $scope.user   = angular.copy(user);
  $scope.submit = function() {

    $http.post('api/users/update/' + user.username, $.param($scope.user))
      .success(function() {

        if(user.current && user.language != $scope.user.language) {
          window.location.href = $state.href('users');
          window.location.reload();
        } else {
          $state.go('users', null, {reload: true});
        }

      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});
