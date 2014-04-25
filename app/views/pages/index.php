<?php echo $header ?>

<div class="content" ng-show="page.writable.status">

  <aside class="sidebar">

    <div ng-hide="page.parent == null || page.error || page.home">
      <h2><a><?php echo l('pages.settings') ?></a></h2>
      <ul class="sidebar__items">
        <li ng-show="page.settings.pages">
          <a ui-sref="page.modal.add({uri: page.uri})">
            <i class="fa fa-plus-circle"></i> <?php echo l('subpages.add') ?>
          </a>
        </li>
        <li ng-show="page.settings.files">
          <a ui-sref="page.modal.upload({uri: page.uri})">
            <i class="fa fa-cloud-upload"></i> <?php echo l('files.upload') ?>
          </a>
        </li>
        <li ng-show="page.changeableURL.status">
          <a ui-sref="page.modal.url({uri: page.uri})">
            <i class="fa fa-chain"></i> <?php echo l('pages.changeUrl') ?>
          </a>
        </li>
        <li ng-show="page.deletable.status">
          <a ui-sref="page.modal.delete({uri: page.uri})">
            <i class="fa fa-trash-o"></i> <?php echo l('pages.delete') ?>
          </a>
        </li>
      </ul>
    </div>

    <div ng-show="!page.parent">
      <h2><a><?php echo l('site.settings') ?></a></h2>
      <ul class="sidebar__items">
        <li>
          <a ui-sref="page.modal.add({uri: page.uri})">
            <i class="fa fa-plus-circle"></i> <?php echo l('subpages.add') ?>
          </a>
        </li>
        <li>
          <a ng-show="!metatags" ui-sref="metatags" href="">
            <i class="fa fa-pencil"></i> <?php echo l('metatags.edit') ?>
          </a>
          <a ng-show="metatags" ui-sref="page" href="">
            <i class="fa fa-dashboard"></i> <?php echo l('metatags.cancel') ?>
          </a>
        </li>
        <li ng-show="publishHook">
          <a ui-sref="page.modal.publish()">
            <i class="fa fa-refresh"></i> <?php echo l('site.publish') ?>
          </a>
        </li>
      </ul>
    </div>

    <div ng-show="page.settings.pages">
      <h2>
        <a ui-sref="children({uri: page.uri})"><?php echo l('subpages.title') ?>
          <small><?php echo l('subpages.manage') ?> <i class="fa fa-arrow-circle-right"></i></small>
        </a>
      </h2>

      <form ng-show="page.children.length > limit" class="sidebar__form">
        <input class="sidebar__search" type="search" placeholder="<?php echo l('subpages.search.placeholder') ?>" ng-model="childSearch">
      </form>

      <ul class="sidebar__items">
        <li ng-repeat="child in page.children | filter: {title: childSearch} | limitTo: limit">
          <a ui-sref="page({uri: child.uri})">
            <i class="fa" ng-class="pageIconClass(child)"></i> {{child.title}}
            <small ng-show="child.visible" class="num">{{child.num}}</small>
            <small ng-show="!child.visible" class="num">—</small>
          </a>
        </li>
        <li ng-show="page.children.length > limit">
          <a ui-sref="children({uri: page.uri})" class="more">
            <i class="fa fa-arrow-circle-right"></i> <?php echo l('subpages.show') ?> ({{page.children.length}})…
          </a>
        </li>
        <li ng-show="page.children.length == 0"><span ui-sref="page.modal.add({uri: page.uri})"><?php echo l('subpages.empty') ?></span></li>
      </ul>

    </div>

    <div ng-show="page.parent && page.settings.files">
      <h2>
        <a ui-sref="files({uri: page.uri})">
          <?php echo l('files.title') ?>
          <small><?php echo l('files.manage') ?> <i class="fa fa-arrow-circle-right"></i></small>
        </a>
      </h2>
      <ul class="sidebar__items">
        <li ng-repeat="file in page.files">
          <a ui-sref="file({filename: file.filename, uri: page.uri})">
            <i class="fa fa-picture-o"></i> {{file.filename}}
          </a>
        </li>
        <li ng-show="page.files.length == 0"><span ui-sref="page.modal.upload({uri: page.uri})"><?php echo l('files.empty') ?></span></li>
      </ul>

    </div>

    <div ng-show="page.error">
      <h2><a><?php echo l('errorpage.title') ?></a></h2>
      <p class="sidebar__text">
        <?php echo l('errorpage.text') ?>
      </p>
    </div>

  </aside>

  <main class="main" ng-include="main"></main>

</div>

<div ng-hide="page.writable.status" class="content manager">
  <div class="manager__empty manager__empty--error">
    <a href="" ng-click="reload()">
      <i class="fa fa-exclamation-triangle fa-lg"></i> <span><?php echo l('unwritable.title') ?></span><br />
      <small><?php echo l('unwritable.text') ?></small>
    </a>
  </div>
</div>