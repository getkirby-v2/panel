$.fn.sidebar = function() {

  return this.each(function() {

    var sidebar = $(this);

    if(localStorage.getItem('sidebar') == 1) {
      sidebar.addClass('sidebar-expanded');
    } else {
      sidebar.removeClass('sidebar-expanded');
    }

    sidebar.find('.sidebar-toggle').on('click', function() {

      if(sidebar.hasClass('sidebar-expanded')) {
        sidebar.removeClass('sidebar-expanded');
        localStorage.sidebar = 0;
      } else {
        sidebar.addClass('sidebar-expanded');
        localStorage.sidebar = 1;
      }

      return false;

    });

    var draggable = sidebar.find('.draggable');

    draggable.draggable({
      helper: function(e, ui) {
        return $('<div class="draggable-helper"></div>');
      },
      start: function(e, ui) {
        ui.helper.text($(this).data('helper'));
      }
    });

    $('.main textarea').droppable({
      hoverClass: 'over',
      accept: draggable,
      drop: function(e, ui) {
        $(this).insertAtCursor(ui.draggable.data('text'));
      }
    });

  });

};