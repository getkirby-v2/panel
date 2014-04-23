<div class="dashboard">
  
  <div class="dashboard__section">
    <h2 class="alpha">Your site</h1>
    <a href="{{page.url}}"><em>{{page.url}}</em></a>
  </div>

  <div class="dashboard__section" ng-repeat="section in sections">
    <h2 class="alpha"><a ui-sref="metatags">{{section.key}} <i class="fa fa-pencil"></i></a></h2>          
    {{section.value}}
  </div>

</div>