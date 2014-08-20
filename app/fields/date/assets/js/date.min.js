(function($) {

  $.fn.date = function() {

    return this.each(function() {

      var input  = $(this).attr('type', 'text');
      var format = input.data('format');
      var val    = input.val();
      var date   = val ? moment(val).format(format) : null;

      input.attr('placeholder', format);
      input.val(date);

      new Pikaday({
        field    : this,
        firstDay : 1,
        format   : format,
        i18n     : input.data('i18n')
      });

    });

  };

})(jQuery);