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
        } else if(form.data('kirbytext')) {
          var tag = '(link: ' + data.url + ')';
        } else {
          var tag = '<' + data.url + '>';
        }
      } else if(form.data('kirbytext')) {
        var tag = '(link: ' + data.url + ' text: ' + data.text + ')';
      } else {
        var tag = '[' + data.text + '](' + data.url + ')';
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
      } else if(form.data('kirbytext')) {
        var tag = '(email: ' + data.address + ' text: ' + data.text + ')';
      } else {
        var tag = '[' + data.text + '](mailto:' + data.address + ')';
      }
      textarea.insertAtCursor(tag);
    }, function() { textarea.focus() });

  },

  uri : function() {
    return window.location.hash.replace('#/', '');
  }

};