<div class="modal-content">
  <form class="form" method="delete">

    <input type="hidden" name="page" value="<?php __($p->id()) ?>">

    <div class="field">
      <label class="label"><?php _l('files.delete.headline') ?></label>
      <p class="input input-is-readonly"><?php __($f->filename()) ?></p>
    </div>

    <div class="buttons cf">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
      <input class="btn btn-rounded btn-submit btn-negative" type="submit" value="<?php _l('delete') ?>" autofocus>
    </div>

  </form>
</div>