<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('pages.add.headline') ?></label>
    <input class="form__input" type="text" placeholder="<?php echo l('pages.add.title.placeholder') ?>" ng-model="page.title" required autofocus ng-keyup="convertTitle()">
    <p ng-hide="appendix.visible" style="cursor: pointer" ng-click="appendix.edit()" class="form__help nowrap">
      <span ng-show="page.slug == ''"><?php echo l('pages.add.url.enter') ?></span>{{page.slug}}
    </p>
  </div>

  <div ng-show="appendix.visible" class="form__field">
    <label class="form__label">
      <?php echo l('pages.add.url') ?>
      <a class="form__labelOption" ng-click="appendix.close()" href=""><i class="fa fa-times-circle"></i> <?php echo l('pages.add.url.close') ?></a>
    </label>
    <input class="form__input" type="text" ng-model="page.slug" focus-on="AddPageController.page.slug">
    <p class="form__help nowrap"><?php echo l('pages.add.url.help') ?></p>
  </div>

  <div class="form__field" ng-show="templates.length > 1">
    <label class="form__label"><?php echo l('pages.add.template.select') ?></label>
    <div class="form__input">
      <select ng-model="page.template" required ng-options="template.name as template.title for template in templates"></select>
    </div>
  </div>

  <div class="form__field" ng-show="templates.length == 1">
    <label class="form__label"><?php echo l('pages.add.template') ?></label>
    <div class="form__inputWrapper">
      <div class="form__input form__input--readonly">{{templates[0].title}}</div>
      <div class="form__inputIcon form__inputIcon--readonly">
        <i class="fa fa-lock"></i>
      </div>
    </div>
    <input type="hidden" ng-model="page.template" ng-value="templates[0].title">
  </div>

  <div class="form__buttons">
    <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="<?php echo l('cancel') ?>">
    <input type="submit" class="form__button form__button--submit" value="<?php echo l('add') ?>">
  </div>

</form>