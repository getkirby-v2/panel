(function($) {

  $.fn.editor = function() {

    return this.each(function() {

      var textarea = $(this).autosize();
      var buttons  = textarea.parent().find('.field-buttons');

      buttons.find('.btn').on('click', function(e) {

        textarea.focus();
        var button = $(this);

        if(button.data('action')) {

          EditorController[button.data('action')](textarea, button);

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

      textarea.bind('keydown', 'meta+return', function() {
        textarea.parents('.form').trigger('submit');
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