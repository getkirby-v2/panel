$(function() {

  // cache the most relevant elements
  app.nav   = $('#menu-toggle');
  app.views = $('[data-view]');

  // init all available views
  app.views.views(app, 'views');

  // storage for the loader interval
  app.loader = false;

  // global blocking loader
  app.isLoading = function(toggle) {

    if(toggle) {
      if(!app.loader) {
        app.loader = setTimeout(function() {
          app.body.addClass('loading');
        }, 250);
      }
    } else {
      clearTimeout(app.loader);
      app.loader = false;
      app.body.removeClass('loading');
    }

  };

  app.doc.ajaxStart(function() {
    app.isLoading(true);
  });

  app.doc.ajaxStop(function() {
    app.isLoading(false);
  });

  app.doc.ajaxError(function() {
    app.isLoading(false);
  });

  // init the modal view
  app.modal.hide();

  // a click on the modal background will close the modal
  app.modal.on('click', function() {
    app.modal.trigger('view:close');
  });

  // a custom method to handle modal alerts
  app.modal.alert = function(message) {
    app.modal.find('.modal-content').message('alert', message);
  };

  app.modal.close = function() {
    app.modal.trigger('view:close');
  };

  // set some defaults when the modal is loaded
  app.modal.on('view:load', function() {

    // show the modal container
    app.modal.show();

    $('body').css('overflow', 'hidden');

    var $window  = $(window);
    var $content = app.modal.find('.modal-content');
    var $form    = $content.find('.form');
    
    $window.data('height', $form.outerHeight());

    $(document).on('keyup.modal', function() {
      $window.data('height', $form.outerHeight()).trigger('resize.modal');
    });

    $window.on('resize.modal', function() {
      if($window.height() <= $window.data('height')) {
        $content.addClass('modal-content-fixed');
      } else {
        $content.removeClass('modal-content-fixed');
      }
    }).trigger('resize.modal');

    // avoid closing clicks on modal content
    $content.on('click', function(e) {
      e.stopPropagation();
    });

    // focus the first element in the modal as soon as it is loaded
    $content.find('[autofocus]').focus();

  });

  // make sure the modal is also hidden when it is being emptied
  app.modal.on('view:empty', function() {
    app.modal.hide();
    $(window).off('resize.modal');
    $(document).off('keyup.modal');
    $('body').css('overflow', 'initial');
  });

  // create a new close event, which can be triggered from anywhere
  app.modal.on('view:close', function() {
    // find the cancel button and hit that
    var url = app.modal.find('.btn-cancel').trigger('click').attr('href');
    debugger
    if(url) window.location.href = url;
  });

  // register all keyboard shortcuts
  app.doc.find('.breadcrumb').breadcrumb();
  app.doc.shortcuts();

  // init all global dropdowns
  app.doc.dropdown();

  // esc key to hide the modal and clean everything
  app.doc.on('keydown', function(e) {
    if(e.keyCode == 27) {
      app.modal.trigger('view:close');
    }
  });

  // popup helper
  app.popup = {

    show : function(view, data, init, cancel) {

      app.modal.view(view, data, function(element) {

        element.find('.btn-cancel').on('click', function() {
          app.popup.hide();
          if(cancel) cancel();
          return false;
        });

        if(init) init(element);

      });

    },

    form : function(view, data, init, submit, cancel) {

      app.popup.show(view, data, function(element) {

        element.find('.form').form().on('submit', function() {
          var form = $(this);
          submit(form, form.serializeObject());
          app.popup.hide();
          return false;
        });

      }, cancel);

    },

    hide: function() {
      app.modal.trigger('view:empty');
    }

  };

  app.store = {
    data: {},
    set: function(id, value, fallback) {
      if(!value && app.store.data[id]) value = app.store.data[id];
      if(!value) value = fallback;
      return app.store.data[id] = value;
    },
    get: function id(id, fallback) {
      return app.store.data[id] || fallback;
    }
  };

});