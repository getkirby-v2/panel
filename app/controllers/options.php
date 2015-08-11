<?php

class OptionsController extends Kirby\Panel\Controller {

  public function index() {

    $site   = panel()->site();
    $editor = $site->editor();

    return $this->screen('options/index', $site, array(
      'site'    => $site,
      'form'    => $editor->form(),
      'files'   => $editor->files(),
      'license' => panel()->license()
    ));

  }

}