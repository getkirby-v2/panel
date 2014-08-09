<?php

class Api {

  static public function createPage($uri, $title, $template, $uid) {

    $parent = empty($uri)  ? site() : page($uri);
    $uid    = empty($uid) ? str::slug($title) : str::slug($uid);

    if(empty($title)) {
      throw new Exception(l('pages.add.error.title'));
    }

    if(empty($template)) {
      throw new Exception(l('pages.add.error.template'));
    }

    $data = pagedata::createByBlueprint($template, array(
      'title' => $title
    ));

    $page = $parent->children()->create($uid, $template, $data);

    $blueprint = blueprint::find($page);

    if(is_array($blueprint->pages()->build())) {

      foreach($blueprint->pages()->build() as $build) {

        $missing = a::missing($build, array('title', 'template', 'uid'));

        if(!empty($missing)) continue;

        static::createPage($page->uri(), $build['title'], $build['template'], $build['uid']);

      }

    }

    return $page;

  }

  static public function maxPages($page, $max) {

    if($max === 0) {
      return true;
    }

    if($max !== null and $max <= $page->children()->count()) {
      return true;
    }

    return false;

  }

  static public function subpages($pages, $blueprint) {

    switch($blueprint->pages()->sort()) {
      case 'flip':
        $pages = $pages->flip();
        break;
      default;

        $parts = str::split($blueprint->pages()->sort(), ' ');
        $field = a::get($parts, 0);
        $order = a::get($parts, 1);

        if($field) {
          $pages = $pages->sortBy($field, $order);
        }

        break;
    }

    return $pages;
  }

  static public function files($page, $blueprint) {

    $files = $page->files();

    if($blueprint->files()->sortable()) {
      $files = $files->sortBy('sort', 'asc');
    }

    if($blueprint->files()->sort() == 'flip') {
      $files = $files->flip();
    }

    return $files;

  }

  static public function createPageNum($page, $blueprint = null) {

    if(is_null($blueprint)) {
      $parent    = $page->parent() ? $page->parent() : site();
      $blueprint = blueprint::find($parent);
    }

    $num = $blueprint->pages()->num();

    switch($num->mode()) {
      case 'zero':
        return 0;
        break;
      case 'date':
        return $page->date($num->format(), $num->field());
        break;
      default:
        return false;
    }

  }

}