<?php

class PagesController extends Controller {

  public function create($id = '') {

    $page           = $this->page($id);
    $pageOptions    = new PageOptions($page);

    if(!$pageOptions->canSubpagesAdd()) {
      return response::error('You are not allowed to create new pages');


    try {

      $page = api::createPage($id, get('title'), get('template'), get('uid'));

      return response::success('success', array(
        'uid' => $page->uid(),
        'uri' => $page->id()
      ));

    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function update($id = '') {

    $page         = $this->page($id);
    $pageOptions  = new PageOptions($page);

    if(!$pageOptions->canSave()) {
      return response::error('You are not allowed to update pages');

    if(!$page) {
      return response::error(l('pages.error.missing'));
    }

    $blueprint = blueprint::find($page);
    $fields    = $blueprint->fields($page);
    $oldTitle  = (string)$page->title();

    // trigger the validation
    $form = new Form($fields->toArray());
    $form->validate();

    // fetch the data for the form
    $data = pagedata::createByInput($page, $form->serialize());

    // stop at invalid fields
    if(!$form->isValid()) {
      return response::error(l('pages.show.error.form'), 400, array(
        'fields' => $form->fields()->filterBy('error', true)->pluck('name')
      ));
    }

    try {

      $page->update($data);

      // make sure that the sorting number is correct
      if($page->isVisible()) {

        $num = api::createPageNum($page);

        if($num !== $page->num()) {

          if($num > 0) {
            $page->sort($num);
          }

        }

      }

      // get the blueprint of the parent page to find the
      // correct sorting mode for this page
      $parentBlueprint = blueprint::find($page->parent());

      // auto-update the uid if the sorting mode is set to zero
      if($parentBlueprint->pages()->num()->mode() == 'zero') {
        $uid = str::slug($page->title());
        $page->move($uid);
      }

      history::visit($page->id());

      return response::success('success', array(
        'file' => $page->content()->root(),
        'data' => $data,
        'uid'  => $page->uid(),
        'uri'  => $page->id()
      ));

    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function delete($id) {


    if($page = $this->page($id);) {
      $parent       = $page->parent();
      $pageOptions  = new PageOptions($page);
    } else {
      return response::error(l('pages.error.missing'));
    }

    if(!$pageOptions->canDelete())
      return response::error('You are not allowed to delete pages');

    $subpages = new Subpages($parent);

    try {
      $subpages->delete($page);
      return response::success('success');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function sort($id = '') {

    if ($page = $this->page($id)) {
      $parent         = $page->parent();
      $parentOptions  = new PageOptions($page);
    } else {
      return response::error(l('pages.error.missing'));
    }

    if(!$parentOptions->canSubpagesSort())
      return response::error('You are not allowed to sort pages');


    $subpages = new Subpages($parent);
    $num      = $subpages->sort($page, get('to'));

    return response::success('The page has been sorted', array(
      'num' => $num
    ));

  }

  public function publish($id) {

    if($page = $this->page($id)) {
      $parent       = $page->parent();
      $pageOptions  = new PageOptions($page);
    } else {
      return response::error(l('pages.error.missing'));
    }

    if(!$pageOptions->canHide())
      return response::error('You are not allowed to publish pages');

    if($page->isErrorPage()) {
      return response::error('The error page cannot be published');
    }

    $subpages = new Subpages($parent);
    $num      = $subpages->sort($page, 'last');

    return response::success('The page has been sorted', array(
      'num' => $num
    ));

  }

  public function hide($id) {

    if($page = $this->page($id)) {
      $parent       = $page->parent();
      $pageOptions  = new PageOptions($page);
    } else {
      return response::error(l('pages.error.missing'));
    }

    if(!$pageOptions->canHide())
      return response::error('You are not allowed to hide pages');


    $subpages = new Subpages($parent);

    try {
      $subpages->hide($page);
      return response::success('success');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function url($id) {

    if($page = $this->page($id)) {
      $pageOptions  = new PageOptions($page);
    } else {
      return response::error(l('pages.error.missing'));
    }

    if(!$pageOptions->canChangeURL())
      return response::error('You are not allowed to change pages urls');


    // avoid url changes for the home and error pages
    if($page->isErrorPage() or $page->isHomePage()) {
      return response::error('This page type\'s url cannot be changed');
    }

    try {

      if(site()->multilang() and site()->language()->code() != site()->defaultLanguage()->code()) {
        $page->update(array(
          'URL-Key' => get('uid')
        ));
      } else {
        $page->move(get('uid'));
      }

      return response::success('success', array(
        'uid' => $page->uid(),
        'uri' => $page->id()
      ));

    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  protected function page($id) {
    return empty($id) ? site() : page($id);
  }

}
