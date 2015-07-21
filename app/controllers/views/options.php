<?php

class OptionsController extends Controller {

  public function index() {

    $editor = new PageEditor();    

    return screen('options/index', $editor->page(), array(
      'form'    => $editor->form(),
      'files'   => $editor->files(),
      'license' => panel()->license()
    ));

  }

}