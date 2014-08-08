<?php if(!empty($alert)): ?>
<div class="message message-is-alert">
  <span class="message-content"><?php __($alert) ?></span>
  <span class="message-toggle"><i>&times;</i></span>
</div>
<?php endif ?>

<form class="form" method="post" autocomplete="off">

  <div class="field">
    <label class="label"><?php _l('installation.signup.headline') ?></label>
    <input class="input" autofocus type="text" required placeholder="<?php _l('installation.signup.username') ?>" name="username" value="<?php __(get('username')) ?>">
  </div>

  <div class="field">
    <label class="label"><?php _l('installation.signup.email.label') ?></label>
    <input class="input" type="email" required placeholder="<?php _l('installation.signup.email.placeholder') ?>" name="email" value="<?php __(get('email')) ?>">
  </div>

  <div class="field">
    <label class="label"><?php _l('installation.signup.password.label') ?></label>
    <input class="input" type="password" required name="password">
  </div>

  <div class="field">
    <label class="label"><?php _l('installation.signup.language.label') ?></label>
    <div class="input input-with-selectbox">
      <select class="selectbox" name="language" required>
        <?php foreach($languages as $language): ?>
        <option value="<?php echo $language->code() ?>"<?php e(get('language', 'en') == $language->code(), ' selected') ?>><?php echo __($language->title()) ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>

  <div class="buttons buttons-centered cf">
    <input type="submit" class="btn btn-rounded btn-submit" value="<?php _l('installation.signup.button') ?>">
  </div>

</form>