<div class="modal-content">

  <form class="form" action="<?php __($url) ?>" method="post" enctype="multipart/form-data">

    <div class="dropload">

      <label class="dropload-text section" for="file">
        <?php if($mode ==  'upload'): ?>
        <strong><?php _l('files.upload.drop') ?></strong>
        <small class="marginalia"><?php _l('files.upload.click') ?></small>
        <?php else: ?>
        <strong><?php _l('files.replace.drop') ?></strong>
        <small class="marginalia"><?php _l('files.replace.click') ?></small>
        <?php endif ?>
      </label>

      <input id="file" type="file" name="file" multiple>

    </div>

    <div class="buttons buttons-centered">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
    </div>

  </form>

</div>
<script>

if($.support.dropload) {

  // use the is-active class to hide the old school
  // form elements and show the drag & drop instructions
  $('.dropload').addClass('is-active').dropload({
    progress : function(progress) {
      // update your progress bar here
    },
    complete : function(files) {
      //app.modal.close();
      // do something when all uploads are finished
    }
  });

}

</script>