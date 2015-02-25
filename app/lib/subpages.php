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
    $num = $this->num($uid, $to);
    $this->find($uid)->sort($num);
    $this->clean($this->visible()->not($uid), $num);
    return $num;
  }

  public function hide($uid) {
    $this->find($uid)->hide();
    $this->clean($this->visible());
  }

  public function delete($uid) {
    $this->find($uid)->delete();
    $this->clean($this->visible());
  }

}