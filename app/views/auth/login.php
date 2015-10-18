<div class="modal-content">
  <?php echo $form ?>
</div> 

<script>

(function() {  
  
  $('.message').message();

  $('.form').on('submit', function() {
    $(this).addClass('loading');
  });

})();

</script>