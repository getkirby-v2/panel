app.controller('PageController', function($rootScope, $scope, $state, $stateParams, $timeout, $http, page) {

  $scope.page  = page;
  $scope.limit = $scope.page.settings.pages ? $scope.page.settings.pages.limit : 20;  

  // hacky way to connect the form with the breadcrumb
  $scope.page.content.title = page.title;

  if(!page.parent) {
    $http.get('api/site/metatags').then(function(response) {
      $scope.sections = response.data;
      $scope.main     = 'views/page/metatags.html';        
    });
  } else {
    $scope.main = 'views/page/form.html';        
  }

  $scope.pageIconClass = function(page) {
    if(page.home)  return 'fa-home';
    if(page.error) return 'fa-exclamation-circle';
    return 'fa-file-text-o';
  };

  $scope.submit = function() {

    $http.post('api/pages/update/?uri=' + $scope.page.uri, $.param($scope.page.content))
      .success(function() {
        $rootScope.status.success();
        $state.reload();
      })
      .error(function() {
        $rootScope.status.error();
      })

  };

  $scope.upload = function() {
    $state.transitionTo($state.current, {uri: page.uri}, {reload: true});
  };

});

app.controller('MetatagsController', function($rootScope, $scope, $state, $stateParams, $http, page) {

  $scope.page     = page;
  $scope.limit    = 15;
  $scope.main     = 'views/page/form.html';        
  $scope.metatags = true;
  $scope.page.uri = '';

  // hacky way to connect the form with the breadcrumb
  $scope.page.content.title = page.title;
  
  $scope.pageIconClass = function(page) {
    if(page.home)  return 'fa-home';
    if(page.error) return 'fa-exclamation-circle';
    return 'fa-file-text-o';
  };

  $scope.submit = function() {

    $http.post('api/pages/update/', $.param($scope.page.content))
      .success(function() {
        $rootScope.status.success();
        $state.reload();
      })
      .error(function() {
        $rootScope.status.error();
      })

  };

});

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

app.controller('DeletePageController', function($rootScope, $scope, $state, $http, page) {

  $scope.page = page;

  $scope.submit = function() {

    $http.delete('api/pages/delete/?uri=' + page.uri)
      .success(function() {
        $state.go('page', {uri: page.parent.uri});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

});

app.controller('ChangeUrlController', function($rootScope, $scope, $state, $http, page, $timeout, focus) {

  $scope.page = page;

  $scope.submit = function() {

    $http.post('api/pages/change-url/?uri=' + page.uri + '&uid=' + page.slug)
      .success(function(response) {
        $state.go('page', {uri: response.data.uri});
      })
      .error(function(response) {
        $scope.alert(response.message);
      });

  };

  $scope.convertTitle = function() {

    $http.get('api/slug?string=' + $scope.page.title)
      .success(function(response) {
        $scope.page.slug = response
      });

    focus('ChangeUrlController.page.slug');

  };

});