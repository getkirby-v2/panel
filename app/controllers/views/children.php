<?php

class ChildrenController extends Controller {

  public function index() {
    return view('children/index', array(
      'header' => new Snippet('pages/header')
    ));
  }

}