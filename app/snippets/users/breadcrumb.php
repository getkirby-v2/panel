<nav class="breadcrumb">
  <a class="nav-icon nav-icon-left" data-dropdown href="#breadcrumb-menu">
    <?php i('sitemap fa-lg') ?>
  </a>

  <ul class="nav nav-bar breadcrumb-list cf">
    <li>
      <a title="<?php _l('users') ?>" class="breadcrumb-link" href="#/users"><span class="breadcrumb-label"><?php _l('users') ?></span></a>
    </li>
    <?php if(isset($user)): ?>
      <?php if($user): ?>
      <li>
        <a title="<?php __($user->username()) ?>" class="breadcrumb-link" href="<?php _u($user, 'edit') ?>"><span class="breadcrumb-label"><?php __($user->username()) ?></span></a>
      </li>
      <?php else: ?>
      <li>
        <a title="<?php _l('users.index.add') ?>" class="breadcrumb-link" href="#/users/add"><span class="breadcrumb-label"><?php _l('users.index.add') ?></span></a>
      </li>
      <?php endif ?>
    <?php endif ?>
  </ul>
</nav>
