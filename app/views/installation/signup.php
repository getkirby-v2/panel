<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__alert" ng-show="message" ng-click="alert('')">
    {{message}}
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('installation.signup.headline') ?></label>
    <input class="form__input" autofocus type="text" required placeholder="<?php echo l('installation.signup.username') ?>" ng-model="user.username">
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('installation.signup.email') ?></label>
    <input class="form__input" type="email" required placeholder="<?php echo l('installation.signup.email.placeholder') ?>" ng-model="user.email">
  </div>

  <div class="form__field">
    <label class="form__label"><?php echo l('installation.signup.password') ?></label>
    <input class="form__input" type="password" required ng-model="user.password">
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
    <input type="submit" class="form__button form__button--submit" value="<?php echo l('installation.signup.create') ?>">
  </div>
</form>