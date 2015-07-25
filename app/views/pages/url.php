<div class="modal-content" data-api="<?php _u('api/slug') ?>">
  <?php echo $form ?>
</div>

<script>

var toggle  = $('.modal-content .label a');
var input   = $('.modal-content .input');
var preview = $('.modal-content .uid-preview span');

var toSlug = function(callback) {
  $.get($('.modal-content').data('api'), {string: input.val()}, callback);
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

</script>