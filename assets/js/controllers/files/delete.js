app.controller('DeleteFileController', function($scope, $state, $http, page, file) {

  $scope.page = page;
  $scope.file = file;

  $scope.submit = function() {

    $http.delete('api/files/delete?uri=' + page.uri + '&filename=' + file.filename)
      .success(function() {
        $state.transitionTo('files', {uri: page.uri}, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});