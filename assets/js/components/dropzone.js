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