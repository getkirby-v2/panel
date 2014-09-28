<a id="menu-toggle" class="nav-icon nav-icon-left" data-dropdown="true" href="#menu">
  <?php i('bars fa-lg') ?>
</a>

<nav id="menu" class="dropdown dropdown-left">
  <ul class="nav nav-list dropdown-list">
    <li>
      <a href="<?php _u() ?>">
        <?php i('file-o', 'left') . _l('dashboard') ?>
      </a>
    </li>
    <li>
      <a href="<?php _u('users') ?>">
        <?php i('user', 'left') . _l('users') ?>
      </a>
    </li>
    <li>
      <a href="<?php echo panel()->urls()->logout() ?>">
        <?php i('power-off', 'left') . _l('logout') ?>
      </a>
    </li>
  </ul>
</nav>