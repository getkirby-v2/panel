<li>
  <a class="draggable" data-helper="<?php __($subpage->title()) ?>" data-text="<?php echo dragText($subpage) ?>" href="<?php _u($subpage, 'show') ?>">
    <?php i($subpage) ?><span><?php __($subpage->title()) ?></span>
    <small class="marginalia shiv shiv-left shiv-white"><?php __(n($subpage)) ?></small>
  </a>
</li>