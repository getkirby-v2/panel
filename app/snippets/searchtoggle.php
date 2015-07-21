<?php if($close): ?>
<a data-shortcut="esc" class="nav-icon nav-icon-right" href="<?php echo $close ?>">
  <?php i('times fa-lg') ?>
</a>
<?php else: ?>
<a data-shortcut="g" class="nav-icon nav-icon-right" href="<?php echo $search ?>">
  <?php i('search fa-lg') ?>
</a>
<?php endif ?>