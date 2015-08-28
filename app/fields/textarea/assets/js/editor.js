(function($) {

  $.fn.editor = function() {

    return this.each(function() {

      var textarea = $(this);
      var buttons  = textarea.parent().find('.field-buttons');

      // start autosizing
      autosize(textarea);

      buttons.find('.btn').off('click.editorButton').on('click.editorButton', function(e) {

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
        var key = $(this).data('editor-shortcut');
        textarea.bind('keydown', key, function(e) {
          $(el).trigger('click');
          return false;
        });

      });

    });

  };

})(jQuery);