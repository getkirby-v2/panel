app.controller('LoginController', function($rootScope, $scope, $state, $http) {

  $scope.user = {
    username: '',
    password: ''
  };

  app.reposition('.login');  

  $scope.alert = function(message) {
    $rootScope.alert(message);
    app.reposition('.login');        
  };
  
  $scope.submit = function() {

    $http.post('api/auth/login', $.param($scope.user))
      .success(function(response) {
        $scope.alert('');
        $state.go('page');
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});

app.controller('LogoutController', function($rootScope, $scope, $state) {

  $rootScope.dropdown.close();
  $state.go('login');

});