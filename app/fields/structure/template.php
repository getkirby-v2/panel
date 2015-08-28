<div class="structure<?php e($field->readonly(), ' structure-readonly') ?>" 
  data-field="structure" 
  data-api="<?php _u($field->page(), 'field/' . $field->name() . '/structure/sort') ?>" 
  data-sortable="<?php e($field->readonly(), 'false', 'true') ?>">

  <?php echo $field->headline() ?>

  <div class="structure-entries">

    <?php if(!$field->entries()->count()): ?>
    <div class="structure-empty">
      <?php _l('fields.structure.empty') ?> <a data-modal class="structure-add-button" href="<?php _u($field->page(), 'field/' . $field->name() . '/structure/add') ?>"><?php _l('fields.structure.add.first') ?></a>
    </div>
    <?php else: ?>

      <?php foreach($field->entries() as $entry): ?>
      <div class="structure-entry" id="structure-entry-<?php echo $entry->id() ?>">
        <div class="structure-entry-content text">
          <?php echo $field->entry($entry) ?>
        </div>
        <?php if(!$field->readonly()): ?>
        <nav class="structure-entry-options cf">
          <a data-modal class="btn btn-with-icon structure-edit-button" href="<?php _u($field->page(), 'field/' . $field->name() . '/structure/' . $entry->id() . '/update') ?>">
            <?php i('pencil', 'left') . _l('fields.structure.edit') ?>
          </a>

          <a data-modal class="btn btn-with-icon structure-delete-button" href="<?php _u($field->page(), 'field/' . $field->name() . '/structure/' . $entry->id() . '/delete') ?>">
            <?php i('pencil', 'left') . _l('fields.structure.delete') ?>
          </a>
        </nav>
        <?php endif ?>
      </div>          
      <?php endforeach ?>

    <?php endif ?>

  </div>

</div>