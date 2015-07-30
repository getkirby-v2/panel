<?php

class PagesController extends Controller {

  public function add($id, $template = null) {

    $parent = $this->page($id);
  
    if(empty($template)) {
      return view('pages/add', array(
        'parent'    => $parent,
        'templates' => $parent->blueprint()->pages()->template(),
        'back'      => $parent->url()
      ));
    } else {
      $this->redirect($parent->createSubpage($template));
    }

  }

  public function edit($id) {
    $editor = $this->page($id)->editor();
    return screen('pages/edit', $editor->page(), $editor->content());
  }

  public function delete($id) {

    $self = $this;
    $page = $this->page($id);

    try {
      $page->isDeletable(true);
    } catch(Exception $e) {
      return modal('error', array(
        'headline' => l($e->getMessage() . '.headline'),
        'text'     => l($e->getMessage() . '.text'),
        'back'     => $page->url()
      ));      
    }

    $form = $page->form('delete', function($form) use($page, $self) {
      try {
        $page->delete();
        $self->notify(':)');
        $self->redirect($page->parent());
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }
    });

    return modal('pages/delete', compact('form'));

  }

  public function keep($id) {
    $page = $this->page($id);
    $page->keepChanges();
    $this->redirect($page);
  }

  public function discard($id) {
    $page = $this->page($id);
    $page->discardChanges();
    $this->redirect($page);
  }

  public function url($id) {

    $self = $this;
    $page = $this->page($id);

    if(!$page->canChangeUrl()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'The URL for the home and error pages cannot be changed',
      ));      
    }

    $form = $page->form('url', function($form) use($page, $self) {

      try {
        $page->changeUrl(get('uid'));              
        $self->notify(':)');
        $self->redirect($page);
      } catch(Exception $e) {
        $form->alert($e->getMessage());
        $form->fields->uid->error = true;
      }

    });

    return modal('pages/url', compact('form'));

  }

  public function toggle($id) {

    $self = $this;
    $page = $this->page($id);

    if($page->isErrorPage()) {
      return modal('error', array(
        'headline' => 'Error',
        'text'     => 'The status of the error page cannot be changed',
      ));
    }

    $form = $page->form('toggle', function($form) use($page, $self) {

      try {
        $page->toggle(get('position', 'last'));
        $self->notify(':)');
        $self->redirect($page);
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return modal('pages/toggle', compact('form'));

  }

  public function search($id = '/') {
    $page = $this->page($id);
    return screen('pages/search', $page, compact('page'));
  }

  public function context($id) {
    return $this->page($id)->menu('context');
  }

}