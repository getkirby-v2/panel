<div class="modal-content modal-content-medium" data-api="<?php _u('api/slug') ?>">
  <?php echo $form ?>
</div>

<script>

(function() {

  var modal = $('.modal-content');
  var title = modal.find('[name=title]');
  var uid   = modal.find('[name=uid]');
  var api   = modal.data('api');

  var toSlug = function(string, callback) {
    $.post(api, {string: string}, function(response) {
      if($.type(response) == 'object' && response.slug) {
        callback(response.slug);        
      } else {
        callback(title.val());
      }
    });
  };

  title.on('keyup', function() {
    toSlug(title.val(), function(slug) {
      uid.val(slug);
    });
  });

  uid.on('blur', function() {
    toSlug(uid.val(), function(slug) {
      uid.val(slug);
    });
  });

})();

</script>