(function($) {

  $.fn.date = function() {

    return this.each(function() {

      var input  = $(this).attr('type', 'text');
      var hidden = input.next();
      var format = input.data('format');
      var val    = input.val();
      var date   = val ? moment(val).format(format) : null;

      input.attr('placeholder', format);
      input.val(date);
      input.on('change', function() {
        var val = input.val();
        if(val) {
          hidden.val(moment(val, format).format('YYYY-MM-DD'));
        } else {
          hidden.val('');
        }
      });

      new Pikaday({
        field    : this,
        firstDay : 1,
        format   : format,
        i18n     : input.data('i18n'),
        onSelect : function(date) {
          hidden.val(moment(date).format('YYYY-MM-DD'));
        }
      });

    });

  };

})(jQuery);