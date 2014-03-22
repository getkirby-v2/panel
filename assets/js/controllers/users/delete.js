app.controller('DeleteUserController', function($rootScope, $scope, $state, $stateParams, $http, user) {

  $scope.user = user;
  
  $scope.submit = function() {

    $http.delete('api/users/delete/' + $scope.user.username)
      .success(function() {
        $state.go('users', null, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };  

});