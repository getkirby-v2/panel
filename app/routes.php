<?php 

// register all available routes
return array(

  // Authentication
  array(
    'pattern' => 'api/auth/login',
    'action'  => 'AuthController::login',
    'method'  => 'POST',
  ),
  array(
    'pattern' => 'api/auth/logout',
    'action'  => 'AuthController::logout',
    'method'  => 'POST',
  ),
 
  // Pages
  array(
    'pattern' => 'api/pages/show',
    'action'  => 'PagesController::show'
  ),
  array(
    'pattern' => 'api/pages/create',
    'action'  => 'PagesController::create',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/update',
    'action'  => 'PagesController::update',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/delete',
    'action'  => 'PagesController::delete',
    'method'  => 'DELETE'
  ),
  array(
    'pattern' => 'api/pages/templates',
    'action'  => 'PagesController::templates'
  ),
  array(
    'pattern' => 'api/pages/change-url',
    'action'  => 'PagesController::changeURL', 
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/form',
    'action'  => 'FormController::fields'
  ),

  // Site
  array(
    'pattern' => 'api/site/metatags',
    'action'  => 'SiteController::metatags'
  ),

  // Files
  array(
    'pattern' => 'api/files/show',
    'action'  => 'FilesController::show'
  ),
  array(
    'pattern' => 'api/files/upload',
    'action'  => 'FilesController::upload',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/files/update',
    'action'  => 'FilesController::update',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/files/delete',
    'action'  => 'FilesController::delete',
    'method'  => 'DELETE'
  ),
  array(
    'pattern' => 'api/files/fields',
    'action'  => 'FilesController::fields',
    'method'  => 'GET'
  ),

  // Users
  array(
    'pattern' => 'api/users',
    'action'  => 'UsersController::index'
  ),
  array(
    'pattern' => 'api/users/create',
    'action'  => 'UsersController::create',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/users/show/(:any)',
    'action'  => 'UsersController::show'
  ),
  array(
    'pattern' => 'api/users/delete/(:any)',
    'action'  => 'UsersController::delete',
    'method'  => 'DELETE'
  ),

  // helpers
  array(
    'pattern' => 'api/slug',
    'action'  => 'HelpersController::slug'
  ),

  // Index
  array(
    'pattern' => '(:all)',
    'action'  => 'AppController::index',
  ),

);