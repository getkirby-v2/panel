<?php echo $topbar ?>

<div class="fileview">

  <figure class="fileview-image">

    <nav class="fileview-nav">

      <?php if($prev): ?>
      <a title="&lsaquo;" data-shortcut="left" class="fileview-nav-prev" href="<?php _u($prev, 'show') ?>">
        <?php i('chevron-left fa-lg') ?>
      </a>
      <?php endif ?>

      <?php if($next): ?>
      <a title="&rsaquo;" data-shortcut="right" class="fileview-nav-next" href="<?php _u($next, 'show') ?>">
        <?php i('chevron-right fa-lg') ?>
      </a>
      <?php endif ?>

    </nav>

    <?php if(in_array($f->extension(), array('jpg', 'jpeg', 'gif', 'png')) and $f->width() < 2000 and $f->height() < 2000): ?>
    <a title="<?php _l('files.show.open') ?> (o)" data-shortcut="o" target="_blank" class="fileview-image-link fileview-preview-link" href="<?php __($f->url()) ?>">
      <i style="background-image: url(<?php __($f->url() . '?' . $f->modified()) ?>); max-width: <?php echo $f->width() ?>px; max-height: <?php echo $f->height() ?>px;"></i>
    </a>
    <?php else: ?>
    <a title="<?php _l('files.show.open') ?> (o)" data-shortcut="o" target="_blank" class="fileview-image-link" href="<?php __($f->url()) ?>">
      <span>
        <strong><?php __($f->filename()) ?></strong>
        <?php __($f->type() . ' / ' . $f->niceSize()) ?>
      </span>
    </a>
    <?php endif ?>

  </figure>

  <aside class="fileview-sidebar">

    <form class="form section" method="post">
      <div class="field field-with-icon">
        <label class="label"><?php _l('files.show.name.label') ?></label>
        <div class="field-content">
          <input class="input" type="text" value="<?php __($f->name()) ?>" name="name" autofocus required>
          <div class="field-icon">
            <span>.<?php __($f->extension()) ?></span>
          </div>
        </div>
      </div>
      <div class="field field-is-readonly">
        <label class="label"><?php _l('files.show.info.label') ?></label>
        <div class="field-content">
          <input class="input input-is-readonly" readonly type="text" value="<?php __($f->type() . ' / ' . $f->niceSize() . ' / ' . $f->dimensions()) ?>">
          <div class="field-icon">
            <?php i('info') ?>
          </div>
        </div>
      </div>
      <div class="field field-is-readonly">
        <label class="label"><?php _l('files.show.link.label') ?></label>
        <div class="field-content">
          <input data-element="public-link" readonly class="input input-is-readonly" type="text" value="<?php __($f->url()) ?>">
          <div class="field-icon">
            <?php i('chain') ?>
          </div>
        </div>
      </div>

      <fieldset class="fieldset field-grid cf">
        <?php foreach($form->fields() as $field) echo $field ?>
      </fieldset>

      <div class="buttons buttons-centered cf">
        <input class="btn btn-rounded btn-submit" type="submit" data-saved="<?php _l('saved') ?>" value="<?php _l('save') ?>">
      </div>

      <nav class="fileview-options">
        <ul class="nav nav-bar nav-btn cf">
          <li>
            <a href="<?php _u($p, 'show') ?>" class="btn btn-with-icon">
              <?php i('arrow-circle-left', 'left') ?>
              <?php _l('files.show.back') ?>
            </a>
          </li>

          <li>
            <a title="r" data-shortcut="r" href="<?php _u($f, 'replace') ?>" class="btn btn-with-icon">
              <?php i('cloud-upload', 'left') ?>
              <?php _l('files.show.replace') ?>
            </a>
          </li>

          <li>
            <a title="#" data-shortcut="#" href="<?php _u($f, 'delete') ?>" class="btn btn-with-icon">
              <?php i('trash-o', 'left') ?>
              <?php _l('files.show.delete') ?>
            </a>
          </li>
        </ul>
      </nav>

    </form>

  </aside>

</div>