<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__field form__field--centered">
    <label class="form__label"><?php echo l('pages.publish.headline') ?></label>
    <p>
      <?php echo l('pages.publish.text') ?>
    </p>
    <p>
      <img src="assets/images/loader.black.gif" alt="<?php echo l('pages.publish.headline') ?>">
    </p>
  </div>

  <div class="form__buttons form__buttons--centered">
    <input type="reset" class="form__button" ng-click="close()" value="<?php echo l('cancel') ?>">
  </div>

</form>