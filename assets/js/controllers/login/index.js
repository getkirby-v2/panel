app.controller('LoginController', function($scope, $http, reposition) {

  $scope.user = {
    username: '',
    password: ''
  };

  reposition('.login');  

  $scope.alert = function(message) {
    $scope.message = message;
    app.reposition('.login');        
  };
  
  $scope.submit = function() {

    $http.post('api/auth/login', $.param($scope.user))
      .success(function(response) {
        window.location.href = './';
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});