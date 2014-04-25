<form class="form main__form grid" ng-submit="submit()" ng-show="page.content">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <?php echo $fields ?>

  <div class="grid__item one-whole">
    <div class="form__buttons">
      <input ng-show="!page.parent" type="reset" ui-sref="page" class="form__button form__button--cancel" value="<?php echo l('cancel') ?>">
      <input type="submit" class="form__button form__button--submit" value="<?php echo l('save') ?>">
    </div>
    <div class="page__template" ng-show="page.parent">
      <i class="fa fa-file-text"></i> <?php echo l('pages.template') ?>: <strong>{{page.template}}</strong>
    </div>
  </div>

</form>

<div class="form main__form" ng-show="!page.content">
  <strong><?php echo l('pages.form.error.nocontent.headline') ?></strong><br />
  <?php echo l('pages.form.error.nocontent.text') ?>
</div>