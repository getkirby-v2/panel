<?php echo $topbar ?>

<div class="bars bars-with-sidebar-left cf">

  <?php echo $sidebar ?>

  <div class="mainbar">

    <div class="section">
      <form class="form" method="post" autocomplete="off">

        <?php if(!$page->isWritable()): ?>
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title"><?php _l('pages.show.error.permissions.title') ?></span>
        </h2>
        <div class="text">
          <p><?php _l('pages.show.error.permissions.text') ?></p>
        </div>
        <div><button type="button" data-element="retry-button" class="btn btn-rounded"><?php _l('pages.show.error.permissions.retry') ?></button></div>
        <?php elseif($notitle): ?>
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title"><?php _l('pages.show.error.notitle.title') ?></span>
        </h2>
        <div class="text">
          <p><?php _l('pages.show.error.notitle.text') ?></p>
        </div>
        <div><button type="button" data-element="retry-button" class="btn btn-rounded"><?php _l('pages.show.error.notitle.retry') ?></button></div>
        <?php else: ?>

        <fieldset class="fieldset field-grid cf">
          <?php foreach($form->fields() as $field) echo $field ?>
        </fieldset>

        <div class="buttons buttons-centered cf">
          <input title="meta+enter" class="btn btn-rounded btn-submit" type="submit" data-saved="<?php echo l('saved') ?>" value="<?php echo l('save') ?>">
        </div>
        <?php endif ?>

      </form>
    </div>
  </div>

</div>