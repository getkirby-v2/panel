<?php echo $topbar ?>

<div class="section">

  <h2 class="hgroup hgroup-single-line cf">
    <span class="hgroup-title"><?php _l('users.index.headline') ?></span>
    <?php if($addbutton): ?>
      <span class="hgroup-options shiv shiv-dark shiv-left">
        <a title="+" data-shortcut="+" class="hgroup-option-right" href="#/users/add">
          <?php i('plus-circle', 'left') . _l('users.index.add') ?>
        </a>
      </span>
    <?php endif ?>
  </h2>

  <div class="items users">
    <?php foreach($users as $user): ?>
    <?php

    if($user->isCurrent() or $editbutton) {
      $urls = array(
        'avatar' => purl($user, 'avatar') . '/via:index',
        'edit'   => purl($user, 'edit')
      );
    } else {
      $urls = array(
        'avatar' => '#/users',
        'edit'   => '#/users'
      );
    }

    ?>
    <div class="item item-with-image">
      <div class="item-content">
        <figure class="item-image">
          <a class="item-image-container" href="<?php echo $urls['avatar'] ?>">
            <?php if($user->avatar()): ?>
            <img src="<?php echo $user->avatar()->url() . '?' . $user->avatar()->modified() ?>" alt="<?php __($user->username()) ?>">
            <?php else: ?>
            <img src="<?php echo panel()->urls()->images() . '/avatar.png' ?>" alt="<?php __($user->username()) ?>">
            <?php endif ?>
          </a>
        </figure>
        <div class="item-info">
          <?php if($user->isCurrent() or $editbutton) : ?>
            <a href="<?php echo $urls['edit'] ?>">
          <?php endif ?>
            <strong class="item-title"><?php __($user->username()) ?></strong>
            <small class="item-meta marginalia">
              <?php __($user->email()) ?>
              <span style="padding-left: 1em; font-style: italic; font-size: .9em; color: #aaa"><?php __($user->role()->name()) ?></span>
            </small>
          <?php if($user->isCurrent() or $editbutton) : ?>
            </a>
          <?php endif ?>
        </div>
      </div>

      <nav class="item-options">

        <ul class="nav nav-bar">
            <li>
              <?php if($user->isCurrent() or $editbutton) : ?>
              <a class="btn btn-with-icon" href="<?php echo purl($user, 'edit') ?>">
                <?php i('pencil', 'left') . _l('users.index.edit') ?>
              </a>

              <?php else : ?>
                <span class="btn btn-with-icon btn-disabled">
                  <?php i('pencil', 'left') . _l('users.index.edit') ?>
                </span>
              <?php endif ?>
            </li>

            <li>
              <?php if($deletebutton and !($user->isAdmin() and $lastadmin)) :?>
                <a class="btn btn-with-icon" href="<?php echo purl($user, 'delete') ?>/via:index">
                  <?php i('trash-o', 'left') . _l('users.index.delete') ?>
                </a>

              <?php else : ?>
                <span class="btn btn-with-icon btn-disabled">
                  <?php i('trash-o', 'left') . _l('users.index.delete') ?>
                </span>
              <?php endif; ?>
            </li>

        </ul>

      </nav>

    </div>
    <?php endforeach ?>
  </div>

</div>
