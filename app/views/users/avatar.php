<div class="form">

  <div ng-show="!uploadable">

    <div class="form__field">
      <label class="form__label"><?php echo l('users.avatar.error.folder.headline') ?></label>
      <p><?php echo l('users.avatar.error.folder.text') ?></p>
    </div>

  </div>

  <div ng-show="uploadable">

    <div class="form__field" ng-show="user.avatar">
      <figure class="form__avatar">
        <span ng-click="delete()">
          <img ng-show="user.avatar" ng-src="{{user.avatar}}">
          <a href="">&times;</a>
        </span>
      </figure>
    </div>

    <form class="form__field dz" action="api/users/avatar" dropzone done="submit()">
      <strong><?php echo l('users.avatar.drop') ?></strong>
      <small><?php echo l('users.avatar.click') ?></small>
      <input type="hidden" name="username" ng-value="user.username">
    </form>

  </div>

  <div class="form__buttons form__buttons--centered">
    <input type="reset" class="form__button" ng-click="close()" value="<?php echo l('cancel') ?>">
  </div>

</div>