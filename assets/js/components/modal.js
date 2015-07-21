var Modal = function(app) {

  // create a new modal root
  var root = $('<div class="modal"></div>');

  var resize = function() {

    var content = $('.modal-content');
    var form    = content.find('.form');
    
    $(window).data('height', form.outerHeight());

    $(document).on('keyup.modal', function() {
      $(window).data('height', form.outerHeight()).trigger('resize.modal');
    });

    $(window).on('resize.modal', function() {
      if($(window).height() <= $(window).data('height')) {
        content.addClass('modal-content-fixed');
      } else {
        content.removeClass('modal-content-fixed');
      }
    }).trigger('resize.modal');

  };

  // initialize all modal events as soon 
  // as the modal content is loaded
  var events = function(url, returnTo) {

    var content = $('.modal-content');

    // enable modal shortcuts
    content.shortcuts();

    // enable the content resizer
    resize(content);

    // close the modal when the cancel button is being clicked
    content.find('.btn-cancel').on('click', function() {
      if($('.modal').length) {
        close();
        return false;        
      }
    });

    // avoid closing the modal on clicks on the modal content
    content.on('click', function(e) {
      e.stopPropagation();
    });

    // remove any error messages on click
    content.find('.message').on('click', function() {
      content.find('.field-with-error').removeClass('field-with-error');
      $(this).remove();
    });

    // hook up dropzones
    content.find('.dropzone').each(function() {
      var dropzone = $(this);
      dropzone.dropzone(dropzone.data('api'), function() {
        app.content.reload();
      }, function() {
        // TODO: something went wrong
      });
    });

    // setup the form
    Form('.modal-content .form', {
      url: url,
      redirect: function(destination, response) {

        if(url == destination) {
          // replace the modal content
          replace(url, response);          
        } else if(returnTo) {
          // load the returnTo url
          app.content.open(returnTo);              
        } else if(url != destination) {
          // load the new url
          app.content.open(destination);              
        }

      }
    });

  };

  // open a modal by url
  var open = function(url, returnTo, onLoad) {

    // make sure there's no modal first
    close();

    $.ajax({
      url: url,
      headers : {modal : true}
    }).done(function(data, status, xhr) {

      // check for the current user
      var user = xhr.getResponseHeader('X-Panel-User');

      // redirect to the login if the user is missing
      if(!user) window.location.href = 'login';

      // paste the html into the modal container
      root.html(data);

      // add the modal to the body
      $('body').append(root);

      // make sure the modal closes when 
      // the backdrop is being clicked
      root.on('click', function() {
        close();
      });

      if($.type(onLoad) == 'function') {
        onLoad();
      }
  
      // initialize all events
      events(url, returnTo);

    });

  };

  // replace the modal content for the given url
  var replace = function(url, content) {

    // replace the html
    $('.modal-content').parent().html(content);

    // initialize all events
    events(url);

  };

  // removes the modal root
  var close = function() {

    // kill the modal container
    $('.modal').remove();

    // make sure to properly remove modal events
    $(document).off('keyup.modal');
    $(window).off('resize.modal');

    // restore the main shortcuts
    app.content.shortcuts();

  };

  var setup = function() {

    // activates the esc key to close the modal
    $(document).on('keydown', function(e) {
      if(e.keyCode == 27) {
        close();
      }
    });

    // init an existing modal on load
    if($('.modal-content').length > 0) {      
      events(window.location.href, window.location.href);
    }

  };

  return {
    root: root,
    open: open,  
    close: close,
    replace: replace,
    setup: setup
  };

};