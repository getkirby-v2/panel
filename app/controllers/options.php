<?php

class OptionsController extends Kirby\Panel\Controllers\Base {

  public function index() {

    $site   = panel()->site();
    $editor = $site->editor();

    if (!panel()->user()->isAllowed('updateSite', $site)) {
      $this->redirect();
    }

    return $this->screen('options/index', $site, array(
      'site'     => $site,
      'form'     => $editor->form(),
      'files'    => $editor->files(),
      'license'  => panel()->license(),
      'uploader' => $this->snippet('uploader', array('url' => $site->url('upload')))
    ));

  }

}
