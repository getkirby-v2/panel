/**
 *
 */
var SubpagesController = {
  index: function(uri, vp, ip) {

    // remember the current page
    var visiblePage   = app.store.set(uri + '/visible:', vp, 1);
    var invisiblePage = app.store.set(uri + '/invisible:', ip, 1);

    // redirect to the page uri if it's not set
    if(!vp || !ip)  {

      var url  = '#/subpages/index/';
          url += uri ? uri + '/' : '';
          url += 'visible:' + visiblePage + '/invisible:' + invisiblePage;

      return window.location.replace(url);

    }

    app.main.view('subpages/index/' + uri, {visible: visiblePage, invisible: invisiblePage}, function(element) {

      element.find('.sortable').sortable({
        connectWith: '.sortable',
        update: function() {
          if($(this).attr('id') == 'visible-children') {

            PageModel.sort(uri, visiblePage, $(this).sortable('toArray'), function() {
              app.main.data('current', false);
              routie.reload();
            });

          }
        },
        receive : function(event, ui) {

          if($(this).attr('id') == 'invisible-children') {

            PageModel.hide(uri, ui.item.attr('id'), function() {
              app.main.data('current', false);
              routie.reload();
            });

          }

        }
      }).disableSelection();

    });

  }
};