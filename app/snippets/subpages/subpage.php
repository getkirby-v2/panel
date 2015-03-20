<div class="item item-condensed" id="<?php __($subpage->uid()) ?>" data-index="<?php echo $subpage->num() ?>">
  <div class="item-content" title="<?php __($subpage->title()) ?>">
    <div class="item-info">
      <span class="item-title"><?php __($subpage->title()) ?></span>
    </div>
  </div>
  <nav class="item-options item-options-three">
    <ul class="nav nav-bar">
      <li>
        <a class="btn btn-with-icon" href="<?php _u($subpage, 'show') ?>">
          <i class="icon icon-left marginalia"><?php __(n($subpage)) ?></i>
          <span>Move</span>
        </a>
      </li>
      <?php if($editbutton) : ?>
        <li>
          <a class="btn btn-with-icon" href="<?php _u($subpage, 'show') ?>">
            <?php i('pencil', 'left') ?>
            <span>Edit</span>
          </a>
        </li>
      <?php endif ?>
      <?php if($deletebutton) : ?>
        <li>
          <a class="btn btn-with-icon" href="<?php _u('subpages/delete/' . $subpage->id()) ?>">
            <?php i('trash-o', 'left') ?>
            <span>Delete</span>
          </a>
        </li>
      <?php endif ?>
    </ul>
  </nav>
</div>
