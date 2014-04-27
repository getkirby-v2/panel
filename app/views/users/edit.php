<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('users.edit.username') ?></label>
    <div class="form__inputWrapper">
      <input tabindex="-1" class="form__input form__input--readonly form__input--with-icon" readonly type="text" ng-model="user.username" required>
      <div class="form__inputIcon form__inputIcon--readonly">
        <i class="fa fa-lock"></i>
      </div>
    </div>
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('users.edit.email') ?></label>
    <input class="form__input" type="email" placeholder="<?php echo l('users.edit.email.placeholder') ?>" ng-model="user.email" required autofocus>
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('users.edit.password') ?></label>
    <input class="form__input" type="password" ng-model="user.password">
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('users.edit.language') ?></label>
    <div class="form__input">
      <select ng-model="user.language" required>
        <?php foreach($languages as $language): ?>
        <option value="<?php echo $language->code() ?>"><?php echo html($language->title()) ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>

  <div class="form__buttons">
    <input tabindex="-1" type="reset" class="form__button form__button--cancel" ng-click="close()" value="<?php echo l('cancel') ?>">
    <input type="submit" class="form__button form__button--submit" value="<?php echo l('save') ?>">
  </div>
</form>