<?php

// register all available routes
return array(

  // App.js
  array(
    'pattern' => 'assets/js/app.js',
    'action'  => 'assets/JsController::app'
  ),
  // Libs.js
  array(
    'pattern' => 'assets/js/libs.js',
    'action'  => 'assets/JsController::libs'
  ),
  // Fields.js
  array(
    'pattern' => 'assets/js/fields.js',
    'action'  => 'assets/JsController::fields'
  ),


);