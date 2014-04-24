<form class="form" ng-submit="retry()">

  <div class="form__field">
    <label class="form__label"><?php echo l('installation.check.headline') ?></label>
    <p><?php echo l('installation.check.text') ?></p>
    <ul>
      <li class="form__alert" ng-repeat="problem in problems">{{problem}}</li>
    </ul>
  </div>

  <div class="form__buttons form__buttons--centered">
    <input type="submit" class="form__button" value="<?php echo l('installation.check.retry') ?>">
  </div>

</form>