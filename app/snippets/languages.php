<?php if($languages = site()->languages()): ?>

<div class="languages">

  <a id="languages-toggle" class="languages-toggle" data-dropdown="true" href="#languages">
    <span><?php __(site()->language()->code()) ?></span>
  </a>

  <nav id="languages" class="dropdown dropdown-left">
    <ul class="nav nav-list dropdown-list">
      <?php foreach($languages as $lang): ?>
      <li>
        <a data-lang="<?php __($lang->code()) ?>" href="#"><?php __(strtoupper($lang->code())) ?></a>
      </li>
      <?php endforeach ?>
    </ul>
  </nav>

</div>

<?php endif ?>
