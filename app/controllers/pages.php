<?php

class PagesController extends Kirby\Panel\Controllers\Base {

  public function add($id) {

    $self   = $this;
    $parent = $this->page($id);

    if(!panel()->user()->isAllowed('createSubpages', $parent)) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to create a page',
      ));
    }

    $form   = $parent->form('add', function($form) use($parent, $self) {

      $form->validate();

      if(!$form->isValid()) {
        return $form->alert(l('pages.add.error.template'));
      }

      try {
        $data = $form->serialize();
        $page = $parent->children()->create($data['uid'], $data['template'], array(
          'title' => $data['title']
        ));
        $this->redirect($parent->isSite() ? '/' : $parent);
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }

    });

    return $this->modal('pages/add', compact('form'));

  }

  public function edit($id) {
    $editor = $this->page($id)->editor();
    return $this->screen('pages/edit', $editor->page(), $editor->content());
  }

  public function delete($id) {

    $self = $this;
    $page = $this->page($id);

    if(!panel()->user()->isAllowed('deletePage', $page)) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to delete this page',
      ));
    }

    try {
      $page->isDeletable(true);
    } catch(Exception $e) {
      return $this->modal('error', array(
        'headline' => l($e->getMessage() . '.headline'),
        'text'     => l($e->getMessage() . '.text'),
        'back'     => $page->url()
      ));
    }

    $form = $page->form('delete', function($form) use($page, $self) {
      try {
        $page->delete();
        $self->notify(':)');
        $self->redirect($page->parent()->isSite() ? '/' : $page->parent());
      } catch(Exception $e) {
        $form->alert($e->getMessage());
      }
    });

    return $this->modal('pages/delete', compact('form'));

  }

  public function keep($id) {
    $page = $this->page($id);
    $page->changes()->keep();
    $this->redirect($page);
  }

  public function discard($id) {
    $page = $this->page($id);
    $page->changes()->discard();
    $this->redirect($page);
  }

  public function url($id) {

    $self = $this;
    $page = $this->page($id);

    if(!$page->canChangeUrl()) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'The URL for the home and error pages cannot be changed',
      ));
    }

    if(!panel()->user()->isAllowed('movePage')) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to change the URL of this page',
      ));
    }

    $form = $page->form('url', function($form) use($page, $self) {

      try {
        $page->move(get('uid'));
        $self->notify(':)');
        $self->redirect($page);
      } catch(Exception $e) {
        $form->alert($e->getMessage());
        $form->fields->uid->error = true;
      }

    });

    return $this->modal('pages/url', compact('form'));

  }

  public function toggle($id) {

    $self = $this;
    $page = $this->page($id);

    if($page->isErrorPage()) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'The status of the error page cannot be changed',
      ));
    }

    if(!panel()->user()->isAllowed('hidePage', $page)) {
      return $this->modal('error', array(
        'headline' => 'Error',
        'text'     => 'You are not allowed to change the status of this page',
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

    return $this->modal('pages/toggle', compact('form'));

  }

  public function context($id) {
    return $this->page($id)->menu('context');
  }

}
