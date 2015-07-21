<?php

class EditorController extends Controller {

  public function link($pageId, $textarea = null) {

    $form = panel()->form('editor/link');
    $form->data('textarea', 'form-field-' . $textarea);
    $form->style('editor');
    $form->cancel($this->page($pageId), 'show');

    return modal('editor/link', compact('form'));

  }

  public function email($pageId, $textarea) {

    $form = panel()->form('editor/email');
    $form->data('textarea', 'form-field-' . $textarea);
    $form->style('editor');
    $form->cancel($this->page($pageId), 'show');

    return modal('editor/email', compact('form'));

  }

  protected function page($pageId) {

    $page = $pageId == '/' ? site() : page($pageId);

    if($page) {
      return $page;
    } else {
      throw new Exception('The page could not be found');
    }

  }

}
