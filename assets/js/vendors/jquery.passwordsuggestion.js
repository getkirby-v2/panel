(function($) {

  $.suggestPassword = function(length) {

    var length   = length || 32;
    var set      = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#$%&*?';
    var password = '';

    for(x=0; x<length; x++) {
      password += set[Math.floor(set.length * Math.random())];
    }

    return password;

  };

  $.fn.fillPassword = function () {
    return this.each(function() {
      $(this).val($('.pw-suggestion').text());
    });
  };

})(jQuery);