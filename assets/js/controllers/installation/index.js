app.controller('InstallationController', function($scope, $http, reposition) {

  $scope.user = {
    username: '',
    email:    '',
    password: ''
  };

  $scope.problems = null;

  $http.get('api/site/health')
    .success(function() {
      $scope.view = 'views/installation/signup.html';
    })
    .error(function(response) {
      $scope.problems = response.data;
      $scope.view     = 'views/installation/check.html';
    });

  $scope.reposition = function() {
    reposition('.modal__box');
  };

  $scope.alert = function(message) {
    $scope.message = message;
    app.reposition('.login');        
  };
  
  $scope.retry = function() {
    window.location.reload();
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