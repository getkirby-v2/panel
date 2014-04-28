app.controller('AvatarController', function($rootScope, $scope, $state, $stateParams, $http, user) {

  $scope.user = user;
  $scope.uploadable = true;

  $http.get('api/app/health/avatars')
    .success(function() {
      $scope.uploadable = true;
    })
    .error(function() {
      $scope.uploadable = false;
    });

  $scope.submit = function() {
    $state.transitionTo('users', {}, {reload: true});
  };

  $scope.delete = function() {

    $http.delete('api/users/avatar/?username=' + $scope.user.username)
      .success(function() {
        $state.go('users', null, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});
