<?php echo $topbar ?>

<div class="section">

  <h2 class="hgroup cf">
    <span class="hgroup-title">
      <?php _l('files.index.headline') ?> <a href="<?php echo purl($page, 'show') ?>"><?php __($page->title()) ?></a>
    </span>
    <span class="hgroup-options shiv shiv-dark shiv-left cf">

      <a class="hgroup-option-left" href="<?php echo purl($page, 'show') ?>">
        <?php i('arrow-circle-left', 'left') . _l('files.index.back') ?>
      </a>

      <?php if($page->hasFiles()): ?>
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
          <a class="file-preview file-preview-is-{{type}}" href="<?php echo purl($file, 'show') ?>">
            <?php if(in_array($file->extension(), array('jpg', 'gif', 'png')) and $file->width() < 2000 and $file->height() < 2000): ?>
            <?php echo thumb($file, array('width' => 300, 'height' => '200', 'crop' => true)) ?>
            <?php else: ?>
            <span><?php __($file->extension()) ?></span>
            <?php endif ?>
          </a>
          <figcaption class="file-info">
            <a class="file-name cut" href="<?php echo purl($file, 'show') ?>"><?php __($file->filename()) ?></a>
            <a class="file-meta marginalia cut" href="<?php echo purl($file, 'show') ?>"><?php __($file->type() . ' / ' . $file->niceSize()) ?></a>
          </figcaption>
          <nav class="file-options cf">

            <a class="btn btn-with-icon" href="<?php echo purl($file, 'show') ?>">
              <?php i('pencil', 'left') ?><span><?php _l('files.index.edit') ?></span>
            </a>

            <a class="btn btn-with-icon" href="<?php echo purl($file, 'delete-from-index') ?>">
              <?php i('trash-o', 'left') ?><span><?php _l('files.index.delete') ?></span>
            </a>

          </nav>
        </figure>
      </div><!--
   --><?php endforeach ?>

    </div>

  </div>

  <?php else: ?>

  <div class="instruction">
    <div class="instruction-content">
      <p class="instruction-text"><?php echo l('files.index.upload.first.text') ?></p>
      <a data-shortcut="+" class="btn btn-rounded" href="<?php echo purl('files/upload/' . $page->id()) ?>">
        <?php echo l('files.index.upload.first.button') ?>
      </a>
    </div>
  </div>

  <?php endif ?>

</div>