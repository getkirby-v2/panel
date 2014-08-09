/**
 *
 */
var PagesController = {
  show: function(uri, p, callback) {

    if(uri == '') {
      DashboardController.index();
      return;
    }

    // remember the current page
    var page = app.store.set(uri + '/p:', p, 1);

    // redirect to the page uri if it's not set
    if(!p) {
      return window.location.replace('#/pages/show/' + uri + '/p:' + page);
    }

    app.main.view('pages/show/' + uri, {page: page}, function(element) {

      var form = element.find('.form').form();

      form.on('submit', function() {
        PageModel.update(uri, form.serializeObject(), function(response) {

          if(response.data.uri != uri) {
            return window.location.href = '#/pages/show/' + response.data.uri;
          }

          app.main.data('current', false);

          PagesController.show(uri, page, function(element) {
            element.find('.form').trigger('success');
          });

        }, function(message, response) {
          form.trigger('error', [response.data.fields]);
          form.message('alert', message);
        });
        return false;
      });

      element.find('.sidebar').sidebar();

      var textareas = element.find('textarea');
      var draggable = element.find('.draggable');

      draggable.draggable({
        helper: function(e, ui) {
          return $('<div class="draggable-helper"></div>');
        },
        start: function(e, ui) {
          ui.helper.text($(this).data('helper'));
        }
      });

      textareas.droppable({
        hoverClass: 'over',
        accept: draggable,
        drop: function(e, ui) {
          $(this).insertAtCursor(ui.draggable.data('text'));
        }
      });

      if($.type(callback) == 'function') callback(element);

      element.find('[data-element=retry-button]').on('click', function() {
        window.location.reload();
        return true;
      });

    });

  },
  add : function(uri, to) {

    switch(to) {
      case 'subpages':
        SubpagesController.index(uri, app.store.get(uri + '/visible:', 1), app.store.get(uri + '/invisible:', 1));
        break;
      case 'dashboard':
        DashboardController.index(uri);
        break;
      default:
        PagesController.show(uri, app.store.get(uri + '/p:', 1));
        break;
    }

    app.modal.view('pages/add/' + uri, {to: to}, function(element) {

      element.find('.form').form().on('submit', function() {
        PageModel.create(uri, $(this).serializeObject(), function() {
          app.main.data('current', false);
          app.modal.close();
        }, app.modal.alert);
        return false;
      });

      var elements = {
        title : element.find('input[name=title]'),
        uid   : element.find('input[name=uid]')
      };

      elements.title.on('keyup', function() {
        var val = elements.title.val();
        $.toSlug(val, function(slug) {
          elements.uid.val(slug);
        });
      });

      elements.uid.on('blur', function() {
        $.toSlug(elements.uid.val(), function(slug) {
          elements.uid.val(slug);
        });
      });

    });

  },

  url : function(uri) {

    PagesController.show(uri, app.store.get(uri + '/p:', 1));

    app.modal.view('pages/url/' + uri, function(element) {

      element.find('.form').on('submit', function() {
        PageModel.url(uri, $(this).serializeObject(), function(response) {
          window.location.href = '#/pages/show/' + response.data.uri;
        }, app.modal.alert);
        return false;
      });

      var elements = {
        toggle  : element.find('[data-element=toggle]'),
        input   : element.find('[data-element=input]'),
        preview : element.find('[data-element=preview]')
      };

      elements.toggle.on('click', function() {
        elements.input.val(elements.toggle.data('title')).trigger('blur').focus();
        return false;
      });

      elements.input.on('keyup', function() {
        $.toSlug(elements.input.val(), function(slug) {
          elements.preview.text(slug);
        });
      });

      elements.input.on('blur', function() {
        $.toSlug(elements.input.val(), function(slug) {
          elements.input.val(slug);
          elements.preview.text(slug);
        });
      });

    });

  },

  delete: function(uri, to) {

    // get the uri for the parent page
    var parent = uri.split('/').slice(0, -1).join('/');

    switch(to) {
      case 'subpages':
        SubpagesController.index(parent, app.store.get(parent + '/visible:', 1), app.store.get(parent + '/invisible:', 1));
        var back = '#/subpages/index/' + parent;
        break;
      default:
        PagesController.show(uri, app.store.get(uri + '/p:', 1));
        var back = '#/pages/show/' + parent;
        break;
    }

    app.modal.view('pages/delete/' + uri, {to: to}, function(element) {

      element.find('.form').on('submit', function() {

        PageModel.delete(uri, function() {
          app.main.data('current', false);
          window.location.href = back;
        }, app.modal.alert);

        return false;

      });

    });

  },
  search: function(uri) {

    if(!uri) uri = '';

    app.main.view('pages/search/' + uri, function(element) {

      var input        = element.find('.search-input');
      var hint         = element.find('.search-help').hide();
      var help         = hint.data('help');
      var noresults    = hint.data('noresults');

      input.autocomplete(element.find('.search-dropdown'));
      input.on({
        'keydown' : function(e) {
          if(e.keyCode == 27) {
            window.location.href = $('#topbar [data-shortcut=esc]').attr('href');
            return false;
          }
        },
        'autocomplete:add' : function() {
          var uri = $(this).val();
          if(uri) {
            window.location.href = '#/pages/show/' + uri;
          }
        },
        'autocomplete:search' : function() {
          hint.hide();
        },
        'autocomplete:empty autocomplete:close' : function() {
          hint.show();
          hint.text(help);
        },
        'autocomplete:noresults' : function() {
          hint.show();
          hint.text(noresults);
        }
      });
      input.trigger('autocomplete:empty');
      input.focus();
      input.selectRange(-1);

    });

  }
};