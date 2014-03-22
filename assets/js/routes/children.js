// configure the application
app.config(function($stateProvider) {

  /**
   * Children
   **/
  $stateProvider.state('children', {
    url: '/children?uri',
    resolve: {
      page: app.fetchPage
    },
    templateUrl: 'views/children/index.html',       
    controller : 'ChildrenController'
  });

  $stateProvider.state('children.modal', {
    abstract : true,
    onEnter : function($rootScope) {
      $rootScope.modal = true;
    },
    onExit : function($rootScope) {
      $rootScope.modal = false;
    }
  });

  $stateProvider.state('children.modal.add', {
    url: 'add',
    views: {
      'modal@' : {
        resolve: {
          page: app.fetchPage,
          templates: app.fetchTemplates
        },
        templateUrl: 'views/page/add.html',
        controller: 'AddPageController'
      }
    }
  });

});