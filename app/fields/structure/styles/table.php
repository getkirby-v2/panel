<table class="structure-table">
  <thead>
    <tr>
      <?php foreach($field->fields() as $f): ?>
      <th>
        <?php echo html($f['label'], false) ?>
      </th>
      <?php endforeach ?>
      <th class="structure-table-options">  
        &nbsp;
      </th>
    </tr>    
  </thead>
  <tbody>
    <?php foreach($field->entries() as $entry): ?>
    <tr id="structure-entry-<?php echo $entry->id() ?>">
      <?php foreach($field->fields() as $f): ?>
      <td>
        <a data-modal href="<?php _u($field->page(), 'field/' . $field->name() . '/structure/' . $entry->id() . '/update') ?>">
          <?php echo html(@$entry->{$f['name']}, false) ?>
        </a>
      </td>
      <?php endforeach ?>
      <td class="structure-table-options">
        <a data-modal class="btn" href="<?php _u($field->page(), 'field/' . $field->name() . '/structure/' . $entry->id() . '/delete') ?>">
          <?php i('trash-o') ?>
        </a>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>

<script>

// (function() {

//   var structure = $('.structure');
//   var table     = structure.find('.structure-table tbody');
//   var drag      = dragula([table[0]]);

//   drag.on('cloned', function(clone, original, type) {
//     $(clone).addClass('structure-draggable-helper');
//   });

//   drag.on('drop', function(e, target, source) {

//     var ids = [];

//     $('.structure-table tbody tr').each(function() {
//       ids.push($(this).attr('id').replace('structure-entry-', ''));
//     });

//     $.post(structure.data('api'), {ids: ids}, function() {
//       app.content.reload();
//     });

//   });



// })();

</script>