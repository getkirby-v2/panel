<div class="form__field">
  <label class="form__label"><?php echo html($label) ?></label>
  <div class="form__input">
    <select ng-model="<?php echo $name ?>" required>
      <?php foreach($options as $key => $value): ?>
      <option ng-selected="<?php echo $name ?> == '<?php echo $key ?>'"><?php echo html($value) ?></option>
      <?php endforeach ?>
    </select>
  </div>
</div>