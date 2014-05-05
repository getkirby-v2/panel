<?php

// register all available routes
return array(

  // App.js
  array(
    'pattern' => 'combine/js/app',
    'action'  => 'assets/JsController::app'
  ),
  // Libs.js
  array(
    'pattern' => 'combine/js/libs',
    'action'  => 'assets/JsController::libs'
  ),
  // Fields.js
  array(
    'pattern' => 'combine/js/fields',
    'action'  => 'assets/JsController::fields'
  ),


);