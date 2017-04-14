<ul class="nav nav-list sidebar-list">
  <?php foreach($pages as $c): ?>
  <?php echo new Kirby\Panel\Snippet('pages/sidebar/subpage', array('subpage' => $c)) ?>
  <?php endforeach ?>
</ul>
<?php if ($pages->pagination()->hasPages()) { ?>
    <nav class="pagination" style="text-align: center">
        <a class="pagination-prev<?= !$pages->pagination()->hasPrevPage() ? ' pagination-inactive' : '' ?>"
           href="<?= $pages->pagination()->prevPageURL() ?>">
            <span><i class="fa fa-arrow-left" aria-hidden="true"></i>Previous Page</span>
        </a>

        <span class="pagination-index" style="left: auto; right: auto; display: inline">
		<?php foreach ($pages->pagination()->range(5) as $page) { ?>
            <a href="<?= $pages->pagination()->pageURL($page) ?>" style="display: inline;<?= ($pages->pagination()->page() != $page) ? 'color: gray' : ''?>"><?= $page ?></a>
		<?php } ?>
		</span>
        <a class="pagination-next<?= !$pages->pagination()->hasNextPage() ? ' pagination-inactive' : '' ?>"
           href="<?= $pages->pagination()->nextPageURL() ?>">
            <span>Next Page <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
        </a>
    </nav>
<?php } ?>
