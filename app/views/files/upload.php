<div class="form">

  <form class="form__field dz" action="api/files/upload" dropzone done="submit()">
    <strong><?php echo l('files.upload.drop') ?></strong>
    <small><?php echo l('files.upload.click') ?></small>
    <input type="hidden" name="uri" ng-value="page.uri">
  </form>

  <div class="form__buttons form__buttons--centered">
    <input tabindex="-1" type="reset" class="form__button" ng-click="close()" value="<?php echo l('cancel') ?>">
  </div>
</div>