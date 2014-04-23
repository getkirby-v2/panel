app.controller('EditFileController', function($rootScope, $scope, $state, $http, page, file) {

  $scope.page   = page;
  $scope.file   = angular.copy(file);
  $scope.view   = 'form';
  $scope.fields = null;

  $scope.dropOptions = {
    maxFiles : 1
  };

  $http.get('api/files/fields?uri=' + page.uri).then(function(response) {
    $scope.fields = response.data;
  });

  $scope.breadcrumb = [
    {
      label: 'Files',
      url: $state.href('files', {uri: page.uri})
    },
    {
      label: $scope.file.filename,
      url: $state.href('file', {uri: page.uri, filename: file.filename})
    }
  ];

  $scope.show = function(view) {
    $scope.view = view;
  };

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

  $scope.replace = function() {
    $state.transitionTo($state.current, {filename: file.filename, uri: page.uri}, {reload: true});
  };

  $scope.delete = function() {

    $http.delete('api/files/delete?uri=' + page.uri + '&filename=' + file.filename)
      .success(function() {
        $state.transitionTo('files', {uri: page.uri}, {reload: true});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

  $scope.back = function() {
    window.history.back();
  };

});