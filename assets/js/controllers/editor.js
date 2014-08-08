var EditorController = {

  link : function(textarea) {

    var selection = $(textarea).getSelection();
    var data      = {};

    if(selection.length) {
      if(selection.match(/^http|s\:\/\//)) {
        data.url = selection;
      } else {
        data.text = selection;
      }
    }

    app.popup.form('editor/link/' + this.uri(), data, null, function(form, data) {
      if(!data.text.length) {
        if(data.url.match(/^http|s\:\/\//)) {
          var tag = '<' + data.url + '>';
        } else {
          var tag = '(link: ' + data.url + ')';
        }
      } else {
        var tag = '(link: ' + data.url + ' text: ' + data.text + ')';
      }
      textarea.insertAtCursor(tag);
    }, function() { textarea.focus() });

  },

  email : function(textarea) {

    var selection = $(textarea).getSelection();
    var data      = {};

    if(selection.length) {
      if(selection.match(/\@/)) {
        data.address = selection;
      } else {
        data.text = selection;
      }
    }

    app.popup.form('editor/email/' + this.uri(), data, null, function(form, data) {
      if(!data.text.length) {
        var tag = '<' + data.address + '>';
      } else {
        var tag = '(email: ' + data.address + ' text: ' + data.text + ')';
      }
      textarea.insertAtCursor(tag);
    }, function() { textarea.focus() });

  },

  image : function(textarea) {

    app.popup.form('editor/image/' + this.uri(), {}, function(element) {
      element.find('.item').disableSelection().on('dblclick', function() {
        element.find('.form').trigger('submit');
      });
    }, function(form, data) {
      textarea.insertAtCursor('(image: ' + data.image + ')');
    }, function() { textarea.focus() });

  },

  file : function(textarea) {

    app.popup.form('editor/file/' + this.uri(), {}, function(element) {
      element.find('.item').disableSelection().on('dblclick', function() {
        element.find('.form').trigger('submit');
      });
    }, function(form, data) {
      textarea.insertAtCursor('(file: ' + data.file + ')');
    }, function() { textarea.focus() });

  },

  uri : function() {
    return window.location.hash.replace('#/', '');
  }

};