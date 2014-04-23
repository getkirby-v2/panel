app.directive('field', function() {
  return {
    restrict: 'E',
    replace: true,
    transclude: true,
    scope: {
      icon: '=',
      options: '='
    },
    template: function(element, attrs) {

      html = '<div class="form__field grid__item" ng-class="options.width">';

      html += '<label ng-show="options.label" class="form__label">{{options.label}}</label>';
      html += '<div class="form__inputWrapper">';
      html += '<div ng-transclude></div>';

      if(attrs.icon) {
        html += '<span class="form__inputIcon"><i class="fa fa-' + attrs.icon + '"></i></span>'
      }

      html += '</div>';
      html += '<p ng-show="options.help" class="form__help">{{options.help}}</p>'
      html += '</div>';

      return html;
    }
  }
});