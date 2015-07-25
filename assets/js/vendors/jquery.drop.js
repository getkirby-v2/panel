(function($) {

  $.fn.drop = function(options) {
    if(options == 'destroy') {
      return this.off('dragenter.drop dragover.drop dragexit.drop dragleave.drop dragend.drop drop.drop');
    } else {
      return this.on('dragenter.drop dragover.drop dragexit.drop dragleave.drop dragend.drop drop.drop', function(e) {      
        e.stopPropagation();
        e.preventDefault();
        if(options[e.type]) options[e.type].apply(this, [e]);
      });
    }
  };

})(jQuery);