(function($) {

  $.fn.counter = function() {

    return this.each(function() {

      var counter = $(this);

      if(counter.data('counter')) {
        return counter;
      }

      var field  = counter.parent('.field').find('.input');
      var length = $.trim(field.val()).replace(/\r(?!\n)|\n(?!\r)/g, '\r\n').length;
      var max    = field.data('max');
      var min    = field.data('min');
      
      field.keyup(function() {
        length = $.trim(field.val()).replace(/\r(?!\n)|\n(?!\r)/g, '\r\n').length;
        counter.text(length + (max ? '/' + max : ''));
        if((max && length > max) || (min && length < min)) {
          counter.addClass('outside-range');
        } else {
          counter.removeClass('outside-range');
        }
      }).trigger('keyup');

      counter.data('counter', true);

    });

  };

}(jQuery));