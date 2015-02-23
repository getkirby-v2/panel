<h2 class="hgroup hgroup-single-line hgroup-compressed cf">
  <span class="hgroup-title">
    <a href="<?php _u('files/index/' . $page->id()) ?>"><?php _l('pages.show.files.title') ?></a>
  </span>
  <span class="hgroup-options shiv shiv-dark shiv-left">
    <span class="hgroup-option-right">
      <a title="<?php _l('pages.show.files.edit') ?>" href="<?php _u('files/index/' . $page->id()) ?>">
        <?php i('pencil', 'left') ?><span><?php _l('pages.show.files.edit') ?></span>
      </a>
      <a title="f" data-shortcut="f" href="<?php _u($page, 'upload') ?>">
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
  </li>
  <?php endforeach ?>
</ul>
<?php else: ?>
<p class="marginalia"><a href="<?php _u($page, 'upload') ?>" class="marginalia"><?php _l('pages.show.files.empty') ?></a></p>
<?php endif ?>