<?php

class InstallationController extends Controller {

  public function check() {
    return view('installation/check');
  }

  public function signup() {
    return view('installation/signup');
  }

}