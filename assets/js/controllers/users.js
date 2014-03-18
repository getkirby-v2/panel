app.controller('UsersController', function($rootScope, $scope, $state, $stateParams, users) {
  $scope.users = users;
});

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

app.controller('EditUserController', function($rootScope, $scope, $state, $stateParams, user) {

  $scope.user   = user;
  $scope.submit = $scope.close;

});

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