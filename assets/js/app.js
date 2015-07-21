var app = {

  loader: false,

  // global blocking loader
  isLoading: function(toggle) {

    if(toggle) {
      if(!app.loader) {
        app.loader = setTimeout(function() {
          $('body').addClass('loading');
        }, 250);
      }
    } else {
      clearTimeout(app.loader);
      app.loader = false;
      $('body').removeClass('loading');
    }

  },

  setup: function() {

    $(document).ajaxStart(function() {
      app.isLoading(true);
    });

    $(document).ajaxStop(function() {
      app.isLoading(false);
    });

    $(document).ajaxError(function() {
      app.isLoading(false);
    });

    app.delay   = Delay();
    app.content = Content(app);
    app.modal   = Modal(app);

    app.content.setup();
    app.modal.setup();

    $(document).on('click', 'a', function(e) {      

      var link = $(this);
      var href = link.attr('href');

      if(link.is('[data-modal]')) {
        app.modal.open(link.attr('href'), link.data('modal-return-to'));
        return false;
      } else if(link.is('[target]') || link.is('[data-dropdown]') || href.match(/^#/)) {
        return true;
      } else {
        app.content.open(href);        
        return false;
      }

    });

    // meta+s
    $(document).on('keydown', function(e) {

      if(e.metaKey && e.keyCode == 83) {

        if($('.modal-content').length) {
          // if there's a modal, store the modal form
          $('.modal-content form').trigger('submit');
        } else {
          // otherwise store the main form 
          $('.main form').trigger('submit');
        }

        return false;

      }

    });

  }

};

$(function() {
  // run the basic app setup
  app.setup();
});