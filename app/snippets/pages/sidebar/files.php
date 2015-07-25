<h2 class="hgroup hgroup-single-line hgroup-compressed cf">
  <span class="hgroup-title">
    <?php if($page->isSite()): ?>
    <a href="<?php _u($page, 'files') ?>"><?php _l('metatags.files') ?></a>
    <?php else: ?>
    <a href="<?php _u($page, 'files') ?>"><?php _l('pages.show.files.title') ?></a>
    <?php endif ?>
  </span>
  <span class="hgroup-options shiv shiv-dark shiv-left">
    <span class="hgroup-option-right">
      <a title="<?php _l('pages.show.files.edit') ?>" href="<?php _u($page, 'files') ?>">
        <?php i('pencil', 'left') ?><span><?php _l('pages.show.files.edit') ?></span>
      </a>
      <a data-upload href="#upload">
        <?php i('plus-circle', 'left') ?><span><?php _l('pages.show.files.add') ?></span>
      </a>
    </span>
  </span>
</h2>

<?php if($files->count()): ?>
<ul class="nav nav-list sidebar-list">
  <?php foreach($files as $file): ?>
  <li>
    <a class="draggable" data-helper="<?php __($file->filename()) ?>" data-text="<?php echo dragText($file) ?>" href="<?php _u($file, 'show') ?>">
      <?php i($file) . __($file->filename()) ?>
    </a>
    <a class="option" data-context="<?php _u($file, 'context') ?>" href="#options"><?php i('pencil') ?></a>
  </li>
  <?php endforeach ?>
</ul>
<?php else: ?>
<p class="marginalia"><a data-upload href="#upload" class="marginalia"><?php _l('pages.show.files.empty') ?></a></p>
<?php endif ?>