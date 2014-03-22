app.controller('InstallationController', function($scope, $http, reposition) {

  $scope.user = {
    username: '',
    email:    '',
    password: ''
  };

  reposition('.login');  

  $scope.alert = function(message) {
    $scope.message = message;
    app.reposition('.login');        
  };
  
  $scope.submit = function() {

    $http.post('api/install', $.param($scope.user))
      .success(function(response) {
        window.location.href = './login';
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});