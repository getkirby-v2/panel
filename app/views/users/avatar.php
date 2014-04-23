<div class="form">

  <div class="form__field" ng-show="user.avatar">
    <figure class="form__avatar">
      <span ng-click="delete()">
        <img ng-show="user.avatar" ng-src="{{user.avatar}}">
        <a href="">&times;</a>
      </span>
    </figure>
  </div>

  <form class="form__field dz" action="api/users/avatar" dropzone done="submit()">
    <strong>Drop a profile picture here…</strong>
    <small>or click to upload</small>
    <input type="hidden" name="username" ng-value="user.username">
  </form>

  <div class="form__buttons form__buttons--centered">
    <input type="reset" class="form__button" ng-click="close()" value="cancel">
  </div>

</div>