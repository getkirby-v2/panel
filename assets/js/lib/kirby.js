var Dropzone = Dropzone || {};

// stop autoloading of dropzones
Dropzone.autoDiscover = false;

$.fn.dropzone = function(url, done, fail, params) {

  return this.each(function() {

    var options     = params || {};
    var element     = $(this);
    var previews    = element.find('.dropzone-previews');
    var progressbar = element.find('.dropzone-progressbar');
    var error       = false;

    if(!previews.length) {
      var previews = $('<div class="dropzone-previews"></div>');
      element.append(previews);
    }

    if(!progressbar.length) {
      var progressbar = $('<div class="dropzone-progress"><span></span></div>');
      element.append(progressbar);
    }

    element.find('.dropzone-text').addClass('dz-message');

    element.on('keydown', function(e) {
      if(e.keyCode == 13) {
        element.trigger('click');
      }
    });

    previews.hide();

    options.url                   = url;
    options.previewsContainer     = previews[0];
    options.createImageThumbnails = false;

    // create a Dropzone for the element with the given options
    var dropzone = new Dropzone(element[0], options);

    dropzone.on('addedfile', function(file) {
      element.addClass('dropzone-is-loading');
    });

    dropzone.on('maxfilesexceeded', function(e, response) {
      error = 'Too many files!';
    });

    dropzone.on('error', function(e, response) {
      error = response.message;
    });

    dropzone.on('complete', function(r) {

      element.removeClass('dropzone-is-loading');

      if(error) {
        this.removeAllFiles(true);
        fail(error);
        error = false;
      } else if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
        done();
      }

    });

    dropzone.on('totaluploadprogress', function(progress) {
      progressbar.find('span').css({'width' : progress + '%'});
    });

  });

};

/**
 *
 */
var $http = {
  endpoint : '',
  request : function(type, uri, data, done, fail) {
    $[type]($http.endpoint + '/' + uri, data, done).fail(function(r) {
      if(fail) {
        if(r.responseJSON && r.responseJSON.message) {
          fail(r.responseJSON.message, r.responseJSON);
        } else {
          fail('unexpected error', {});
        }
      }
    });
  },
  get : function(uri, data, done, fail) {
    $http.request('get', uri, data, done, fail);
  },
  post : function(uri, data, done, fail) {
    $http.request('post', uri, data, done, fail);
  }
};


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


/**
 * Register shortcuts by element
 */
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


/**
 *
 */
