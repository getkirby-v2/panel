<?php

class FilesController extends Controller {

  public function index() {
    return view('files/index', array(
      'header' => new Snippet('pages/header')
    ));
  }

  public function edit() {
    return view('files/edit', array(
      'header' => new Snippet('pages/header')
    ));
  }

  public function delete() {
    return view('files/delete');
  }

  public function upload() {
    return view('files/upload');
  }

}