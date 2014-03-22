app.controller('AddPageController', function($rootScope, $scope, $state, $http, page, templates, focus) {

  $scope.parent    = page;
  $scope.templates = templates;

  // set the defaults  
  $scope.page = {
    parent   : $scope.parent.uri,
    template : $scope.templates[0].name,
    slug     : ''
  };

  $scope.submit = function() {

    $http.post('api/pages/create', $.param($scope.page))
      .success(function(response) {

        if($state.current.name == 'children.modal.add') {
          $state.transitionTo('children', {uri: page.uri}, {reload: true});
        } else {
          $state.transitionTo('page', {uri: page.uri}, {reload: true});
        }
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

  $scope.appendix = {
    visible : false,
    edit : function() {
      $scope.appendix.visible = true;      
      focus('AddPageController.page.slug');
      app.reposition('.modal__box');
    },
    close: function() {
      $scope.appendix.visible = false;
      app.reposition('.modal__box');
    }
  };

  $scope.convertTitle = function() {

    if($scope.page.title != null) {
      $http.get('api/slug?string=' + $scope.page.title)
        .success(function(response) {
          $scope.page.slug = response
        });
    } else {
      $scope.page.slug = '';
    }

  };

});