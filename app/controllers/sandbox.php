<?php

class SandboxController extends Kirby\Panel\Controller {

  public function index() {

    $site = panel()->site();

    $page = $site->find('about');
    $page->sort('first');

  }

}