// configure the application
app.config(function($stateProvider) {

  /** 
   * Pages
   **/
  $stateProvider.state('page', {
    url: '/?uri',
    resolve: {
      page: app.fetchPage
    },
    templateUrl: 'views/page/index.html',       
    controller : 'PageController'
  });

  $stateProvider.state('metatags', {
    url: '/metatags',
    resolve: {
      page: app.fetchPage
    },
    templateUrl: 'views/page/index.html',       
    controller : 'MetatagsController'
  });

  $stateProvider.state('page.modal', {
    abstract : true,
    onEnter : function($rootScope) {
      $rootScope.modal = true;
    },
    onExit : function($rootScope) {
      $rootScope.modal = false;
    }
  });

  $stateProvider.state('page.modal.add', {
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

  $stateProvider.state('page.modal.delete', {
    url: 'delete',
    views: {
      'modal@' : {
        resolve: {
          page: app.fetchPage
        },
        templateUrl: 'views/page/delete.html',
        controller: 'DeletePageController'
      }
    }
  });

  $stateProvider.state('page.modal.url', {
    url: 'url',
    views: {
      'modal@' : {
        resolve: {
          page: app.fetchPage
        },
        templateUrl: 'views/page/url.html',
        controller: 'ChangeUrlController'
      }
    }
  });

});