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

app.controller('EditFileController', function($rootScope, $scope, $state, page, file) {

  $scope.page = page;
  $scope.file = file;

  $scope.submit = function() {
    $scope.close();
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