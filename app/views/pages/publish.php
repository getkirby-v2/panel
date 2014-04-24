<form class="form" ng-class="{loading: loading}" ng-submit="submit()">

  <div class="form__field form__field--centered">
    <label class="form__label">Publishing changes…</label>
    <p>
      Please wait a second. Your latest changes are being submitted to the server.
    </p>
    <p>
      <img src="assets/images/loader.black.gif">
    </p>
  </div>

  <div class="form__buttons form__buttons--centered">
    <input type="reset" class="form__button" ng-click="close()" value="cancel">
  </div>

</form>