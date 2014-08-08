<nav class="breadcrumb">

  <a class="nav-icon nav-icon-left" data-dropdown href="#breadcrumb-menu">
    <?php i('sitemap fa-lg') ?>
  </a>

  <ul class="nav nav-bar breadcrumb-list cf">
    <li>
      <a title="<?php _l('dashboard') ?>" class="breadcrumb-link" href="#/"><span class="breadcrumb-label"><?php _l('dashboard') ?></span></a>
    </li>
    <?php if($metatags): ?>
    <li>
      <a title="<?php _l('metatags') ?>" class="breadcrumb-link" href="#/metatags/"><span class="breadcrumb-label"><?php _l('metatags') ?></span></a>
    </li>
    <?php endif ?>
  </ul>

</nav>
