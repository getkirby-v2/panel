$.shortcuts = {

  events : {},

  add : function(key, event) {
    // don't register an event twice
    if(key in this.events) return true;

    // register the event
    this.events[key] = event;

    // bind it to the document's keydown event
    $(document).bind('keydown.shortcuts', key, function(e) {
      e.preventDefault();
      event(e);
    });

  },

  reset : function() {
    $(document).unbind('keydown.shortcuts');
    this.events = {};
  }

};

$.fn.shortcuts = function() {

  return this.each(function() {

    // register the keyboard shorcuts for this element
    $(this).find('[data-shortcut]').each(function() {

      var item = $(this);
      var key  = item.data('shortcut');

      $.shortcuts.add(key, function(e) {

        if(item.attr('target') == '_blank') {
          window.open(item.attr('href'));
        } else {
          window.location.href = item.attr('href');
        }

      });

    });

  });

};