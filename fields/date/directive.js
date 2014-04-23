app.directive('datefield', function(field) {  

  var field = field('date');

  field.link = function(scope, element, attrs) {

    // form datepicker
    element.find('input').pikaday({ 
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

  };

  return field;    

});