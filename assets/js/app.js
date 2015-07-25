var app = {

  setup: function() {

    // loading bar setup
    NProgress.configure({
      showSpinner: false
    });

    // global delay handler
    app.delay = Delay();

    // the main content area
    app.content = Content(app);
    app.content.setup();

    // modal window handler
    app.modal = Modal(app);
    app.modal.setup();

    // enable context menus
    new Context();  

    // base url
    app.base = $('body').data('base');

    $.ajaxPrefilter(function(options) {
      // convert everything to relative urls      
      options.url = options.url.replace(app.base, '/panel/');
    });

    // event delegation for all clicks on links
    $(document).on('click', 'a', function(e) {      

      var link = $(this);
      var href = link.attr('href');

      if(link.is('[data-dropdown]') || href.match(/^#/)) {
        return true;
      } else {

        // keep form data in the main view if requested
        var form = app.content.element('.form');

        // keep changes on updates to avoid data loss
        if(form.data('keep')) {
          $.post(form.data('keep'), form.serialize());
        }

        if(link.is('[data-modal]')) {
          app.modal.open(link.attr('href'), link.data('modal-return-to'));
          return false;
        } else if(link.is('[target]')) {
          return true;
        } else {
          app.content.open(href);        
          return false;
        }

      }

    });

    // event delegation for all global shortcuts
    $(document).on('keydown', function(e) {

      switch(e.keyCode) {

        // meta+s
        // meta+enter
        case 83:
        case 13:
          if(!e.metaKey) return true;

          // check for an opened modal
          if(app.hasModal()) {
            // submit the modal form
            app.modal.form().trigger('submit');
          } else {
            // submit the main content form
            app.content.form().trigger('submit');
          }

          return false;
          break;

        // esc
        case 27:
          app.modal.close();
          return false;
          break;
      }

    });

    // initialize all dropdowns
    $(document).dropdown();

  },

  // checks if a modal is currently open
  hasModal: function() {
    return $('.modal-content').length > 0;
  },

  // global loading indicator toggle
  isLoading: function(toggle) {
    if(toggle) {
      app.delay.start('loader', function() {
        NProgress.start();
      }, 250);
    } else {
      app.delay.stop('loader');
      NProgress.done();
    }
  }

};

// run the basic app setup
$(function() {
  app.setup();
});