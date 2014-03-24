// the main app controller
app.controller('AppController', function($rootScope, $scope, $state, $stateParams, $window, $http, $timeout, $location) {

  $rootScope.modal     = false;
  $rootScope.loading   = false;
  $rootScope.language  = localStorage.language || $window.defaultLanguage;
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