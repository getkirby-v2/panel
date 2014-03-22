app.directive('editor', function() {
  return {
    restrict: 'E',
    scope: {
      ngModel : '='
    },
    controller: function($scope) {

      $scope.tag = function(editor, open, close, sample) {

        var selection = editor.getSelection();

        console.log(selection);

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

    },
    link : function(scope, element, attrs) {

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

      if(scope['ngModel'] != undefined) {
        codeMirror.setValue(scope['ngModel']);        
      }
      
      // Specialize change event
      codeMirror.on('change', function (instance) {
        scope.ngModel = instance.getValue();
      });

    },
    replace: true,
    template: function($scope) {

      var html = '';
    
      html += '<div>';
      
      /*
      html += '<nav class="form__toolbar">';
      html += '<button tabindex="-1" data-type="tag" data-tag-open="# ">h1</button>';
      html += '<button tabindex="-1" data-type="tag" data-tag-open="## ">h2</button>';
      html += '<button tabindex="-1" data-type="tag" data-tag-open="### ">h3</button>';
      html += '<button tabindex="-1" data-type="tag" data-tag-open="**" data-tag-close="**" data-tag-sample="bold text">bold</button>';
      html += '<button tabindex="-1" data-type="tag" data-tag-open="*" data-tag-close="*" data-tag-sample="italic text">italic</button>';
      html += '<button tabindex="-1">link</button>';
      html += '<button tabindex="-1">email</button>';
      html += '<button tabindex="-1">image</button>';
      html += '</nav>';
      */

      html += '<textarea class="form__input"></textarea>';
      html += '</div>';

      return html;
    }
  }

});