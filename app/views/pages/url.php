<div class="modal-content">
  <form class="form" method="post">
    <fieldset class="fieldset">
      <div class="field field-with-icon">
        <label class="label">
          <?php _l('pages.url.uid.label') ?>

          <a data-element="toggle" data-title="<?php __($page->title()) ?>" class="btn btn-icon label-option" href="#">
            <?php i('plus-circle', 'left') . _l('pages.url.uid.label.option') ?>
          </a>

        </label>
        <div class="field-content">
          <input data-element="input" class="input" id="page-add-title" type="text" name="uid" placeholder="appendix…" autofocus autocomplete="off" required value="<?php __($page->slug()) ?>">
          <div class="field-icon">
            <?php i('chain') ?>
          </div>
        </div>
        <div class="field-help marginalia">
          <div class="uid-preview">
            <?php __(ltrim($page->parent()->uri() . '/', '/')) ?><span data-element="preview"><?php __($page->slug()) ?></span>
          </div>
        </div>
      </div>

      <div class="buttons cf">
        <a class="btn btn-rounded btn-cancel" href="<?php _u($page, 'show') ?>"><?php _l('cancel') ?></a>
        <input class="btn btn-rounded btn-submit" type="submit" value="<?php _l('save') ?>">
      </div>
    </fieldset>
  </form>
</div>