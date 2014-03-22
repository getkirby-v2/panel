app.controller('EditUserController', function($rootScope, $scope, $state, $stateParams, user) {

  $scope.user   = user;
  $scope.submit = $scope.close;

});
