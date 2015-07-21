(function($) {

  var Structure = function(element) {

    var element = $(element);
    var list    = element.find('.structure-entries');
    var entries = element.find('.structure-entry');
    var sortApi = element.data('sort-api');

    if(element.data('sortable') == true && list.find('.structure-entry').length > 1) {

      list.sortable({
        update: function() {
          var ids = list.sortable('toArray').map(function(entry) {
            return entry.replace('structure-entry-', '');
          });
          $.post(sortApi, {ids: ids});
        }
      }).disableSelection();

    }

  };

  $.fn.structure = function() {

    return this.each(function() {

      if($(this).data('structure')) {
        return $(this).data('structure');
      } else {
        var structure = new Structure(this);
        $(this).data('structure', structure);
        return structure;
      }

    });

  };

})(jQuery);