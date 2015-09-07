<?php

class SearchController extends Kirby\Panel\Controllers\Base {

  public function results() {

    if($query = get('q') and !empty($query) and str::length($query) >= 3) {

      $pages = panel()->site()->index()->search($query, 'title|uri')->limit(10);      
      $users = panel()->users()->filter(function($user) use($query) {
        return (
          str::contains($user->username(), $query) or 
          str::contains($user->email(), $query)
        );
      })->limit(10);

    } else {
      $pages = new Collection();
      $users = new Collection();
    }

    return $this->view('search/results', compact('pages', 'users'));

  }

}