app.controller('ChildrenController', function($rootScope, $scope, $state, $stateParams, $http, $timeout, page) {

  $scope.page = page;

  $timeout(function() {

    $('.sortable').sortable({
      connectWith: '.sortable',
      start: function() {
        $rootScope.dropdown.close();
        $rootScope.$apply();
      },
      update: function() {
      }
    }).disableSelection();

  }, 0);

  $scope.delete = function(child) {

    $http.delete('api/pages/delete/?uri=' + child.uri)
      .success(function() {
        $state.go($state.$current, $stateParams, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});