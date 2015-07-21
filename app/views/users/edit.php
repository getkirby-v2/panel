<div class="bars bars-with-sidebar-left cf">

  <div class="sidebar sidebar-left">

    <a class="sidebar-toggle" href="#sidebar" data-hide="<?php _l('options.hide') ?>"><span><?php _l('options.show') ?></span></a>

    <div class="sidebar-content section">

      <?php if($user and $writable): ?>
      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title"><?php _l('users.form.options.headline') ?></span>
      </h2>

      <ul class="nav nav-list sidebar-list">

        <?php if(!$user->is(site()->user())): ?>
        <li>
          <a href="mailto:<?php echo $user->email() ?>">
            <?php i('envelope-square', 'left') . _l('users.form.options.message') ?>
          </a>
        </li>
        <?php endif ?>

        <li>
          <a data-modal title="#" data-shortcut="#" href="<?php echo purl($user, 'delete') ?>">
            <?php i('trash-o', 'left') . _l('users.form.options.delete') ?>
          </a>
        </li>

      </ul>

      <h2 class="hgroup hgroup-single-line<?php e(!$user->avatar(), ' hgroup-compressed') ?> cf">
        <span class="hgroup-title"><?php _l('users.form.avatar.headline') ?></span>
      </h2>

      <?php if($user->avatar()): ?>
      <div class="field">
        <a data-modal class="avatar avatar-large" href="<?php _u($user, 'avatar') ?>"><img src="<?php echo $user->avatar()->url() . '?' . $user->avatar()->modified() ?>"></a>
      </div>
      <?php endif ?>

      <ul class="nav nav-list sidebar-list">

        <?php if($user->avatar()): ?>
        <li>
          <a data-modal href="<?php _u($user, 'avatar') ?>">
            <?php i('pencil', 'left') . _l('users.form.avatar.replace') ?>
          </a>
        </li>

        <li>
          <a data-modal href="<?php _u($user, 'avatar/delete') ?>">
            <?php i('trash-o', 'left') . _l('users.form.avatar.delete') ?>
          </a>
        </li>
        <?php else: ?>
        <li>
          <a data-modal href="<?php _u($user, 'avatar') ?>">
            <?php i('cloud-upload', 'left') . _l('users.form.avatar.upload') ?>
          </a>
        </li>
        <?php endif ?>

      </ul>

      <?php elseif($user and !$writable): ?>
      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title"><?php _l('users.form.options.headline') ?></span>
      </h2>

      <a class="btn btn-with-icon" href="#/users">
        <?php i('arrow-circle-left', 'left') . _l('users.form.back') ?>
      </a>

      <?php else: ?>
      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title"><?php _l('users.index.add') ?></span>
      </h2>

      <a class="btn btn-with-icon" href="#/users">
        <?php i('arrow-circle-left', 'left') . _l('users.form.back') ?>
      </a>
      <?php endif ?>

    </div>
  </div>

  <div class="mainbar">
    <div class="section">
      <?php if(!$writable): ?>
      <div class="form">
        <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
          <span class="hgroup-title"><?php _l('users.form.error.permissions.title') ?></span>
        </h2>
        <div class="text">
          <p><?php _l('users.form.error.permissions.text') ?></p>
        </div>
        <div><a href="<?php url::current() ?>" class="btn btn-rounded"><?php _l('pages.show.error.permissions.retry') ?></a></div>
      </div>
      <?php else: ?>
      <?php echo $form ?>
      <?php endif ?>
    </div>
  </div>

</div>