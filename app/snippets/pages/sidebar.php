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

      <?php if(!$page->isHomePage() and !$page->isErrorPage()): ?>
      <li>
        <a title="u" data-shortcut="u" href="<?php echo purl($page, 'url') ?>">
          <?php i('chain', 'left') . _l('pages.show.changeurl') ?>
        </a>
      </li>
      <?php endif; ?>

      <?php if($deletable): ?>
      <li>
        <a title="#" data-shortcut="#" href="<?php echo purl($page, 'delete') ?>">
          <?php i('trash-o', 'left') . _l('pages.show.delete') ?>
        </a>
      </li>
      <?php endif ?>
    </ul>

    <?php echo $subpages ?>

    <?php echo $files ?>

  </div>

</aside>