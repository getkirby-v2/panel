// the global modal controller
app.controller('ModalController', function($rootScope, $scope, $state, $element, reposition) {
              
  $scope.message = null;
  $scope.loading = false;

  $scope.close = function() {
    $scope.message = null;
    $scope.loading = false;
    $state.go('^.^');
  };

  $scope.reposition = function() {
    reposition('.modal__box');
  };

  $scope.alert = function(message) {
    $scope.message = message;    
    $scope.reposition();
  };

  $rootScope.$on('key:esc', $scope.close);

  $scope.$on('$viewContentLoaded', function(event) { 
    $scope.reposition();    
  });

});