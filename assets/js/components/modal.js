var Modal = function(app) {

  // create a new modal root
  var root = $('<div class="modal" tabindex="0"></div>');

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

  // checks if the modal is opened in an overlay
  var isOverlay = function() {
    return $('.modal').length > 0;
  };

  // initialize all modal events as soon 
  // as the modal content is loaded
  var on = function(returnTo) {

    // make sure everything is clean first
    off();

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

    // setup the form
    var form = content.find('.form');

    // switch to native form 
    // submission on modal pages
    if(!isOverlay()) {
      form.data('autosubmit', 'native');      
    }

    Form(form, {
      focus: true,
      redirect: function(response) {

        if($.type(response) == 'object') {
          if(response.url) {
            if(returnTo) {
              app.content.open(returnTo);                        
            } else {
              app.content.open(response.url);                        
            }            
            return;
          } else if(response.content) {
            replace(response.content);
            return;
          } 
        } 

        window.location.reload();

      }
    });

  };

  var off = function() {

    // stop all delays
    app.delay.stop();

    // make sure to properly remove modal events
    $(document).off('keyup.modal');
    $(window).off('resize.modal');

    // remove all modal keyboard shorcuts
    $.shortcuts.reset();

  };

  // open a modal by url
  var open = function(url, returnTo, onLoad) {

    // close all context menus
    $(document).trigger('click.contextmenu');

    // make sure there's no modal
    close();

    // switch off content events
    // to avoid conflicts    
    app.content.off();

    // load the modal view
    app.load(url, 'modal', function(response) {

      // paste the html into the modal container
      root.html(response.content);

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
      on(returnTo);

    });

  };

  // replace the modal content
  var replace = function(content) {

    // replace the html
    $('.modal-content').parent().html(content);

    // initialize all events
    on();

  };

  // removes the modal root
  var close = function() {

    app.content.scroll.save();

    if(!app.hasModal()) return true;

    // switch off all modal events
    off();

    // kill the modal container
    $('.modal').remove();

    // switch content events back on
    app.content.on();
    app.content.scroll.restore();
    
  };

  // return the modal form element
  var form = function() {
    return $('.modal-content form');
  };

  var setup = function() {

    // init an existing modal on load
    if(app.hasModal()) {      
      on();
    }

  };

  return {
    root: root,
    open: open,  
    close: close,
    replace: replace,
    form: form,
    setup: setup
  };

};