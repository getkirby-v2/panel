<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div ng-show="page.changeableURL.status">

    <div class="form__field">
      <label class="form__label">
        <?php echo l('pages.url.headline') ?>
        <a class="form__labelOption" ng-click="convertTitle()" href=""><i class="fa fa-plus-circle"></i> <?php echo l('pages.url.createFromTitle') ?></a>
      </label>
      <div class="form__inputWrapper">
        <input class="form__input form__input--with-icon" type="text" autofocus required ng-model="page.slug" focus-on="ChangeUrlController.page.slug" />
        <div class="form__inputIcon">
          <i class="fa fa-chain"></i>
        </div>
      </div>
      <p class="form__help">{{page.parent.uri}}/<strong class="nowrap">{{page.slug}}</strong></p>
    </div>

    <div class="form__buttons">
      <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="<?php echo l('cancel') ?>">
      <input type="submit" class="form__button form__button--submit" value="<?php echo l('save') ?>">
    </div>

  </div>

  <div ng-show="!page.changeableURL.status">
    <div class="form__field form__field--centered">
      {{page.changeableURL.message}}
    </div>

    <div class="form__buttons form__buttons--centered">
      <input type="reset" class="form__button" ng-click="close()" value="<?php echo l('ok') ?>">
    </div>

  </div>

</form>