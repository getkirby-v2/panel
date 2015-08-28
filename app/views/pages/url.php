<div class="modal-content" data-api="<?php _u('api/slug') ?>">
  <?php echo $form ?>
</div>

<script>

(function() {

  var modal   = $('.modal-content');
  var toggle  = modal.find('.label a');
  var input   = modal.find('.input');
  var preview = modal.find('.uid-preview span');
  var api     = modal.data('api');

  var toSlug = function(callback) {
    $.post(api, {string: input.val()}, function(response) {
      if($.type(response) == 'object' && response.slug) {
        callback(response.slug);        
      } else {
        callback(input.val());
      }
    });
  };

  toggle.on('click', function() {
    input.val(toggle.data('title')).trigger('blur').focus();
    return false;
  });

  input.on('keyup', function() {
    toSlug(function(slug) {
      preview.text(slug);
    });
  });

  input.on('blur', function() {
    toSlug(function(slug) {
      input.val(slug);
      preview.text(slug);
    });  
  });

})();

</script>