<div class="modal-content">
  <form class="form" method="post">
    <?php if($error): ?>
    <div class="field">
      <label class="label"><?php __($error['headline']) ?></label>
      <div class="text">
        <p><?php __($error['text']) ?></p>
      </div>
    </div>
    <div class="buttons buttons-centered cf">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('ok') ?></a>
    </div>
    <?php else: ?>
    <div class="field">
      <div class="label"><?php _l('pages.delete.headline') ?></div>
      <p class="input input-is-readonly"><?php __($page->title()) ?></p>
      <p class="field-help"><a class="marginalia" target="_blank" href="<?php echo $page->url() ?>"><?php __($page->id()) ?></a></p>
    </div>
    <div class="buttons cf">
      <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
      <input class="btn btn-rounded btn-submit btn-negative" type="submit" value="<?php echo _l('delete') ?>" autofocus>
    </div>
    <?php endif ?>
  </form>
</div>