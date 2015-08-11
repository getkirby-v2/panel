<div class="field">
  <div class="input input-with-items">
    <div class="item item-condensed item-with-image">
      <div class="item-content grey">
        <figure class="item-image">
          <a class="item-image-container" href="<?php _u($user, 'edit') ?>">
            <?php if($user->avatar()): ?>
            <img src="<?php echo $user->avatar()->url() ?>" alt="<?php __($user->username()) ?>">
            <?php else: ?>
            <img src="<?php echo panel()->urls()->images() . '/avatar.png' ?>" alt="<?php __($user->username()) ?>">
            <?php endif ?>
          </a>
        </figure>
        <div class="item-info">
          <a class="item-title" href="<?php _u($user, 'edit') ?>">
            <?php __($user->username()) ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>