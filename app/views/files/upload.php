<div class="modal-content">
  <div class="form">
    <div class="field">
      <div class="dropzone dropzone-input" autofocus tabindex="0" data-api="<?php __($url) ?>">
        <div class="dropzone-text section">
          <?php if($mode ==  'upload'): ?>
          <h2><?php _l('files.upload.drop') ?></h2>
          <small class="marginalia"><?php _l('files.upload.click') ?></small>
          <?php else: ?>
          <h2><?php _l('files.replace.drop') ?></h2>
          <small class="marginalia"><?php _l('files.replace.click') ?></small>
          <?php endif ?>
        </div>
      </div>
    </div>
    <div class="buttons buttons-centered">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
    </div>
  </div>
</div>