<div class="modal-content">
  <form class="form" method="post" autocomplete="off" >

    <fieldset class="fieldset">

      <?php if($p->hasFiles()): ?>
      <div class="field grey items file-selector">
        <?php $n=0; foreach($p->files() as $f): $n++; ?>
        <div class="item">
          <label>
            <div class="item-content">
              <div class="item-info">
                <strong class="item-title cut"><?php __($f->filename()) ?></strong>
                <small class="item-meta cut marginalia"><?php __($f->type()) ?></small>
              </div>
            </div>
            <div class="item-options">
              <input type="radio" name="file"<?php e($n == 1, ' checked autofocus') ?> value="<?php __($f->filename()) ?>">
            </div>
          </label>
        </div>
        <?php endforeach ?>
      </div>
      <?php else: ?>
      <div class="field">
        <p class="input input-is-readonly"><?php _l('editor.file.empty') ?></p>
      </div>
      <?php endif ?>

      <div class="buttons<?php e(!$p->hasFiles(), ' buttons-centered') ?> cf">
        <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
        <?php if($p->hasFiles()): ?>
        <input class="btn btn-rounded btn-submit" type="submit" value="<?php _l('insert') ?>">
        <?php endif ?>
      </div>
    </fieldset>
  </form>
</div>