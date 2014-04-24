<?php

class PagesController extends Controller {

  public function index() {
    return view('pages/index', array(
      'header' => new Snippet('pages/header')
    ));
  }

  public function add() {
    return view('pages/add');
  }

  public function publish() {
    return view('pages/publish');
  }

  public function delete() {
    return view('pages/delete');
  }

  public function header() {
    return view('pages/header');
  }

  public function metatags() {
    return view('pages/metatags');
  }

  public function url() {
    return view('pages/url');
  }

}