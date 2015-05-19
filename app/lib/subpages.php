<?php

class Subpages {

  public $parent;

  public function __construct($parent) {
    $this->parent = is_a($parent, 'Page') ? $parent : page($parent);
    if(!$this->parent) throw new Exception('Invalid page');
  }

  public function visible() {
    return $this->parent->children()->visible();
  }

  public function find($uid) {
    if(is_a($uid, 'Page')) {
      return $uid;
    } else if($page = $this->parent->children()->find($uid)) {
      return $page;
    } else {
      throw new Exception('Page not found');
    }

  }

  public function clean($pages, $skip = false) {
    $to = 1;
    foreach($pages as $page) {
      if($to === $skip) $to++;
      $page->sort($this->num($page, $to));
      $to++;
    }
  }

  public function num($uid, $to = null) {

    $page      = $this->find($uid);
    $blueprint = blueprint::find($this->parent);
    $params    = $blueprint->pages()->num();

    if($to == 'last') {
      $to = $this->visible()->count() + 1;
    }

    switch($params->mode()) {
      case 'zero':
        return 0;
        break;
      case 'date':
        if($to = $page->date($params->format(), $params->field())) {
          return $to;
        } else {
          return date($params->format());
        }
        break;
      default:
        if(v::num($to)) {
          if($to <= 0) {
            $to = 1;
          } else {

            if($page->isInvisible()) {
              $limit = $this->visible()->count() + 1;
            } else {
              $limit = $this->visible()->count();
            }

            if($limit < $to) {
              $to = $limit;
            }

          }
          return intval($to);
        } else {
          return false;
        }
        break;
    }

  }

  public function sort($uid, $to) {

    $num  = $this->num($uid, $to);
    $page = $this->find($uid);

    // sort the selected page
    $page->sort($num);

    // clean the other page numbers
    $this->clean($this->visible()->not($uid), $num);

    // hit the hook
    kirby()->trigger('panel.page.sort', $page);

    return $num;

  }

  public function hide($uid) {

    $page = $this->find($uid);
    $page->hide();

    // clean the other page numbers
    $this->clean($this->visible()->not($uid));

    // hit the hook
    kirby()->trigger('panel.page.hide', $page);

  }

  public function delete($uid) {
    $page = $this->find($uid);
    $page->delete();

    // clean the other page numbers
    $this->clean($this->visible()->not($uid));
  
    // hit the hook
    kirby()->trigger('panel.page.delete', $page);

  }

}