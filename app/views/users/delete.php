<div class="modal-content">
  <form class="form" method="delete">

    <div class="field">
      <label class="label"><?php _l('users.delete.headline') ?></label>
      <p class="input input-is-readonly"><?php __($user->username()) ?></p>
      <p class="field-help marginalia"><?php __($user->email()) ?></p>
    </div>

    <div class="buttons cf">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
      <input class="btn btn-rounded btn-submit btn-negative" type="submit" value="<?php _l('delete') ?>" autofocus>
    </div>

  </form>
</div>