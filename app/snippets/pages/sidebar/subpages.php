<h2 class="hgroup hgroup-single-line hgroup-compressed cf">
  <span class="hgroup-title">
    <a href="<?php _u('subpages/index/' . $page->id()) ?>"><?php __($title) ?></a>
  </span>
  <span class="hgroup-options shiv shiv-dark shiv-left">
    <span class="hgroup-option-right">
      <a title="<?php _l('pages.show.subpages.edit') ?>" href="<?php _u('subpages/index/' . $page->id()) ?>">
        <?php i('pencil', 'left') ?><span><?php _l('pages.show.subpages.edit') ?></span>
      </a>
      <?php if($addbutton): ?>
      <a title="+" data-shortcut="+" href="<?php _u($page, 'add') ?>">
        <?php i('plus-circle', 'left') ?><span><?php _l('pages.show.subpages.add') ?></span>
      </a>
      <?php endif ?>
    </span>
  </span>
</h2>

<?php if($subpages->count()): ?>
<ul class="nav nav-list sidebar-list datalist-items">
  <?php foreach($subpages as $subpage): ?>
  <?php echo new Snippet('pages/sidebar/subpage', array('subpage' => $subpage)) ?>
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
<p class="marginalia"><a href="<?php _u($page, 'add') ?>" class="marginalia"><?php _l('pages.show.subpages.empty') ?></a></p>
<?php endif ?>