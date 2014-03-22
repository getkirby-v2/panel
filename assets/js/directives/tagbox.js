app.directive('tagbox', function() {
  return {
    restrict: 'E',
    scope : {
      tags : '=', 
      suggestions : '=',
    },
    controller : function($scope, $element, $attrs, $timeout) {

      if(!angular.isArray($scope.tags)) {
        if($scope.tags == undefined || $scope.tags == null) {
          $scope.tags = [];            
          console.log($scope.tags);
        } else {
          var raw = $scope.tags.split(',');
          $scope.tags = [] 
          angular.forEach(raw, function(tag) {
            var tag = $.trim(tag);
            if(tag.length !== 0) $scope.tags.push(tag);
          });
        }
      } 

      if(!angular.isArray($scope.suggestions)) {
        $scope.suggestions = [];
      }

      $scope.tag      = '';
      $scope.selected = '';

      $scope.focus = function() {
        $timeout(function() {
          $element.find('.tagbox__input').focus();
        }, 0);
      };

      $scope.input = function($event) {

        switch($event.keyCode) {
          case 9:   // tab
          case 13:  // enter
          case 188: // ,
            $scope.add();
            $event.preventDefault();
            break;
          case 37: // left arrow
          case 8:  // backspace
            if($scope.tag.length == 0) {
              $scope.select($scope.tags[$scope.tags.length-1]);
            }
            break;
        }

      };

      $scope.add = function() {
        
        // clean the tag
        $scope.tag = $.trim($scope.tag);        
        $scope.selected = '';

        // validate the new tag
        if($scope.tags.indexOf($scope.tag) == -1 && $scope.tag.length > 0) {
          $scope.tags.push($scope.tag);
        } 
          
        // reset the input field
        $scope.tag = '';              

      };

      $scope.remove = function(tag) {

        var old = $scope.tags;
        $scope.tags = [];

        angular.forEach(old, function(t) {
          if(t !== tag) $scope.tags.push(t);
        })

        $timeout(function() {
          $element.find('.tagbox__input').focus();
        }, 0);

      };

      $scope.select = function(tag, $event) {
        if($event) $event.stopPropagation();

        $timeout(function() {
          $element.find('.tagbox__navigator').focus();
          $scope.selected = tag;
        }, 0);
      };

      $scope.deselect = function() {
        $scope.selected = '';
      }

      $scope.navigate = function($event) {
        
        var len  = $scope.tags.length;
        var curr = $scope.tags.indexOf($scope.selected);

        switch($event.keyCode) {
          case 37: // left arrow
            var index = curr-1;
            break;
          case 39: // right arrow
            var index = curr+1;
            break;
          case 8: // backspace
            $scope.remove($scope.selected);
            return;
            break;
        }

        if(index < 0) index = 0;
        
        if(index >= len) {
          $timeout(function() {
            $element.find('.tagbox__input').focus();
          }, 0);
        } else {
          $scope.selected = $scope.tags[index];            
        }

      };

      $scope.suggest = function() {

        // validate the new tag
        if($scope.tags.indexOf($scope.tag) == -1 && $scope.tag.length > 0) {
          $scope.tags[$scope.tags.length - 1] = $scope.tag;
        } else {
          $scope.remove($scope.tags[$scope.tags.length - 1]);
        }
        
        $scope.tag = '';
      
      };

    },
    template: function(tElement, tAttrs) {
      var html  = '<div class="tagbox" ng-click="focus()">';
          html += '<ul class="tagbox__list">';
          html += '<li class="tagbox__tag" ng-class="{selected: tag == selected}" ng-click="select(tag, $event)" ng-repeat="tag in tags">';
          html += '<strong class="tagbox__tag__name">{{tag}}</strong>';
          html += '<button tabindex="-1" class="tagbox__tag__killer" ng-click="remove(tag)">×</button>';
          html += '</li>';
          html += '<li class="visuallyhidden"><input tabindex="-1" type="text" ng-blur="deselect()" ng-keydown="navigate($event)" class="tagbox__navigator"></li>';
          html += '<li class="tagbox__field"><input class="tagbox__input" type="text" ng-focus="deselect()" ng-blur="add()" ng-model="tag" ng-keydown="input($event)" typeahead="suggestion for suggestion in suggestions | filter:$viewValue | limitTo:5" typeahead-on-select="suggest()"></li>';
          html += '</ul>';
          html += '</div>';
      return html;
    },
    replace: true
  };
});