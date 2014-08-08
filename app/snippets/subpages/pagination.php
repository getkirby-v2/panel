<?php if($pagination->pages() > 1): ?>
<nav class="pagination cf">
  <a class="pagination-prev<?php e(!$pagination->hasPrevPage(), ' pagination-inactive') ?>" href="<?php echo $prevUrl ?>"><?php i('chevron-left') ?></a>
  <span class="pagination-index"><?php echo $pagination->page() . ' / ' . $pagination->pages() ?></span>
  <a class="pagination-next<?php e(!$pagination->hasNextPage(), ' pagination-inactive') ?>" href="<?php echo $nextUrl ?>"><?php i('chevron-right') ?></a>
</nav>
<?php endif ?>