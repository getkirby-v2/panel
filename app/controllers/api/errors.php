<?php

class ErrorsController extends Controller {

  public function index() {
    return response::error('Invalid API method');
  }

}