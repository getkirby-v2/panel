<div class="modal-content">
  <form class="form" method="post" autocomplete="off" >

    <fieldset class="fieldset">

      <?php if($p->hasImages()): ?>
      <div class="field grey items file-selector">
        <?php $n=0; foreach($p->images() as $i): $n++; ?>
        <div class="item item-with-image">
          <label>
            <div class="item-content">
              <figure class="item-image">
                <span class="item-image-container">
                  <?php echo thumb($i, array('width' => 100, 'height' => 100, 'crop' => true)) ?>
                </span>
              </figure>
              <div class="item-info">
                <strong class="item-title cut"><?php __($i->filename()) ?></strong>
              </div>
            </div>
            <div class="item-options">
              <input type="radio" name="image"<?php e($n == 1, ' checked autofocus') ?> value="<?php __($i->filename()) ?>">
            </div>
          </label>
        </div>
        <?php endforeach ?>
      </div>
      <?php else: ?>
      <div class="field">
        <p class="input input-is-readonly"><?php _l('editor.image.empty') ?></p>
      </div>
      <?php endif ?>

      <div class="buttons<?php e(!$p->hasImages(), ' buttons-centered') ?> cf">
        <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
        <?php if($p->hasImages()): ?>
        <input class="btn btn-rounded btn-submit" type="submit" value="<?php _l('insert') ?>">
        <?php endif ?>
      </div>
    </fieldset>
  </form>
</div>