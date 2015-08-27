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

    var form       = $('.main .form');
    var containers = [];

    sidebar.find('.nav-list').each(function() {
      containers.push(this);
    });

    form.find('.field-with-textarea textarea').each(function() {
      containers.push(this);
    });

    var drag = dragula(containers, {
      copy: true,
      moves: function(el, container, handle) {
        return true;
      },
      accepts: function(el, target, source, sibling) {
        return $(target).is('textarea');
      }
    });

    drag.on('over', function(el, target, source) {
      $(target).addClass('over');
    });

    drag.on('out', function(el, target, source) {
      $(target).removeClass('over');
    });

    drag.on('cloned', function(clone, original, type) {

      var handle = $(original).find('.draggable');

      $(clone)
        .removeClass()
        .addClass('draggable-helper')
        .data('text', handle.data('text'))
        .text(handle.data('helper'));

    });

    drag.on('drop', function(el, target, source) {

      var textarea = $(target);
      var handle   = $(el);

      textarea.insertAtCursor(handle.data('text'));
      textarea.removeClass('over');

      handle.remove();

    });

  });

};