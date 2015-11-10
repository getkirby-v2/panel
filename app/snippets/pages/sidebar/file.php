<li>
  <a class="draggable" data-helper="<?php __($file->filename()) ?>" data-text="<?php __($file->dragText()) ?>" href="<?php __($file->url('edit')) ?>">
    <?php echo $file->icon() . __($file->filename()) ?>
  </a>
  <a class="option" data-context="<?php __($file->url('context')) ?>" href="#options"><?php i('ellipsis-h') ?></a>
</li>