$.fn.views = function(app, endpoint) {

  return this.each(function() {
    var view = $(this);
    app[view.data('view')] = view.data('endpoint', endpoint).view();
  });

};