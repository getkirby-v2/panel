var Content = function() {

  var root = $('.main');

  var element = function(selector) {
    return root.find(selector);
  };

  var events = function() {

    // stop all delays
    app.delay.stop();

    element('.breadcrumb').breadcrumb();
    element('.sidebar').sidebar();

    $(document).dropdown();
    $(document).shortcuts();

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
    Form('.main .form');

  };

  var clean = function() {

    // remove all uncleaned elements
    $('body').children().not('.main').remove();

    // remove window resizing events
    $(window).off('resize');

  };

  var open = function(url, state) {

    clean();

    app.modal.close();

    $.ajax({
      url: url,
      dataType: 'html',
      success: function(response, status, xhr) {

        // check for the current user
        var user = xhr.getResponseHeader('X-Panel-User');

        // redirect to the login if the user is missing
        if(!user) window.location.href = 'login';

        document.title = $(response).filter('title').first().text();

        if(!state || state == true) {            
          // TODO: state without that stupid error
          window.history.pushState({}, document.title, url);            
        }

        // check for the final url to handle redirects appropriately
        var destination = xhr.getResponseHeader('X-Panel-Location');

        if(window.location.href != destination) {
          open(destination);
        } else {
          replace(response);
        }

      }
    });

  };

  var replace = function(html) {

    var scrollSidebar = element('.sidebar').scrollTop();
    var scrollMainbar = element('.mainbar').scrollTop();

    var focused = element('.input:focus');

    if(focused.length > 0) {
      var caret     = focused.caret().end;        
      var focusedId = focused.attr('id');
    } else {
      var caret     = 0;
      var focusedId = false
    }
    
    root.html(html);    

    events();

    if(focusedId) {
      focused = $('#' + focusedId);
      focused.caret(caret);
      focused.focus();
    }

    if(element('.mainbar')[0]) element('.mainbar')[0].scrollTop = scrollMainbar;
    if(element('.sidebar')[0]) element('.sidebar')[0].scrollTop = scrollSidebar;

  };

  var reload = function() {
    open(document.location);
  };

  var shortcuts = function() {
    root.shortcuts();
  };

  var setup = function() {

    if(!$(window).data('history')) {
      $(window).data('history', true).on('popstate', function(e) {      
        open(document.location, false);
      });
    }

    events();

  };

  return {
    root : root,
    element: element,
    events: events,
    open: open,
    replace: replace,
    reload: reload,
    shortcuts: shortcuts,
    setup: setup
  };

};