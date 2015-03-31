<?php echo $topbar ?>

<div class="bars bars-with-sidebar-left cf">

  <aside class="sidebar sidebar-left">

    <a class="sidebar-toggle" href="#sidebar" data-hide="<?php _l('options.hide') ?>"><span><?php _l('options.show') ?></span></a>

    <div class="sidebar-content">

      <div class="section">
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title">
            <?php _l('metatags.info') ?>
          </span>
        </h2>
        <div class="text">
          <p> 
            <?php _l('metatags.version.kirby') ?>: <?php echo kirby::version() ?><br />
            <?php _l('metatags.version.panel') ?>: <?php echo panel::version() ?>
          </p>
        </div>

        <?php echo $files ?>
      </div>

    </div>

  </aside>

  <div class="mainbar">

    <div class="section">
      <form class="form" method="post" autocomplete="off">

        <fieldset class="fieldset field-grid cf">
          <?php foreach($form->fields() as $field) echo $field ?>
        </fieldset>

        <div class="buttons cf">
          <a class="btn btn-rounded btn-cancel" href="<?php _u() ?>"><?php _l('cancel') ?></a>
          <input class="btn btn-rounded btn-submit" type="submit" data-saved="<?php _l('saved') ?>" value="<?php echo l('save') ?>">
        </div>

      </form>
    </div>
  </div>

</div>