$.fn.serializeObject = function() {
  var o = {};
  var a = this.serializeArray();
  $.each(a, function() {
    if(o[this.name] !== undefined) {
      if(!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });
  return o;
};

$.fn.getSelection = function() {

  var textarea = this[0];

  // IE version
  if(document.selection != undefined) {
    textarea.focus();
    var range     = document.selection.createRange();
    var selection = range.text;

  // Mozilla version
  } else if(textarea.selectionStart != undefined) {
    var start     = textarea.selectionStart;
    var end       = textarea.selectionEnd;
    var selection = textarea.value.substring(start, end);
  }

  return selection;

};

$.fn.insertAtCursor = function (myValue) {
  return this.each(function(){

    // IE support
    if(document.selection) {

      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();

    // Moz / Netscape support
    } else if (this.selectionStart || this.selectionStart == '0') {

      var startPos  = this.selectionStart;
      var endPos    = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;

    } else {

      this.value += myValue;
      this.focus();

    }
  });
};


$.fn.form = function() {

  return this.each(function() {

    var form = $(this);

    form.find('[data-focus=true]').on({
      'click' : function() {
        $(this).find('input, textarea, select').focus();
      },
      'focusin' : function() {
        $(this).addClass('input-is-focused');
      },
      'focusout' : function() {
        $(this).removeClass('input-is-focused');
      }
    });

    form.on('submit', function() {
      form.find('.field-with-error').removeClass('field-with-error');
    });

    form.find('[data-field]').each(function() {
      var el  = $(this);
      var key = el.data('field');
      if(el[key]) el[key]();
    });

    var submit = form.find('.btn-submit');
    var save   = submit.val();

    form.on('success', function() {
      submit.addClass('btn-positive').val(submit.data('saved')).focus();
      setTimeout(function() {
        submit.removeClass('btn-positive').val(save).blur();
      }, 1000);
    });

    form.on('error', function(e, fields) {

      if(fields) {
        $.each(fields, function(i, field) {
          $('#form-field-' + field).parents('.field').addClass('field-with-error');
        });
      }

      setTimeout(function() {
        form.find('.field-with-error .input').focus();
      }, 1);

    });

  });

};


$.fn.breadcrumb = function() {

  return this.each(function() {

    var el = $(this);
    var dropdown = el.clone();

    dropdown.removeClass('breadcrumb');
    dropdown.addClass('dropdown')
            .addClass('dropdown-left')
            .addClass('breadcrumb-dropdown');

    dropdown.attr('id', 'breadcrumb-menu');
    dropdown.find('.nav-icon').remove();
    dropdown.find('.breadcrumb-list').removeClass('nav-bar').removeClass('breadcrumb-list').addClass('dropdown-list');
    dropdown.find('.breadcrumb-link').removeClass('breadcrumb-link');
    dropdown.find('.breadcrumb-label').removeClass('breadcrumb-label');

    el.append(dropdown);

  });

};

$.fn.dropdown = function() {

  return this.each(function() {

    var parent = $(this);

    if(parent.is(document)) {
      // kill all dropdowns when the document is being clicked
      parent.on('click.dropdown', function() {
        parent.find('.dropdown').hide();
      });
      // kill all dropdowns on escape
      parent.on('keydown.dropdown', function(e) {
        if(e.keyCode == 27) parent.trigger('click.dropdown');
      });
      // kill all dropdowns when the browser window is being resized
      $(window).resize(function() {
        parent.find('.dropdown').hide();
      });
    }

    parent.find('.dropdown').hide();
    parent.on('click', '[data-dropdown]', function() {
      $($(this).attr('href')).show();
      return false;
    });

  });

};

$.fn.sidebar = function() {

  return this.each(function() {

    var sidebar = $(this);

    if(localStorage.getItem('sidebar') == 1) {
      sidebar.addClass('sidebar-expanded');
    } else {
      sidebar.removeClass('sidebar-expanded');
    }

    sidebar.find('.sidebar-toggle').on('click', function() {

      if(sidebar.hasClass('sidebar-expanded')) {
        sidebar.removeClass('sidebar-expanded');
        localStorage.sidebar = 0;
      } else {
        sidebar.addClass('sidebar-expanded');
        localStorage.sidebar = 1;
      }

      return false;

    });

  });

};


$.fn.view = function(url, data, callback, error) {

  return this.each(function() {

    var view = $(this);
    var id   = url;

    if($.type(url) == 'string') {

      if($.type(data) == 'function') {
        var d = false;
        var c = data;
        var e = callback;
      } else {
        var d = data;
        var c = callback;
        var e = error;
      }

      // build a full identifier with all data params
      if(d) id += '?' + $.param(d);

      view.trigger('view:beforeload');

      // check if the view has to be reloaded
      if(view.data('current') === id) {
        return true;
      }

      var endpoint = view.data('endpoint') + '/' + url;

      view.load(endpoint, d, function(response, status) {
        if(status == 'error') {
          view.trigger('view:error', [response, url, d]);
          view.data('current', false);
          if($.type(e) == 'function') e(response);
        } else {
          view.trigger('view:load');
          view.data('current', id);
          if($.type(c) == 'function') c(view);
        }
      });

    } else {

      view.on('view:empty', function() {
        view.data('current', false);
        view.empty();
      });

      view.on('view:hide', function() {
        view.data('current', false);
        view.hide();
      });

      view.trigger('view:ready');

    }

  });

};

$.fn.views = function(app, endpoint) {

  return this.each(function() {
    var view = $(this);
    app[view.data('view')] = view.data('endpoint', endpoint).view();
  });

};


$.toSlug = function(string, callback) {
  $http.get('slug/?string=' + string, callback);
};




$.fn.message = function(type, message) {

  return this.each(function() {
    var parent = $(this);

    if(!message) {

      parent.find('.message').remove();
      errors = parent.find('.field-with-error .input');

      if(errors.length) {
        errors.focus();
      } else {
        parent.find('[autofocus]').focus();
      }

    } else {
      parent.message();

      var element = $('<div class="message message-is-' + type + ' cf"><p class="message-content">' + message + '</p><span class="message-toggle"><i>&times;</i></span></div>');

      element.on('click', function() {
        parent.message();
      });

      parent.prepend(element);

    }

  });

};


$.fn.selectRange = function(start, end) {
  if(!end) end = start;
  return this.each(function() {
    if(start == -1) {
      start = end = $(this).val().length;
    }
    if(this.setSelectionRange) {
      this.focus();
      this.setSelectionRange(start, end);
    } else if (this.createTextRange) {
      var range = this.createTextRange();
      range.collapse(true);
      range.moveEnd('character', end);
      range.moveStart('character', start);
      range.select();
    }
  });
};

