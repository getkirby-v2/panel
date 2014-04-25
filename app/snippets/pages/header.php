<header class="topbar cf">
  <?php echo new Snippet('menu') ?>

  <ul class="breadcrumb">
    <li>
      <a ui-sref="page({uri: null})"><span><?php echo l('site.title') ?></span></a>
    </li>
    <li ng-repeat="parent in page.parents">
      <a ui-sref="page({uri: parent.uri})"><span>{{parent.title}}</span></a>
    </li>
    <li ng-show="page.parent">
      <a ui-sref="page({uri: page.uri})"><span>{{page.content.title}}</span></a>
    </li>
    <li ng-repeat="crumb in breadcrumb">
      <a ng-href="{{crumb.url}}"><span>{{crumb.label}}</span></a>
    </li>
  </ul>

  <div class="languagesToggle" ng-show="languages.length != 0">
    <select ng-model="language" ng-change="setLanguage(this)" ng-options="l.code as l.label for l in languages"></select>
  </div>

  <a target="_blank" href="{{page.url}}" class="previewToggle"><i class="fa fa-desktop fa-lg"></i></a>
</header>