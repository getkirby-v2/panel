app.controller('EditFileController', function($rootScope, $scope, $state, $http, page, file) {

  $scope.page = page;
  $scope.file = angular.copy(file);

  $scope.submit = function() {

    $http.post('api/files/update/?uri=' + $scope.page.uri + '&filename=' + file.filename, $.param($scope.file))
      .success(function() {

        if($scope.file.name !== file.name) {

          // rename the file 
          $http.post('api/files/rename/?uri=' + $scope.page.uri + '&filename=' + file.filename, $.param({name: $scope.file.name}))
            .success(function(response) {
              $rootScope.status.success();
              $state.transitionTo($state.current, {filename: response.data.filename, uri: page.uri}, {reload: true});
            })
            .error(function() {
              $rootScope.status.error();
            })

        } else {

          $rootScope.status.success();
          $state.reload();

        }

      })
      .error(function() {
        $rootScope.status.error();
      })

  };

  $scope.back = function() {
    window.history.back();
  };

});