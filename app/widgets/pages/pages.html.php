
<?php $pagination = $pages->pagination();?>

<ul class="nav nav-list sidebar-list">
  <?php foreach($pages as $c): ?>
  <?php echo new Kirby\Panel\Snippet('pages/sidebar/subpage', array('subpage' => $c)) ?>
  <?php endforeach ?>
</ul>

<?php echo new Kirby\Panel\Snippet('pagination', array(
    'pagination' => $pagination, 
    'nextUrl' => $pagination->nextPageURL(),
    'prevUrl' => $pagination->prevPageURL())) ?>