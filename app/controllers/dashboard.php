<?php

class DashboardController extends Controller {

  public function index() {

    return screen('dashboard/index', panel()->site(), array(
      'widgets' => new Widgets()
    ));

  }

}