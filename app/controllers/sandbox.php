<?php

class SandboxController extends Controller {

  public function index() {

    $site = panel()->site();

    $page = $site->find('about');
    $page->sort('first');

  }

}