app.controller('PublishController', function($rootScope, $scope, $state, $http, $timeout) {

  $http.post($rootScope.publishHook).then(function() {
    $timeout(function() {
      $scope.close();
    }, 1000);
  });

});