<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div class="form__field">
    <label class="form__label">Do you really want to delete this file?</label>
    <div class="form__input form__input--readonly">{{file.filename}}</div>
  </div>

  <div class="form__buttons">
    <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="cancel">
    <input type="submit" class="form__button form__button--submit form__button--negative" autofocus="autofocus" value="delete">
  </div>
</form>