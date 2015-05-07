<?php echo $topbar ?>

<div class="section">

  <div class="dashboard">

    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line hgroup-compressed cf">
        <span class="hgroup-title">
          <a href="#/subpages/index/"><?php _l('dashboard.index.pages.title') ?></a>
        </span>
        <span class="hgroup-options shiv shiv-dark shiv-left">
          <span class="hgroup-option-right">
            <a title="<?php _l('dashboard.index.pages.edit') ?>" href="#/subpages/index/">
              <?php i('pencil', 'left') ?><span><?php _l('dashboard.index.pages.edit') ?></span>
            </a>
            <?php if($addbutton): ?>
            <a title="+" data-shortcut="+" href="#/pages/add/">
              <?php i('plus-circle', 'left') ?><span><?php _l('dashboard.index.pages.add') ?></span>
            </a>
            <?php endif ?>
          </span>
        </span>
      </h2>

      <ul class="nav nav-list sidebar-list">
        <?php foreach($pages as $c): ?>
        <?php echo new Snippet('pages/sidebar/subpage', array('subpage' => $c)) ?>
        <?php endforeach ?>
      </ul>

    </div>

    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line cf">
        <span class="hgroup-title">
          <a target="_blank" href="<?php echo url() ?>"><?php _l('dashboard.index.site.title') ?></a>
        </span>
      </h2>

      <div class="field field-is-readonly">
        <div class="field-content">
          <div class="input input-is-readonly">
            <a target="_blank" href="<?php echo url() ?>"><?php e(url::isAbsolute(url()), url::short(url()), url()) ?></a>
          </div>
          <div class="field-icon">
            <i class="icon fa fa-chain"></i>
          </div>
        </div>
      </div>

    </div>

    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line cf">
        <span class="hgroup-title">
          <a href="<?php _u($user, 'edit') ?>"><?php _l('dashboard.index.account.title') ?></a>
        </span>
        <span class="hgroup-options shiv shiv-dark shiv-left">
          <span class="hgroup-option-right">
            <a href="<?php _u($user, 'edit') ?>">
              <?php i('pencil', 'left') ?><span><?php _l('dashboard.index.account.edit') ?></span>
            </a>
          </span>
        </span>
      </h2>

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

    </div>

    <?php foreach($widgets as $widget): ?>
    <?php if(!$widget) continue; ?>
    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line cf">
        <span class="hgroup-title">
          <?php __($widget['title']) ?>
        </span>
      </h2>

      <?php echo $widget['html']() ?>

    </div>
    <?php endforeach ?>

    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line cf">
        <span class="hgroup-title">
          <?php _l('dashboard.index.history.title') ?>
        </span>
      </h2>

      <div class="field">

        <div class="dashboard-box">
          <?php if(empty($history)): ?>
          <div class="text"><?php _l('dashboard.index.history.text') ?></div>
          <?php else: ?>
          <ul>
            <?php foreach($history as $item): ?>
            <li>
              <a title="<?php __($item->title()) ?>" href="<?php _u($item, 'show') ?>">
                <?php i('file-o', 'left') . __($item->title()) ?>
              </a>
            </li>
            <?php endforeach ?>
          </ul>
          <?php endif ?>
        </div>

      </div>
    </div>

    <?php if($license->type() == 'trial' and !$license->local()): ?>
    <!-- license -->
    <div class="section white dashboard-section">

      <h2 class="hgroup hgroup-single-line cf">
        <span class="hgroup-title">
          <?php _l('dashboard.index.license.title') ?>
        </span>
      </h2>

      <div class="field">

        <div class="dashboard-box">
          <div class="text">
            <p>
              It seems you are running Kirby on a public server without a valid license!
            </p>
            <p>
              Please, support Kirby and <a target="blank" href="http://getkirby.com/buy"><strong>buy&nbsp;a&nbsp;license&nbsp;now&nbsp;&rsaquo;</strong></a>
            </p>
            <p style="margin-bottom: 0">
              If you already have a license key, just add it to your config file: <a target="_blank" href="http://getkirby.com/docs/installation/license-code"><strong>site/config/config.php</strong></a>
            </p>
          </div>
        </div>

      </div>
    </div>
    <?php endif ?>

  </div>

</div>
