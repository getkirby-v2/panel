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
        update: function(e, ui) {

          var $this = $(this);

          if($this.attr('id') == 'visible-children') {

            var start = parseInt($this.data('start'));
            var total = $this.data('total');
            var flip  = $this.data('flip');
            var index = $this.find('.item').index(ui.item);
            var id    = ui.item.attr('id');

            if(flip == '1') {
              // if this is an invisible element the 
              // total number of items in the visible list has
              // to be adjusted to get the right result for the
              // sorting number
              if(ui.sender && ui.sender.attr('id') == 'invisible-children') {
                total++;
              }
              var to = total - start - index + 1;
            } else {
              var to = index + start;              
            }
  
            if(ui.item.parent().attr('id') !== 'invisible-children') {

              PageModel.sort(uri, id, to, function() {
                app.main.data('current', false);
                routie.reload();
              });

            }

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