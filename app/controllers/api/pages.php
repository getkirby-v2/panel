<?php

class PagesController extends Controller {

  public function create($id = '') {

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

    $page = $this->page($id);

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

    $page = $this->page($id);

    if(!$page) {
      return response::error(l('pages.error.missing'));
    }

    try {
      $page->delete();
      return response::success('success');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function sort($id = '') {

    $page      = $this->page($id);
    $blueprint = blueprint::find($page);
    $uids      = get('uids');
    $flip      = $blueprint->pages()->sort() == 'flip';
    $children  = $page->children();

    if($flip) {
      $index = get('index', 1);
      $uids  = array_reverse($uids);
      $n     = $page->children()->visible()->count() - ($index * $blueprint->pages()->limit() - 1);

      if($n <= 0) $n = 1;

    } else {
      $index = (get('index', 1) - 1);
      $n     = (($blueprint->pages()->limit() * $index) + 1);
    }

    foreach($uids as $uid) {

      try {

        $child = $children->find($uid);
        $x     = api::createPageNum($child, $blueprint);

        if($x !== false and $x >= 0) {
          $child->sort($x);
        } else {
          $child->sort($n);
        }

        $n++;

      } catch(Exception $e) {

      }

    }

    return response::success('success');

  }

  public function hide($id) {

    $page = $this->page($id);

    if(!$page) {
      return response::error(l('pages.error.missing'));
    }

    try {
      $page->hide();
      return response::success('success');
    } catch(Exception $e) {
      return response::error($e->getMessage());
    }

  }

  public function url($id) {

    $page = $this->page($id);

    if(!$page) {
      return response::error(l('pages.error.missing'));
    }

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