<?php echo $topbar ?>

<div class="section">

  <h2 class="hgroup cf">
    <span class="hgroup-title">
      <?php if($page->isSite()): ?>
      <?php _l('metatags.files') ?>
      <?php else: ?>
      <?php _l('files.index.headline') ?> <a href="<?php echo $back ?>"><?php __($page->title()) ?></a>
      <?php endif ?>
    </span>
    <span class="hgroup-options shiv shiv-dark shiv-left cf">

      <a class="hgroup-option-left" href="<?php echo $back ?>">
        <?php i('arrow-circle-left', 'left') . _l('files.index.back') ?>
      </a>

      <?php if($page->hasFiles() and $addbutton): ?>
      <a title="+" data-shortcut="+" class="hgroup-option-right" href="<?php echo purl('files/upload/' . $page->id()) ?>">
        <?php i('plus-circle', 'left') . _l('files.index.upload') ?>
      </a>
      <?php endif ?>
    </span>
  </h2>

  <?php if($files->count()): ?>
  <div class="files">

    <div class="grid<?php e($sortable, ' sortable') ?>">

      <?php foreach($files as $file): ?><!--
   --><div class="grid-item" id="<?php __($file->filename()) ?>">
        <figure class="file">
          <a class="file-preview file-preview-is-<?php echo $file->type() ?>" href="<?php echo purl($file, 'show') ?>">
            <?php if(in_array($file->extension(), array('jpg', 'gif', 'png')) and $file->width() < 2000 and $file->height() < 2000): ?>
            <?php echo thumb($file, array('width' => 300, 'height' => '200', 'crop' => true)) ?>
            <?php elseif($file->extension() == 'svg'): ?>
            <img src="<?php echo $file->url() ?>" alt="<?php echo $file->filename() ?>">
            <?php else: ?>
            <span><?php __($file->extension()) ?></span>
            <?php endif ?>
          </a>
          <figcaption class="file-info">
            <a class="file-name cut" href="<?php echo purl($file, 'show') ?>"><?php __($file->filename()) ?></a>
            <a class="file-meta marginalia cut" href="<?php echo purl($file, 'show') ?>"><?php __($file->type() . ' / ' . $file->niceSize()) ?></a>
          </figcaption>

          <?php if($editbutton or $deletebutton) : ?>
            <nav class="file-options cf">

              <?php if($editbutton) : ?>
                <a class="btn btn-with-icon" href="<?php echo purl($file, 'show') ?>">
                  <?php i('pencil', 'left') ?><span><?php _l('files.index.edit') ?></span>
                </a>
              <?php else : ?>
                <span class="btn btn-with-icon btn-disabled"><?php i('pencil', 'left') ?><span><?php _l('files.index.edit') ?></span></span>
              <?php endif ?>

              <?php if($deletebutton) : ?>
                <a class="btn btn-with-icon" href="<?php echo purl($file, 'delete-from-index') ?>">
                  <?php i('trash-o', 'left') ?><span><?php _l('files.index.delete') ?></span>
                </a>
              <?php else : ?>
                <span class="btn btn-with-icon btn-disabled"><?php i('trash-o', 'left') ?><span><?php _l('files.index.delete') ?></span></span>
              <?php endif ?>

            </nav>
          <?php endif ?>
        </figure>
      </div><!--
   --><?php endforeach ?>

    </div>

  </div>

  <?php else: ?>

  <div class="instruction">
    <div class="instruction-content">
      <p class="instruction-text"><?php echo l('files.index.upload.first.text') ?></p>
      <?php if($addbutton): ?>
        <a data-shortcut="+" class="btn btn-rounded" href="<?php echo purl('files/upload/' . $page->id()) ?>">
          <?php echo l('files.index.upload.first.button') ?>
        </a>
      <?php endif ?>
    </div>
  </div>

  <?php endif ?>

</div>
