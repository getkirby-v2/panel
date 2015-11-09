(function ($) {
    'use strict';
    if (!String.prototype.trim) {
        String.prototype.trim = function () {
            return this.replace(/^\s+|\s+$/g, '');
        };
    }
    $.fn.counter = function () {
        return this.each(function () {
            var counter = $(this),
                field = $('[name="' + counter.data('count') + '"]'),
                length = field.val().length,
                max = field.data('max'),
                min = field.data('min');
            field.keyup(function () {
                length = field.val().trim().length;
                counter.text(length + (max ? '/' + max : ''));
                if ((max && length > max) || (min && length < min)) {
                    counter.addClass('outside-range');
                } else {
                    counter.removeClass('outside-range');
                }
            });
        });
    };
}(jQuery));
