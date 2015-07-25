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

    <?php if(fileHasPreview($f)): ?>
    <a title="<?php _l('files.show.open') ?> (o)" data-shortcut="o" target="_blank" class="fileview-image-link fileview-preview-link" href="<?php __($f->url()) ?>">
      <img src="<?php __($f->url() . '?' . $f->modified()) ?>" alt="<?php __($f->filename()) ?>">
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

    <div class="section">
      <?php echo $form ?>

      <nav class="fileview-options">
        <ul class="nav nav-bar nav-btn cf">
          <li>
            <a href="<?php _u($p, 'show') ?>" class="btn btn-with-icon">
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
            <a data-modal data-modal-return-to="<?php echo $returnTo ?>" title="#" data-shortcut="#" href="<?php _u($f, 'delete') ?>" class="btn btn-with-icon">
              <?php i('trash-o', 'left') ?>
              <?php _l('files.show.delete') ?>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

</div>

<form id="upload" class="hidden" action="<?php _u($f, 'replace') ?>" method="post" enctype="multipart/form-data">
  <input type="file" name="file" accept="<?php __($f->mime()) ?>">
</form>

<script>

$('#form-field-_link').on('click', function() {

  $(this).select();

  try {
    document.execCommand('copy');
  } catch(err) {
    // copy to clipboard is not supported yet
  }

});

$('#upload').uploader(function() {
  app.content.reload();
});

</script>