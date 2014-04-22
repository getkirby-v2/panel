app.controller('FilesController', function($scope, $state, page) {

  $scope.page = page;

  $scope.breadcrumb = [
    {
      label: 'Files',
      url: $state.href('files', {uri: page.uri})
    }
  ];

});