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
    templateUrl: 'views/pages/index.html',
    controller : 'PageController'
  });

  $stateProvider.state('metatags', {
    url: '/metatags',
    resolve: {
      page: app.fetchPage
    },
    templateUrl: 'views/pages/index.html',
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
        templateUrl: 'views/pages/add.html',
        controller: 'AddPageController'
      }
    }
  });

  $stateProvider.state('page.modal.publish', {
    url: 'publish',
    views: {
      'modal@' : {
        templateUrl: 'views/pages/publish.html',
        controller: 'PublishController'
      }
    }
  });

  $stateProvider.state('page.modal.upload', {
    url: 'upload',
    views: {
      'modal@' : {
        resolve: {
          page: app.fetchPage
        },
        templateUrl: 'views/files/upload.html',
        controller: 'UploadFileController'
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
        templateUrl: 'views/pages/delete.html',
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
        templateUrl: 'views/pages/url.html',
        controller: 'ChangeUrlController'
      }
    }
  });

});