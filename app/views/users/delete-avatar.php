<div class="modal-content">
  <form class="form" method="delete">

    <div class="field">

      <?php if($user->avatar()): ?>
      <figure class="avatar avatar-full avatar-centered"><img src="<?php echo $user->avatar()->url() . '?' . $user->avatar()->modified() ?>"></figure>
      <?php endif ?>

    </div>

    <div class="buttons buttons-centered cf">
      <a class="btn btn-rounded btn-cancel" href="<?php _u($user, 'edit') ?>"><?php _l('cancel') ?></a>
      <input class="btn btn-rounded btn-submit btn-negative" type="submit" value="<?php _l('delete') ?>" autofocus>
    </div>

  </form>
</div>