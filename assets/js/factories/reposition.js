app.factory('reposition', function($timeout) {
  return function(element) {

    $timeout(function() {
      var $box = $(element);

      var left = Math.round($box.outerWidth() / 2);    
      var top  = Math.round($box.outerHeight() / 2);    

      $box.css({'opacity' : 0, 'margin-left' : -left, 'margin-top' : -top});    
      $box.animate({'opacity' : 1}, 300);  
    });

  };
});