<?php

class DashboardController extends Kirby\Panel\Controller {

  public function index() {

    return $this->screen('dashboard/index', panel()->site(), array(
      'widgets' => new Kirby\Panel\Widgets()
    ));

  }

}