app.controller('ChildrenController', function($rootScope, $scope, $state, $stateParams, $http, $timeout, page) {

  $scope.page = page;

  // fix the uri for the api
  if($scope.page.uri == null) $scope.page.uri = '';

  $timeout(function() {

    $('.sortable').sortable({
      connectWith: '.sortable',
      start: function() {
        $rootScope.dropdown.close();
        $rootScope.$apply();
      },
      update: function() {
        if($(this).attr('id') == 'visible-children') {
          $http.post('api/pages/sort/?uri=' + $scope.page.uri, $.param({uids : $(this).sortable('toArray')}))
            .success(function(response) {
              $state.go($state.$current, $stateParams, {reload: true});
            })
            .error(function(response) {

            });
        } 
      },
      receive : function(event, ui) {
        if($(this).attr('id') == 'invisible-children') {
          $http.post('api/pages/hide/?uri=' + $scope.page.uri + '/' + ui.item.attr('id'))
            .success(function(response) {
              $state.go($state.$current, $stateParams, {reload: true});
            })
            .error(function(response) {

            });
        }
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