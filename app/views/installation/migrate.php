<form class="form">

  <div class="field">

    <h1 class="label">Upgrade from Kirby 1</h1>

    <div class="text">
      <p>
        It seems like you are trying to upgrade from Kirby 1. There are just a couple of steps to complete before you can use the new version.
      </p>

      <ol>
        <li>Please move all blueprints from <b>/site/panel/blueprints</b> to <b>/site/blueprints</b></li>
        <li>Please move all config settings from <b>/site/panel/config/config.php</b> to <b>/site/config/config.php</b></li>
        <li>Please move all fields from <b>/site/panel/fields</b> to <b>/site/fields</b></li>
      </ol>

    </div>

  </div>

  <div class="buttons buttons-centered cf">
    <input type="submit" name="retry" class="btn btn-rounded btn-submit" value="<?php _l('installation.check.retry') ?>">
  </div>

</form>