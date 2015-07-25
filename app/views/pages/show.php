<div class="bars bars-with-sidebar-left cf">

  <?php echo $sidebar ?>

  <div class="mainbar">
    <div class="section">

      <?php if(!$page->isWritable()): ?>
      <div class="form">
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title"><?php _l('pages.show.error.permissions.title') ?></span>
        </h2>
        <div class="text">
          <p><?php _l('pages.show.error.permissions.text') ?></p>
        </div>
        <div>
          <a href="<?php _u($page, 'show') ?>" class="btn btn-rounded">
            <?php _l('pages.show.error.permissions.retry') ?>
          </a>
        </div>
      </div>
      <?php elseif($notitle): ?>
      <div class="form">
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title"><?php _l('pages.show.error.notitle.title') ?></span>
        </h2>
        <div class="text">
          <p><?php _l('pages.show.error.notitle.text') ?></p>
        </div>
        <div>
          <a href="<?php _u($page, 'show') ?>" class="btn btn-rounded">
            <?php _l('pages.show.error.notitle.retry') ?>
          </a>
        </div>
      </div>
      <?php else: ?>
      <?php echo $form ?>
      <?php endif ?>
    </div>
  </div>

</div>

<form id="upload" class="hidden" action="<?php _u($page, 'upload') ?>" method="post" enctype="multipart/form-data">
  <input type="file" name="file" multiple>
</form>

<script>

$('#upload').uploader(function() {
  app.content.reload();
});

</script>