app.directive('textareafield', function(field) {
  var field = field('textarea');

  field.controller = function($scope) {

    $scope.tag = function(editor, open, close, sample) {

      var selection = editor.getSelection();

      if(selection) sample = selection;

      if(!sample) sample = '';
      if(!close)  close  = '';

      var tag = open + sample + close;

      editor.replaceSelection(tag);
      editor.setCursor(editor.getCursor());
      editor.focus();

    };

    CodeMirror.keyMap.kirby = {
      'Cmd-B' : function(cm) {
        $scope.tag(cm, '**', '**', 'bold text');
      },
      'Cmd-I' : function(cm) {
        $scope.tag(cm, '*', '*', 'italic text');
      },
      fallthrough: ['default']
    };

  };

  field.link = function(scope, element, attrs) {

    var codeMirror = CodeMirror.fromTextArea(element.find('textarea')[0], {
      theme: 'kirby',
      mode: 'gfm',
      lineNumbers: false,
      lineWrapping: true,
      viewportMargin: Infinity,
      keyMap: 'kirby'
    });

    element.find('button').on('click', function() {

      codeMirror.focus();

      var $this  = $(this);
      var open   = $this.data('tag-open');
      var close  = $this.data('tag-close');
      var sample = $this.data('tag-sample');

      scope.tag(codeMirror, open, close, sample);
      return false;

    });

    codeMirror.setValue(scope.model);

    // Specialize change event
    codeMirror.on('change', function (instance) {
      scope.model = instance.getValue();
    });

  };

  return field;
});