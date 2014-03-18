function tag(editor, open, close, sample) {

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
    tag(cm, '**', '**', 'bold text');
  },
  'Cmd-I' : function(cm) {
    tag(cm, '*', '*', 'italic text');
  },
  fallthrough: ['default']
};

angular.module('kirby.editor', [])
  .directive('editor', function() {

  return {
    restrict: 'A',
    scope: {
      ngModel : '='
    },
    link : function(scope, element, attrs) {

      var codeMirror = CodeMirror.fromTextArea(element[0], {
        theme: 'kirby',
        mode: 'gfm',
        lineNumbers: false,
        lineWrapping: true,
        viewportMargin: Infinity,
        keyMap: 'kirby'
      });

      if(scope['ngModel'] != undefined) {
        codeMirror.setValue(scope['ngModel']);        
      }
      
      // Specialize change event
      codeMirror.on('change', function (instance) {
        scope.ngModel = instance.getValue();
      });

    }
  }

});