<?php

use Kirby\Panel\Form;

class AssetsController extends Kirby\Panel\Controllers\Base {

  public function js() {
    return new Response(Form::js(false), 'text/javascript');
  }

  public function css() {
    return new Response(Form::css(), 'text/css');
  }

}