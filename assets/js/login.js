var app = angular.module('login', []);

// global reposition method for modal boxes
app.reposition = function(element) {

  setTimeout(function() {
    var $box = $(element);

    var left = Math.round($box.outerWidth() / 2);    
    var top  = Math.round($box.outerHeight() / 2);    

    $box.css({'opacity' : 0, 'margin-left' : -left, 'margin-top' : -top});    
    $box.animate({'opacity' : 1}, 300);  
    
  });

};

// the main app controller
app.controller('LoginController', function($scope, $http) {

  $scope.user = {
    username: '',
    password: ''
  };

  app.reposition('.login');  

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