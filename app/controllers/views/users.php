<?php

class UsersController extends Controller {

  public function index() {
    return view('users/index', array(
      'header' => new Snippet('users/header')
    ));
  }

  public function add() {
    return view('users/add', array(
      'languages' => app::languages()
    ));
  }

  public function edit() {
    return view('users/edit', array(
      'languages' => app::languages()
    ));
  }

  public function delete() {
    return view('users/delete');
  }

  public function avatar() {
    return view('users/avatar', array(
      'uploadable' => is_writable(c::get('root') . DS . 'assets' . DS . 'avatars')
    ));
  }

  public function header() {
    return view('users/header');
  }

}