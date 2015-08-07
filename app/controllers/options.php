<?php

class OptionsController extends Controller {

  public function index() {

    $site   = panel()->site();
    $editor = $site->editor();

    return screen('options/index', $site, array(
      'site'    => $site,
      'form'    => $editor->form(),
      'files'   => $editor->files(),
      'license' => panel()->license()
    ));

  }

}