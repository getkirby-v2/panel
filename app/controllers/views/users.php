<?php

class UsersController extends Controller {

  public function index() {
    return view('users/index', array(
      'header' => new Snippet('users/header')
    ));
  }

  public function add() {
    return view('users/add');
  }

  public function edit() {
    return view('users/edit');
  }

  public function delete() {
    return view('users/delete');
  }

  public function avatar() {
    return view('users/avatar');
  }

  public function header() {
    return view('users/header');
  }

}