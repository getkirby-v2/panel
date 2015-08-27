<div id="search" class="section">
  <div class="field search-field">
    <?php i('search') ?>
    <input id="search-input" class="search-input" autocomplete="off" type="text" autofocus value="<?php __($page->id()) ?>"
      data-url="<?php _u('api/autocomplete/uris?_csrf=' . panel()->csrf()) ?>" 
      data-limit="50">
  </div>
  <div id="search-help" class="search-help text marginalia" data-help="<?php _l('pages.search.help') ?>" data-noresults="<?php _l('pages.search.noresults') ?>"></div>
  <div id="search-dropdown" class="search-dropdown"></div>
</div>

<script>

(function() {

  var input     = $('.main .search-input');
  var hint      = $('.main .search-help').hide();
  var help      = hint.data('help');
  var noresults = hint.data('noresults');

  input.autocomplete($('.main .search-dropdown'));
  input.on({
    'keydown' : function(e) {
      if(e.keyCode == 27) {
        app.content.open($('#topbar [data-shortcut=esc]').attr('href'));
        return false;
      }
    },
    'autocomplete:add' : function() {
      var uri = $(this).val();
      if(uri) {
        app.content.open('pages/' + uri + '/edit');
      }
    },
    'autocomplete:search' : function() {
      hint.hide();
    },
    'autocomplete:empty autocomplete:close' : function() {
      hint.show();
      hint.text(help);
    },
    'autocomplete:noresults' : function() {
      hint.show();
      hint.text(noresults);
    }
  });
  input.trigger('autocomplete:empty');
  input.focus();
  input.selectRange(-1);

})();

</script>