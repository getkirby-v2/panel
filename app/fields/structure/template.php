<div class="structure" data-field="structure" data-sortable="true">

  <?php echo $field->headline() ?>

  <input type="hidden" name="<?php __($field->name()) ?>" value="<?php __(json_encode($field->value()), false) ?>">

  <script class="structure-form-template" type="text/x-handlebars-template">
    <div class="structure-modal modal">
      <div class="structure-modal-blocker modal-blocker"></div>
      <div class="structure-modal-content modal-content">
        <form class="structure-form form" method="post">
          {{#with data}}
          <fieldset class="field-grid cf">
            <?php foreach($field->fields() as $f): ?>
            <?php echo form::field($f['type'], $f) ?>
            <?php endforeach ?>
          </fieldset>
          {{/with}}
          <div class="structure-form-buttons buttons cf">
            <button class="btn btn-rounded btn-cancel structure-cancel-button" type="reset"><?php _l('fields.structure.cancel') ?></button>
            <button class="btn btn-rounded btn-submit structure-action-button" type="submit"><?php _l('fields.structure.save') ?></button>
          </div>
        </div>
      </form>
    </div>
  </script>

  <script class="structure-entries-template" type="text/x-handlebars-template">

    {{#unless entries}}
    <div class="structure-empty">
      <?php _l('fields.structure.empty') ?> <a class="structure-add-button" href="#"><?php _l('fields.structure.add.first') ?></a>
    </div>
    {{/unless}}

    {{#entries}}
    <div class="structure-entry" id="structure-entry-{{_id}}">
      <div class="structure-entry-content text">
        <?php echo $field->entry() ?>
      </div>
      <nav class="structure-entry-options cf">
        <button type="button" data-structure-id="{{_id}}" class="btn btn-with-icon structure-edit-button">
          <?php i('pencil', 'left') . _l('fields.structure.edit') ?>
        </button>
        <button type="button" data-structure-id="{{_id}}" class="btn btn-with-icon structure-delete-button">
          <?php i('trash-o', 'left') . _l('fields.structure.delete') ?>
        </button>
      </nav>
    </div>
    {{/entries}}
  </script>

</div>