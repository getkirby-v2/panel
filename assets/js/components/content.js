var Content = function() {

  var root = $('.main');

  var element = function(selector) {
    return root.find(selector);
  };

  var focus = Focus();

  var on = function() {

    // make sure everything is nice and clean first
    off();

    // setup the breadcrumb mobile version
    element('.breadcrumb').breadcrumb();

    // setup the sidebar toggle
    element('.sidebar').sidebar();

    // register all keyboard shortcuts within the main container
    root.shortcuts();

    app.delay.start('message', function() {
      element('.message-is-notice').trigger('click');
    }, 3000);

    element('.message a, .message').on('click', function(e) {
      element('.mainbar .field-with-error').removeClass('field-with-error');
      element('.message').remove();
      app.delay.stop('message');
      return false;
    });

    // hook up the main form
    Form('.main .form', {
      redirect: function(response) {
        if($.type(response) == 'object' && response.url) {
          app.content.open(response.url);                        
        } else {
          app.content.replace(response);
        }
      }
    });

    // recall the focus and caret position
    focus.on('.main .form');

  };

  // clean all registered events and remove generated elements
  var off = function() {
    
    // stop all delays
    app.delay.stop();

    // stop caret recording
    focus.off();

    // remove all shortcuts
    $(document).unbind('keydown.shortcuts');

    // remove all uncleaned elements
    $('body').children().not('.main').remove();

    // remove window resizing events
    $(window).off('resize');

  };

  var open = function(url, state) {

    app.load(url, 'content', function(response) {
      // handle redirects
      if(response.url) {
        open(response.url);
      } else {
        replace(response.content, url);
      }
    });

  };

  var replace = function(content, url) {

    app.modal.close();      

    var scrollSidebar = element('.sidebar').scrollTop();
    var scrollMainbar = element('.mainbar').scrollTop();

    root.html(content);    

    // change the history
    if(url) {
      focus.forget();            
      if(window.location.href != url) {                
        try {
          path = url.replace(window.location.origin, '');
          window.history.pushState({path: path}, document.title, path);                    
        } catch(e) {
          window.location.href = url;
        }
      }
    }

    // switch on all events for the mainbar
    on();

    if(element('.mainbar')[0]) element('.mainbar')[0].scrollTop = scrollMainbar;
    if(element('.sidebar')[0]) element('.sidebar')[0].scrollTop = scrollSidebar;

  };

  var reload = function() {
    open(document.location);
  };

  var shortcuts = function() {
    root.shortcuts();
  };

  var form = function() {
    return $('.main .form');
  };

  var setup = function() {

    $(window).on('popstate', function(e) {      
      open(document.location);
    });

    on();

  };

  return {
    root : root,
    element: element,
    on: on,
    off: off,
    open: open,
    replace: replace,
    reload: reload,
    shortcuts: shortcuts,
    form: form,
    focus: focus,
    setup: setup
  };

};