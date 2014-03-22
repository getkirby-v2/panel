app.directive('date', function() {
  return {
    restrict: 'E',
    scope : {
      date : '='
    },
    link : function(scope, element, attrs) {

      // form datepicker
      element.pikaday({ 
        firstDay: 1,
        format: 'YYYY-MM-DD',
        i18n: {
          previousMonth : '&lsaquo;',
          nextMonth     : '&rsaquo;',
          months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
          weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
          weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
        }
      });

    },
    template: function(tElement, tAttrs) {
      return '<input type="text" ng-model="date">';
    },
    replace: true
  };
});