<aside class="sidebar">

  <a class="sidebar-toggle" href="#sidebar" data-hide="<?php _l('options.hide') ?>"><span><?php _l('options.show') ?></span></a>

  <div class="sidebar-content section">

    <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
      <span class="hgroup-title">
        <?php _l('pages.show.settings') ?>
      </span>
    </h2>

    <ul class="nav nav-list sidebar-list">

      <?php if($preview): ?>
      <li>
        <a title="p" data-shortcut="p" data-shortcut="u" href="<?php echo $preview ?>" target="_blank">
          <?php i('play-circle-o', 'left') . _l('pages.show.preview') ?>
        </a>
      </li>
      <?php endif ?>

      <li>
        <a title="u" data-shortcut="u" href="<?php echo purl($page, 'url') ?>">
          <?php i('chain', 'left') . _l('pages.show.changeurl') ?>
        </a>
      </li>
      <?php if($deletable): ?>
      <li>
        <a title="#" data-shortcut="#" href="<?php echo purl($page, 'delete') ?>">
          <?php i('trash-o', 'left') . _l('pages.show.delete') ?>
        </a>
      </li>
      <?php endif ?>
    </ul>

    <!-- Subpages -->
    <?php if($blueprint->pages()->max() !== 0 and $blueprint->pages()->hide() == false): ?>

      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title">
          <a href="<?php echo purl('subpages/index/' . $page->id()) ?>"><?php _l('pages.show.subpages.title') ?></a>
        </span>
        <?php if($addbutton): ?>
        <span class="hgroup-options shiv shiv-dark shiv-left">
          <a title="+" data-shortcut="+" class="hgroup-option-right" href="<?php echo purl($page, 'add') ?>">
            <?php i('plus-circle', 'left') . _l('pages.show.subpages.add') ?>
          </a>
        </span>
        <?php endif ?>
      </h2>

      <?php if($subpages->count()): ?>
      <ul class="nav nav-list sidebar-list datalist-items">
        <?php foreach($subpages as $subpage): ?>
        <?php echo new Snippet('pages/subpage', array('subpage' => $subpage)) ?>
        <?php endforeach ?>
      </ul>

      <?php if($pagination->pages() > 1): ?>
      <nav class="pagination cf">
        <a title="alt+left" data-shortcut="alt+left" class="pagination-prev<?php e(!$pagination->hasPrevPage(), ' pagination-inactive') ?>" href="<?php echo purl($page, 'show') . '/p:' . $pagination->prevPage() ?>"><?php i('chevron-left') ?></a>
        <span class="pagination-index"><?php echo $pagination->page() . ' / ' . $pagination->pages() ?></span>
        <a title="alt+right" data-shortcut="alt+right" class="pagination-next<?php e(!$pagination->hasNextPage(), ' pagination-inactive') ?>" href="<?php echo purl($page, 'show') . '/p:' . $pagination->nextPage() ?>"><?php i('chevron-right') ?></a>
      </nav>
      <?php endif ?>

      <?php else: ?>
      <p class="marginalia"><a href="<?php echo purl($page, 'add') ?>" class="marginalia"><?php _l('pages.show.subpages.empty') ?></a></p>
      <?php endif ?>

    <?php endif ?>

    <!-- Files -->
    <?php if($blueprint->files()->max() === null): ?>
      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title">
          <a href="<?php echo purl('files/index/' . $page->id()) ?>"><?php _l('pages.show.files.title') ?></a>
        </span>
        <span class="hgroup-options shiv shiv-dark shiv-left">
          <a title="f" data-shortcut="f" class="hgroup-option-right" href="<?php echo purl($page, 'upload') ?>">
            <?php i('plus-circle', 'left') . _l('pages.show.files.add') ?>
          </a>
        </span>
      </h2>

      <?php if($files->count()): ?>
      <ul class="nav nav-list sidebar-list">
        <?php foreach($files as $file): ?>
        <li>
          <a class="draggable" data-helper="<?php __($file->filename()) ?>" data-text="<?php echo dragText($file) ?>" href="<?php echo purl($file, 'show') ?>">
            <?php i($file) . __($file->filename()) ?>
          </a>
        </li>
        <?php endforeach ?>
      </ul>
      <?php else: ?>
      <p class="marginalia"><a href="<?php echo purl($page, 'upload') ?>" class="marginalia"><?php _l('pages.show.files.empty') ?></a></p>
      <?php endif ?>
    <?php endif ?>

  </div>

</aside>