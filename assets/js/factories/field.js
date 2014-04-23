app.factory('field', function() {
  return function(name) {
    return {
      restrict: 'E',
      scope: {
        options: '=',
        model: '='
      },
      templateUrl: 'fields/' + name + '/template.html'
    };    
  }
});