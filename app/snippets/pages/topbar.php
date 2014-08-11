<header id="topbar" class="topbar">

  <?php echo new Snippet('menu') ?>
  <?php echo $breadcrumb ?>

  <?php echo new Snippet('languages') ?>

  <a data-shortcut="g" class="nav-icon nav-icon-right" href="<?php echo $search ?>">
    <?php i('search fa-lg') ?>
  </a>

</header>