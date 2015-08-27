<div class="section">

  <h2 class="hgroup cf">
    <span class="hgroup-title">
      <?php if($page->isSite()): ?>
      <?php _l('metatags.files') ?>
      <?php else: ?>
      <?php _l('files.index.headline') ?> <a href="<?php __($back) ?>"><?php __($page->title()) ?></a>
      <?php endif ?>
    </span>
    <span class="hgroup-options shiv shiv-dark shiv-left cf">

      <a class="hgroup-option-left" href="<?php __($back) ?>">
        <?php i('arrow-circle-left', 'left') . _l('files.index.back') ?>
      </a>

      <?php if($page->hasFiles()): ?>
      <a data-upload class="hgroup-option-right" href="#upload">
        <?php i('plus-circle', 'left') . _l('files.index.upload') ?>
      </a>
      <?php endif ?>
    </span>
  </h2>

  <?php if($files->count()): ?>
  <div class="files" data-sort-api="<?php __($page->url('files')) ?>" data-sort-csrf="<?php echo panel()->csrf() ?>">

    <div class="grid<?php e($sortable, ' sortable') ?>">

      <?php foreach($files as $file): ?><!--
   --><div class="grid-item" id="<?php __($file->filename()) ?>">
        <figure class="file">
          <a class="file-preview file-preview-is-<?php __($file->type()) ?>" href="<?php __($file->url('edit')) ?>">
            <?php if($file->canHaveThumb()): ?>
            <img src="<?php __($file->thumb()) ?>" alt="<?php __($file->filename()) ?>">
            <?php elseif($file->canHavePreview()): ?>
            <img src="<?php __($file->url('preview')) ?>" alt="<?php __($file->filename()) ?>">
            <?php else: ?>
            <span><?php __($file->extension()) ?></span>
            <?php endif ?>
          </a>
          <figcaption class="file-info">
            <a href="<?php __($file->url('edit')) ?>">
              <span class="file-name cut"><?php __($file->filename()) ?></span>
              <span class="file-meta marginalia cut"><?php __($file->type() . ' / ' . $file->niceSize()) ?></span>
            </a>
          </figcaption>
          <nav class="file-options cf">

            <a class="btn btn-with-icon" href="<?php __($file->url('edit')) ?>">
              <?php i('pencil', 'left') ?><span><?php _l('files.index.edit') ?></span>
            </a>

            <a data-modal data-modal-return-to="<?php __($page->url('files')) ?>" class="btn btn-with-icon" href="<?php __($file->url('delete')) ?>">
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
      <p class="instruction-text"><?php _l('files.index.upload.first.text') ?></p>
      <a data-upload data-shortcut="+" class="btn btn-rounded" href="#upload">
        <?php _l('files.index.upload.first.button') ?>
      </a>
    </div>
  </div>

  <?php endif ?>

</div>

<?php echo $uploader ?>

<script>

var files    = $('.files');
var sortable = files.find('.sortable');
var items    = files.find('.grid-item');
var api      = files.data('sort-api');
var csrf     = files.data('sort-csrf');

if($('.sortable').length > 0) {

  var drag = dragula([$('.sortable')[0]]);
  
  drag.on('drop', function(el, target, source) {

    var filenames = [];

    $(target).find('.grid-item').each(function() {
      filenames.push($(this).attr('id'));
    });

    $.post(api, {filenames: filenames, action: 'sort', '_csrf' : csrf}, function(data) {
      app.content.reload();        
    });

  });  

}

</script>