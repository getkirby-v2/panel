<div class="modal-content">
  <form class="form" method="post" autocomplete="off" >

    <fieldset class="fieldset">
      <div class="field">
        <label class="label"><?php _l('editor.link.url.label') ?></label>
        <input class="input" type="text" name="url" placeholder="http://" autofocus value="<?php __($url) ?>" required>
      </div>

      <div class="field">
        <label class="label"><?php _l('editor.link.text.label') ?></label>
        <input class="input" type="text" name="text" value="<?php __($text) ?>">
        <p class="field-help marginalia"><?php _l('editor.link.text.help') ?></p>
      </div>

      <div class="buttons cf">
        <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
        <input class="btn btn-rounded btn-submit" type="submit" value="<?php _l('insert') ?>">
      </div>
    </fieldset>
  </form>
</div>