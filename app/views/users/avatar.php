<div class="modal-content">
  <div class="form">

    <?php if($uploadable): ?>

      <?php if($user->avatar()): ?>
      <div class="field">
        <figure class="avatar avatar-large avatar-centered"><img src="<?php echo $user->avatar()->url() . '?' . $user->avatar()->modified() ?>"></figure>
      </div>
      <?php endif ?>

      <div class="field">
        <div class="dropzone dropzone-input" autofocus tabindex="0">
          <div class="dropzone-text section">
            <h2><?php _l('users.avatar.drop') ?></h2>
            <small class="marginalia"><?php _l('users.avatar.click') ?></small>
          </div>
        </div>
      </div>

    <?php else: ?>
    <div class="field">
      <label class="label"><?php _l('users.avatar.error.folder.headline') ?></label>
      <p class="text">
        <?php echo l('users.avatar.error.folder.text') ?>
      </p>
    </div>
    <?php endif ?>

    <div class="buttons buttons-centered">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
    </div>
  </div>
</div>