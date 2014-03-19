app.controller('FilesController', function($rootScope, $scope, $state, page) {

  $scope.page = page;

});

app.controller('UploadFileController', function($rootScope, $scope, $state, page) {

  $scope.page = page;

  if($state.current.name == 'page.modal.upload') {
    var go = 'page';
  } else {
    var go = 'files';
  }

  $scope.submit = function() {
    $state.transitionTo(go, {uri: page.uri}, {reload: true});
  };

});

app.controller('EditFileController', function($rootScope, $scope, $state, $http, page, file) {

  $scope.page = page;
  $scope.file = file;

  $scope.submit = function() {

    $http.post('api/files/update/?uri=' + $scope.page.uri + '&filename=' + $scope.file.filename, $.param($scope.file))
      .success(function() {
        $rootScope.status.success();
        $state.reload();
      })
      .error(function() {
        $rootScope.status.error();
      })

  };

  $scope.back = function() {
    window.history.back();
  };

});

app.controller('DeleteFileController', function($rootScope, $scope, $state, $http, page, file) {

  $scope.page = page;
  $scope.file = file;

  $scope.submit = function() {

    $http.delete('api/files/delete?uri=' + page.uri + '&filename=' + file.filename)
      .success(function() {
        $state.transitionTo('files', {uri: page.uri}, {reload: true});
      })
      .error(function() {
        $scope.alert('The file could not be removed');
      });

  };

});