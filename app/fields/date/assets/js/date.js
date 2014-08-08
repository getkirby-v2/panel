(function($) {

  $.fn.date = function() {

    return this.each(function() {

      $(this).attr('type', 'text');

      var navigatePicker = function(picker, keycode, selectedDate) {
        switch (keycode) {
          // Left
          case 37:
            var prevDay = moment(selectedDate).subtract("days", 1).toDate();
            picker.setDate(prevDay);
            break;
          // Right
          case 39:
            var nextDay = moment(selectedDate).add("days", 1).toDate();
            picker.setDate(nextDay);
            break;
          // Top
          case 38:
            var prevWeek = moment(selectedDate).subtract("weeks", 1).toDate();
            picker.setDate(prevWeek);
            break;
          // Down
          case 40:
            var nextWeek = moment(selectedDate).add("weeks", 1).toDate();
            picker.setDate(nextWeek);
            break;
          // Esc or Enter
          case 13:
          case 27:
            picker.hide();
            break;
        }
      };


      new Pikaday({
        onOpen: function() {
          var picker = this;
          $(document).on('keydown.pikaday', function(e) {
            e.preventDefault();
            var selectedDate = picker.getDate();
            navigatePicker(picker, e.keyCode, selectedDate);
          });
        },
        onClose: function() {
          // Unbind Arrow Keys
          $(document).off('.pikaday');
        },
        field: this,
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

    });

  };

})(jQuery);