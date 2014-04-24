<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div ng-show="page.deletable.status">

    <div class="form__field">
      <label class="form__label"><?php echo l('pages.delete.headline') ?></label>
      <div class="form__input form__input--readonly">{{page.title}}</div>
      <p class="form__help"><?php echo l('pages.delete.url') ?>: {{page.uri}}</p>
    </div>

    <div class="form__buttons">
      <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="<?php echo l('cancel') ?>">
      <input type="submit" class="form__button form__button--submit form__button--negative" autofocus="autofocus" value="<?php echo l('delete') ?>">
    </div>

  </div>

  <div ng-show="!page.deletable.status">
    <div class="form__field form__field--centered">
      {{page.deletable.message}}
    </div>

    <div class="form__buttons form__buttons--centered">
      <input type="reset" class="form__button" ng-click="close()" value="<?php echo l('ok') ?>">
    </div>

  </div>

</form>
