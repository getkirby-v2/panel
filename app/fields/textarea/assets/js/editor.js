(function($) {

  $.fn.editor = function() {

    return this.each(function() {

      if($(this).data('editor')) {
        return $(this);
      }

      var textarea = $(this);
      var buttons  = textarea.parent().find('.field-buttons');

      // start autosizing
      textarea.autosize();

      buttons.find('.btn').on('click.editorButton', function(e) {

        textarea.focus();
        var button = $(this);

        if(button.data('action')) {
          app.modal.open(button.data('action'), window.location.href);
        } else {

          var sel  = textarea.getSelection();
          var tpl  = button.data('tpl');
          var text = button.data('text');

          if(sel.length > 0) text = sel;

          var tag = tpl.replace('{text}', text);

          textarea.insertAtCursor(tag);
          textarea.trigger('autosize.resize');

        }

        return false;

      });

      buttons.find('[data-editor-shortcut]').each(function(i, el) {
        var key    = $(this).data('editor-shortcut');
        var action = function(e) {
          $(el).trigger('click');
          return false;
        };

        textarea.bind('keydown', key, action);

        if(key.match(/meta\+/)) {
          textarea.bind('keydown', key.replace('meta+', 'ctrl+'), action);
        }

      });

      // Catch Tab key and insert it into the textarea
      if(textarea.data('tabs') !== false) {
        textarea.bind('keydown', function(e){
          if(e.keyCode === 9) {
            var tab = '';
            while(tab.length < textarea.data('tabs')){
              tab = tab + ' ';
            }

            // Shift + Tab => outdent
            if (e.shiftKey) {
              var pos = textarea.caret();
              var val = textarea.val();
              if(val.substring((pos - textarea.data('tabs')), pos) === tab) {
                val = val.substring(0, (pos - textarea.data('tabs'))) + val.substring(pos);
                textarea.val(val);
              }
              return false;

            // Tab => indent
            } else if(!e.altKey) {
              textarea.insertAtCursor(tab);
              return false;
            }

            return true;
          }
        });
      }

      textarea.data('editor', true);

    });

  };


  $.fn.caret = function() {
    var target = this[0];

    if (target) {
      if (window.getSelection) {
        return target.selectionStart;
      }

      if (document.selection) {
        target.focus();

        var pos     = 0;
        var range   = target.createTextRange();
        var range2  = document.selection.createRange().duplicate();
        var bookmark = range2.getBookmark();
        range.moveToBookmark(bookmark);
        while (range.moveStart('character', -1) !== 0) {
          pos++;
        }
        return pos;
      }

      if (target.selectionStart) {
        return target.selectionStart;
      }
    }
    //not supported
    return;
  };

})(jQuery);
