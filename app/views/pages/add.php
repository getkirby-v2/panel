<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  {{go}}

  <div class="form__field">
    <label class="form__label">Add a new subpage…</label>
    <input class="form__input" type="text" placeholder="Title" ng-model="page.title" required autofocus ng-keyup="convertTitle()">
    <p ng-hide="appendix.visible" style="cursor: pointer" ng-click="appendix.edit()" class="form__help nowrap">
      <span ng-show="page.slug == ''">(enter your title)</span>{{page.slug}}
    </p>
  </div>

  <div ng-show="appendix.visible" class="form__field">
    <label class="form__label">
      URL-appendix
      <a class="form__labelOption" ng-click="appendix.close()" href=""><i class="fa fa-times-circle"></i> Close</a>
    </label>
    <input class="form__input" type="text" ng-model="page.slug" focus-on="AddPageController.page.slug">
    <p class="form__help nowrap">Format: lowercase a-z, 0-9 and regular dashes</p>
  </div>

  <div class="form__field" ng-show="templates.length > 1">
    <label class="form__label">Select a template</label>
    <div class="form__input">
      <select ng-model="page.template" required ng-options="template.name as template.title for template in templates"></select>
    </div>
  </div>

  <div class="form__field" ng-show="templates.length == 1">
    <label class="form__label">Template</label>  
    <div class="form__inputWrapper">
      <div class="form__input form__input--readonly">{{templates[0].title}}</div>
      <div class="form__inputIcon form__inputIcon--readonly">
        <i class="fa fa-lock"></i>
      </div>
    </div>
    <input type="hidden" ng-model="page.template" ng-value="templates[0].title">
  </div>

  <div class="form__buttons">
    <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="cancel">
    <input type="submit" class="form__button form__button--submit" value="add">
  </div>
</form>