<div class="field">
  <div class="input input-with-items">
    <div class="item item-condensed item-with-image">
      <div class="item-content grey">
        <figure class="item-image">
          <a class="item-image-container" href="<?php __($user->url()) ?>">
            <img src="<?php echo $user->avatar()->url() ?>" alt="<?php __($user->username()) ?>">
          </a>
        </figure>
        <div class="item-info">
          <a class="item-title" href="<?php __($user->url()) ?>">
            <?php __($user->username()) ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>