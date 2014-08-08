<div class="structure" data-field="structure" data-sortable="true">

  <label class="structure-label label">
    <?php html($field->label, false) ?>
    <a class="structure-add-button label-option" href="#">
      <i class="icon icon-left fa fa-plus-circle"></i>
      <?php echo l('fields.structure.add') ?>
    </a>
  </label>

  <input type="hidden" name="<?php html($field->name, false) ?>" value="<?php html(json_encode($field->value()), false) ?>">

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
            <button class="btn btn-rounded btn-cancel structure-cancel-button" type="reset"><?php echo l('fields.structure.cancel') ?></button>
            <button class="btn btn-rounded btn-submit structure-action-button" type="submit"><?php echo l('fields.structure.save') ?></button>
          </div>
        </div>
      </form>
    </div>
  </script>

  <script class="structure-entries-template" type="text/x-handlebars-template">

    {{#unless entries}}
    <div class="structure-empty">
      <?php echo l('fields.structure.empty') ?> <a class="structure-add-button" href="#"><?php echo l('fields.structure.add.first') ?></a>
    </div>
    {{/unless}}

    {{#entries}}
    <div class="structure-entry" id="structure-entry-{{_id}}">
      <div class="structure-entry-content text">
        <?php echo $field->entry() ?>
      </div>
      <nav class="structure-entry-options cf">
        <button type="button" data-structure-id="{{_id}}" class="btn btn-with-icon structure-edit-button">
          <i class="icon icon-left fa fa-pencil"></i>
          <?php echo l('fields.structure.edit') ?>
        </button>
        <button type="button" data-structure-id="{{_id}}" class="btn btn-with-icon structure-delete-button">
          <i class="icon icon-left fa fa-trash-o"></i>
          <?php echo l('fields.structure.delete') ?>
        </button>
      </nav>
    </div>
    {{/entries}}
  </script>

</div>