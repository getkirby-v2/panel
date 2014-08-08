<?php echo $topbar ?>

<div id="search" class="section">
  <div class="field search-field">
    <?php i('search') ?>
    <input id="search-input" class="search-input" autocomplete="off" data-url="api/autocomplete/uris" data-limit="50" type="search" value="<?php __($page->id()) ?>">
  </div>
  <div id="search-help" class="search-help text marginalia" data-help="<?php _l('pages.search.help') ?>" data-noresults="<?php _l('pages.search.noresults') ?>"></div>
  <div id="search-dropdown" class="search-dropdown"></div>
</div>
