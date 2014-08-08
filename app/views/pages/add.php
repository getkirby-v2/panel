<div class="modal-content">
  <form class="form" method="post">

    <fieldset class="fieldset field-grid cf">
      <div class="field field-grid-item">
        <label class="label"><?php _l('pages.add.title.label') ?><abbr title="<?php _l('fields.required') ?>">*</abbr></label>
        <input class="input" type="text" name="title" placeholder="<?php _l('pages.add.title.placeholder') ?>…" autofocus autocomplete="off" required>
      </div>

      <div class="field field-grid-item">
        <label class="label"><?php _l('pages.add.url.label') ?><abbr title="<?php _l('fields.required') ?>">*</abbr></label>
        <input class="input" type="text" name="uid" required>
        <div class="field-help marginalia">
          <?php _l('pages.add.url.help') ?>
        </div>
      </div>

      <?php if($templates->count() == 1 and $template = $templates->first()): ?>
      <div class="field field-grid-item field-with-icon field-is-readonly">
        <label class="label"><?php _l('pages.add.template.label') ?></label>
        <div class="field-content">
          <div class="input input-is-readonly"><?php __($template->title()) ?></div>
          <input type="hidden" name="template" value="<?php __($template->name()) ?>">
          <div class="field-icon">
            <?php i('lock') ?>
          </div>
        </div>
      </div>
      <?php else: ?>
      <?php

      $options = array();
      foreach($templates as $template) {
        $options[$template->name()] = $template->title();
      }

      echo form::field('select', array(
        'label'    => 'pages.add.template.label',
        'name'     => 'template',
        'required' => true,
        'type'     => 'select',
        'options'  => $options
      ));

      ?>
      <?php endif ?>

      <div class="buttons field-grid-item cf">
        <a class="btn btn-rounded btn-cancel" href="<?php __($back) ?>"><?php _l('cancel') ?></a>
        <input class="btn btn-rounded btn-submit" type="submit" value="<?php _l('add') ?>">
      </div>

    </fieldset>
  </form>
</div>