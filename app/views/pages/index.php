<?php echo $header ?>

<div class="content" ng-show="page.writable.status">

  <aside class="sidebar">

    <div ng-hide="page.parent == null || page.error || page.home">
      <h2><a>Page settings</a></h2>
      <ul class="sidebar__items">
        <li ng-show="page.settings.pages">
          <a ui-sref="page.modal.add({uri: page.uri})">
            <i class="fa fa-plus-circle"></i> Add a new subpage…
          </a>
        </li>
        <li ng-show="page.settings.files">
          <a ui-sref="page.modal.upload({uri: page.uri})">
            <i class="fa fa-cloud-upload"></i> Upload a new file…
          </a>
        </li>
        <li ng-show="page.changeableURL.status">
          <a ui-sref="page.modal.url({uri: page.uri})">
            <i class="fa fa-chain"></i> Change URL…
          </a>
        </li>
        <li ng-show="page.deletable.status">
          <a ui-sref="page.modal.delete({uri: page.uri})">
            <i class="fa fa-trash-o"></i> Delete page…
          </a>
        </li>
      </ul>
    </div>

    <div ng-show="!page.parent">
      <h2><a>Site settings</a></h2>
      <ul class="sidebar__items">
        <li>
          <a ui-sref="page.modal.add({uri: page.uri})">
            <i class="fa fa-plus-circle"></i> Add a new subpage…
          </a>
        </li>
        <li>
          <a ng-show="!metatags" ui-sref="metatags" href="">
            <i class="fa fa-pencil"></i> Edit metatags…
          </a>
          <a ng-show="metatags" ui-sref="page" href="">
            <i class="fa fa-dashboard"></i> Go to dashboard…
          </a>
        </li>
        <li ng-show="publishHook">
          <a ui-sref="page.modal.publish()">
            <i class="fa fa-refresh"></i> Publish changes…
          </a>
        </li>
      </ul>
    </div>

    <div ng-show="page.settings.pages">
      <h2><a ui-sref="children({uri: page.uri})">Subpages <small>manage <i class="fa fa-arrow-circle-right"></i></small></a></h2>

      <form ng-show="page.children.length > limit" class="sidebar__form">
        <input class="sidebar__search" type="search" placeholder="Search for a subpage…" ng-model="childSearch">
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
            <i class="fa fa-arrow-circle-right"></i> Show all ({{page.children.length}})…
          </a>
        </li>
        <li ng-show="page.children.length == 0"><span ui-sref="page.modal.add({uri: page.uri})">This page has no subpages</span></li>
      </ul>

    </div>

    <div ng-show="page.parent && page.settings.files">
      <h2><a ui-sref="files({uri: page.uri})">Files <small>manage <i class="fa fa-arrow-circle-right"></i></small></a></h2>
      <ul class="sidebar__items">
        <li ng-repeat="file in page.files">
          <a ui-sref="file({filename: file.filename, uri: page.uri})">
            <i class="fa fa-picture-o"></i> {{file.filename}}
          </a>
        </li>
        <li ng-show="page.files.length == 0"><span ui-sref="page.modal.upload({uri: page.uri})">This page has no files</span></li>
      </ul>

    </div>

    <div ng-show="page.error">
      <h2><a>Error Page</a></h2>
      <p class="sidebar__text">
        This is your site's error page.
        Your visitors will see this whenever they
        enter a URL, which is not available.
      </p>
    </div>

  </aside>

  <main class="main" ng-include="main"></main>

</div>

<div ng-hide="page.writable.status" class="content manager">
  <div class="manager__empty manager__empty--error">
    <a href="" ng-click="reload()">
      <i class="fa fa-exclamation-triangle fa-lg"></i> <span>The page is not writable</span><br />
      <small>Please check the permissions for the content folder and all files.</small>
    </a>
  </div>
</div>