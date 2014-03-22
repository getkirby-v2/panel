var app = angular.module('app', ['ui.router', 'kirby.editor', 'kirby.tagbox', 'kirby.date', 'dropzone']);

app.config(function($httpProvider) {
  $httpProvider.interceptors.push('httpRequestInterceptor');
});

app.factory('httpRequestInterceptor', ['$rootScope', function($rootScope) {
  return {
    request: function($config) {
      $config.headers['language'] = $rootScope.language;
      return $config;
    }
  };
}]);

// disable scrolling on state changes
app.value('$anchorScroll', angular.noop);

// global reposition method for modal boxes
app.reposition = function(element) {

  setTimeout(function() {
    var $box = $(element);

    var left = Math.round($box.outerWidth() / 2);    
    var top  = Math.round($box.outerHeight() / 2);    

    $box.css({'opacity' : 0, 'margin-left' : -left, 'margin-top' : -top});    
    $box.animate({'opacity' : 1}, 300);  
  });

};

app.directive('focusOn', function() {
   return function(scope, elem, attr) {
      scope.$on('focusOn', function(e, name) {
        if(name === attr.focusOn) {
          elem[0].focus();
        }
      });
   };
});

app.factory('focus', function($rootScope, $timeout) {
  return function(name) {
    $timeout(function (){
      $rootScope.$broadcast('focusOn', name);
    });
  }
});

// the main app controller
app.controller('AppController', function($rootScope, $scope, $state, $stateParams, $window, $http, $timeout, $location) {

  $rootScope.modal     = false;
  $rootScope.loading   = false;
  $rootScope.language  = localStorage.language || 'de';
  $rootScope.languages = [];

  $http.get('api/site/languages').success(function(response) {
    $rootScope.languages = response;
  });

  $rootScope.setLanguage = function(element) {
    $rootScope.language = element.language;
    localStorage.setItem('language', element.language);
    $state.transitionTo($state.current, $stateParams, {reload: true});
  };

  $rootScope.status = {
    type : 'idle',
    timeout: 2000,
    is: function(type) {
      return ($rootScope.status.type == type) ? true : false;
    },
    idle: function(type) {
      $rootScope.status.type = 'idle';
    },
    success : function() {
      $rootScope.status.type = 'success';
      $timeout(function() {
        $rootScope.status.idle();
      }, $rootScope.status.timeout);
    },
    error : function() {
      $rootScope.status.type = 'error';
      $timeout(function() {
        $rootScope.status.idle();
      }, $rootScope.status.timeout);
    }
  };

  $rootScope.dropdown = {
    current : null, 
    toggle: function(id, $event) {
      $event.stopPropagation();
      if($rootScope.dropdown.isOpen(id)) {
        $rootScope.dropdown.current = null;
      } else {
        $rootScope.dropdown.current = id;
      }
    },
    open: function(id, $event) {
      $event.stopPropagation();
      $rootScope.dropdown.current = id;
    }, 
    close: function() {
      $rootScope.dropdown.current = null;
    },
    isOpen: function(id) {
      return $rootScope.dropdown.current == id;
    }
  };
 
  $rootScope.alert = function(message) {
    $rootScope.message = message;    
  };

  $rootScope.clicks = function() {
    $rootScope.dropdown.close();
  };

  $rootScope.keys = function($event) {
    
    switch($event.keyCode) {
      case 27: // escape
        $rootScope.$emit('key:esc', $event);        
        $rootScope.dropdown.close();
        break;
      case 32: // space
        $rootScope.$emit('key:space', $event);
        break;
      case 13: // enter
        $rootScope.$emit('key:enter', $event);
        break;     
      case 37:
        $rootScope.$emit('key:left', $event);
        break;      
      case 39:
        $rootScope.$emit('key:right', $event);
        break;      
      case 40:
        $rootScope.$emit('key:down', $event);
        break;      
      case 38:
        $rootScope.$emit('key:up', $event);
        break;      
      case 8:
        $rootScope.$emit('key:backspace', $event);
        break;      
    }

  };

});

// the global modal controller
app.controller('ModalController', function($rootScope, $scope, $state, $element) {
              
  $scope.message = null;
  $scope.loading = false;

  $scope.close = function() {
    $scope.message = null;
    $scope.loading = false;
    $state.go('^.^');
  };

  $scope.reposition = function() {
    app.reposition('.modal__box');
  };

  $scope.alert = function(message) {
    $scope.message = message;    
    $scope.reposition();
  };

  $rootScope.$on('key:esc', $scope.close);

  $scope.$on('$viewContentLoaded', function(event) { 
    $scope.reposition();    
  });

});