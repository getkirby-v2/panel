<?php

// register all available routes
return array(

  // helpers
  array(
    'pattern' => 'api/slug',
    'action'  => 'api/HelpersController::slug',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/autocomplete/(:any)',
    'action'  => 'api/HelpersController::autocomplete',
    'filter'  => 'auth',
  ),

);