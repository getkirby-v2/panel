<?php

// register all available routes
return array(

  // Authentication
  array(
    'pattern' => 'api/auth/login',
    'action'  => 'api/AuthController::login',
    'method'  => 'POST',
  ),

  // Pages
  array(
    'pattern' => 'api/pages/create/(:all?)',
    'action'  => 'api/PagesController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/update/(:all?)',
    'action'  => 'api/PagesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/delete/(:all)',
    'action'  => 'api/PagesController::delete',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/sort/(:all?)',
    'action'  => 'api/PagesController::sort',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/hide/(:all)',
    'action'  => 'api/PagesController::hide',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/url/(:all)',
    'action'  => 'api/PagesController::url',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),

  // Files
  array(
    'pattern' => 'api/files/upload/(:all)',
    'action'  => 'api/FilesController::upload',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/replace/(:all)',
    'action'  => 'api/FilesController::replace',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/update/(:all)',
    'action'  => 'api/FilesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/rename/(:all)',
    'action'  => 'api/FilesController::rename',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/sort/(:all)',
    'action'  => 'api/FilesController::sort',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/delete/(:all)',
    'action'  => 'api/FilesController::delete',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),

  // Users
  array(
    'pattern' => 'api/users/create',
    'action'  => 'api/UsersController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/update/(:any)',
    'action'  => 'api/UsersController::update',
    'filter'  => 'auth',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/users/delete/(:any)',
    'action'  => 'api/UsersController::delete',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/avatars/upload/(:any)',
    'action'  => 'api/AvatarsController::upload',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/avatars/delete/(:any)',
    'action'  => 'api/AvatarsController::delete',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),

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

  array(
    'pattern' => 'api/(:all)',
    'action'  => 'api/ErrorsController::index',
    'filter'  => 'auth',
  )

);