<div class="message message-is-alert">
  <span class="message-content"><?php _l('installation.check.text') ?></span>
  <span class="message-toggle"><i>&times;</i></span>
</div>

<form class="form">

  <div class="field">

    <div class="text">
      <ol>
        <?php foreach($problems as $problem): ?>
        <li><?php echo html($problem) ?></li>
        <?php endforeach ?>
      </ol>
    </div>

  </div>

  <div class="buttons buttons-centered cf">
    <input type="submit" name="retry" class="btn btn-rounded btn-submit" value="<?php _l('installation.check.retry') ?>">
  </div>

</form>