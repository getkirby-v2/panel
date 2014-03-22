app.controller('UploadFileController', function($scope, $state, page) {

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