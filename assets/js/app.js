// create a simple new app object
var app = {};

// store the main api url for our $http helper
$http.endpoint = 'api';

// cache the most relevant elements
app.nav   = $('#menu-toggle');
app.body  = $('body');
app.doc   = $(document);
app.win   = $(window);
app.views = $('[data-view]');
app.title = document.title;

// init all available views
app.views.views(app, 'views');

// init the modal view
app.modal.hide();

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

  // avoid closing clicks on modal content
  app.modal.find('.modal-content').on('click', function(e) {
    e.stopPropagation();
  });

  // focus the first element in the modal as soon as it is loaded
  app.modal.find('[autofocus]').focus();

});

// make sure the modal is also hidden when it is being emptied
app.modal.on('view:empty', function() {
  app.modal.hide();
});

// create a new close event, which can be triggered from anywhere
app.modal.on('view:close', function() {
  // find the cancel button and hit that
  var url = app.modal.find('.btn-cancel').trigger('click').attr('href');
  if(url) window.location.href = url;
});

setTimeout(function() {
  app.main.find('.loader').show();
}, 250);

// init the main view
app.main.on('view:beforeload', function() {
  // make sure there's no open modal left
  app.modal.trigger('view:empty');
  // reset all old shortcuts
  $.shortcuts.reset();
});

// hook up some default events on load
app.main.on('view:load', function() {

  // register all keyboard shortcuts
  app.main.find('.breadcrumb').breadcrumb();
  app.main.shortcuts();

  app.main.find('.languages .dropdown a').on('click', function() {

    $.ajaxSetup({
      headers: {'language': $(this).data('lang')}
    });

    app.main.data('current', false);
    routie.reload();
    return false;

  });

  var title = $.trim(app.main.find('.breadcrumb-link:last .breadcrumb-label').text());

  if(!title) {
    document.title = app.title;
  } else {
    document.title = app.title + ' | ' + title;
  }

});

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

// start the router
routie(routes);