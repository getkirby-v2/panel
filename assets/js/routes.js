app.config(function($stateProvider, $urlRouterProvider, $locationProvider) {

  //$locationProvider.html5Mode(true);

  $stateProvider.state('layout', {
    abstract : true
  });

  var fetchPage = function($http, $stateParams) {
    return $http.get('api/pages/show?' + $.param({uri: $stateParams.uri})).then(function(response) {
      return response.data
    });

  };

  var fetchFile = function($http, $stateParams) {
    return $http.get('api/files/show?' + $.param({uri: $stateParams.uri, filename: $stateParams.filename})).then(function(response) {
      return response.data;
    });
  };

  var fetchUser = function($http, $stateParams) {
    return $http.get('api/users/show/' + $stateParams.username).then(function(response) {
      return response.data;
    });
  };

  var fetchTemplates = function($http, $stateParams) {
    return $http.get('api/pages/templates?' + $.param({uri: $stateParams.uri})).then(function(response) {
      return response.data;
    });
  };

  /** 
   * Pages
   **/
  $stateProvider.state('page', {
    url: '/?uri',
    resolve: {
      page: fetchPage
    },
    templateUrl: 'views/page/index.html',       
    controller : 'PageController'
  });

  $stateProvider.state('metatags', {
    url: '/metatags',
    resolve: {
      page: fetchPage
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
          page: fetchPage, 
          templates: fetchTemplates
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
          page: fetchPage
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
          page: fetchPage
        },
        templateUrl: 'views/page/url.html',
        controller: 'ChangeUrlController'
      }
    }
  });

  $stateProvider.state('page.modal.upload', {
    url: 'upload',
    views: {
      'modal@' : {
        resolve: {
          page: fetchPage
        },
        templateUrl: 'views/files/upload.html',
        controller: 'UploadFileController'
      }
    }
  });

  $stateProvider.state('page.modal.file', {
    url: 'file/:filename',
    views: {
      'modal@' : {
        resolve: {
          page: fetchPage,
          file: fetchFile
        },
        templateUrl: 'views/files/edit.html',
        controller: 'EditFileController'
      }
    }
  });


  /**
   * Children
   **/
  $stateProvider.state('children', {
    url: '/children?uri',
    resolve: {
      page: fetchPage
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
          page: fetchPage,
          templates: fetchTemplates
        },
        templateUrl: 'views/page/add.html',
        controller: 'AddPageController'
      }
    }
  });


  /**
   * Files
   **/
  $stateProvider.state('files', {
    url: '/files?uri',
    resolve: {
      page: fetchPage
    },
    templateUrl: 'views/files/index.html',       
    controller : 'FilesController'
  });

  $stateProvider.state('files.modal', {
    abstract : true,
    onEnter : function($rootScope) {
      $rootScope.modal = true;
    },
    onExit : function($rootScope) {
      $rootScope.modal = false;
    }
  });

  $stateProvider.state('files.modal.upload', {
    url: '/upload',
    views: {
      'modal@' : {
        resolve: {
          page: fetchPage
        },
        templateUrl: 'views/files/upload.html',
        controller: 'UploadFileController'
      }
    }
  });

  $stateProvider.state('files.modal.edit', {
    url: '/edit/:filename',
    views: {
      'modal@' : {
        resolve: {
          page: fetchPage,
          file: fetchFile
        },
        templateUrl: 'views/files/edit.html',
        controller: 'EditFileController'
      }
    }
  });

  $stateProvider.state('files.modal.delete', {
    url: '/delete/:filename',
    views: {
      'modal@' : {
        resolve: {
          page: fetchPage,
          file: fetchFile
        },
        templateUrl: 'views/files/delete.html',
        controller: 'DeleteFileController'
      }
    }
  });

  /**
   * Users
   */
  $stateProvider.state('users', {
    url: '/users', 
    resolve: {
      users: function($http) {
        return $http.get('api/users').then(function(response) {
          return response.data;
        });
      }
    },
    templateUrl: 'views/users/index.html',        
    controller: 'UsersController'
  });

  $stateProvider.state('users.modal', {
    abstract : true,
    onEnter : function($rootScope) {
      $rootScope.modal = true;
    },
    onExit : function($rootScope) {
      $rootScope.modal = false;
    }
  });

  $stateProvider.state('users.modal.add', {
    url: 'add',
    views: {
      'modal@' : {
        templateUrl: 'views/users/add.html',
        controller: 'AddUserController'
      }
    }
  });

  $stateProvider.state('users.modal.edit', {
    url: '/edit/:username',
    views: {
      'modal@' : {
        resolve: {
          user: fetchUser
        },
        templateUrl: 'views/users/edit.html',
        controller: 'EditUserController'
      }
    }
  });

  $stateProvider.state('users.modal.delete', {
    url: '/delete/:username',
    views: {
      'modal@' : {
        resolve: {
          user: fetchUser
        },
        templateUrl: 'views/users/delete.html',
        controller: 'DeleteUserController'
      }
    }
  });


  /** 
   * Authentication
   **/
  $stateProvider.state('login', {
    url: '/login', 
    templateUrl: 'views/auth/login.html',        
    controller: 'LoginController'
  });

  $stateProvider.state('logout', {
    url: '/logout',
    controller: 'LogoutController'
  });

  /** 
   * Fallback for invalid routes 
   **/
  $urlRouterProvider.otherwise('/login');

});