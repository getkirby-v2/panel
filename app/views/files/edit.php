<div class="fileview">

  <figure class="fileview-image">

    <nav class="fileview-nav">

      <?php if($prev = $file->prev()): ?>
      <a title="&lsaquo;" data-shortcut="left" class="fileview-nav-prev" href="<?php __($prev->url('edit')) ?>">
        <?php i('chevron-left fa-lg') ?>
      </a>
      <?php endif ?>

      <?php if($next = $file->next()): ?>
      <a title="&rsaquo;" data-shortcut="right" class="fileview-nav-next" href="<?php __($next->url('edit')) ?>">
        <?php i('chevron-right fa-lg') ?>
      </a>
      <?php endif ?>

    </nav>

    <?php if($file->canHavePreview()): ?>
    <a title="<?php _l('files.show.open') ?> (o)" data-shortcut="o" target="_blank" class="fileview-image-link fileview-preview-link" href="<?php __($file->url('preview')) ?>">
      <img src="<?php __($file->url('preview')) ?>" alt="<?php __($file->filename()) ?>">
    </a>
    <?php else: ?>
    <a title="<?php _l('files.show.open') ?> (o)" data-shortcut="o" target="_blank" class="fileview-image-link" href="<?php __($file->previewUrl()) ?>">
      <span>
        <strong><?php __($file->filename()) ?></strong>
        <?php __($file->type() . ' / ' . $file->niceSize()) ?>
      </span>
    </a>
    <?php endif ?>

  </figure>

  <aside class="fileview-sidebar">

    <div class="section">
      <?php echo $form ?>

      <nav class="fileview-options">
        <ul class="nav nav-bar nav-btn cf">
          <li>
            <a href="<?php __($page->url('edit')) ?>" class="btn btn-with-icon">
              <?php i('arrow-circle-left', 'left') ?>
              <?php _l('files.show.back') ?>
            </a>
          </li>

          <li>
            <a data-upload title="r" data-shortcut="r" href="#replay" class="btn btn-with-icon">
              <?php i('cloud-upload', 'left') ?>
              <?php _l('files.show.replace') ?>
            </a>
          </li>

          <li>
            <a data-modal data-modal-return-to="<?php __($returnTo) ?>" title="#" data-shortcut="#" href="<?php __($file->url('delete')) ?>" class="btn btn-with-icon">
              <?php i('trash-o', 'left') ?>
              <?php _l('files.show.delete') ?>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

</div>

<?php echo $uploader ?>

<script>

$('#form-field-_link').on('click', function() {

  $(this).select();

  try {
    document.execCommand('copy');
  } catch(err) {
    // copy to clipboard is not supported yet
  }

});

</script>