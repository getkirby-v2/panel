app.config(function($stateProvider) {

  /**
   * Files
   **/
  $stateProvider.state('files', {
    url: '/files?uri',
    resolve: {
      page: app.fetchPage
    },
    templateUrl: 'views/files/index.html',       
    controller : 'FilesController'
  });

  $stateProvider.state('file', {
    url: '/files/edit/:filename?uri',
    resolve: {
      page: app.fetchPage,
      file: app.fetchFile
    },
    templateUrl: 'views/files/edit.html',
    controller: 'EditFileController'
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
          page: app.fetchPage
        },
        templateUrl: 'views/files/upload.html',
        controller: 'UploadFileController'
      }
    }
  });

  $stateProvider.state('files.modal.delete', {
    url: '/delete/:filename',
    views: {
      'modal@' : {
        resolve: {
          page: app.fetchPage,
          file: app.fetchFile
        },
        templateUrl: 'views/files/delete.html',
        controller: 'DeleteFileController'
      }
    }
  });

});