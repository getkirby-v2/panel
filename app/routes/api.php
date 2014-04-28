<?php

// register all available routes
return array(

  // Authentication
  array(
    'pattern' => 'api/auth/login',
    'action'  => 'api/AuthController::login',
    'method'  => 'POST',
  ),

  // App
  array(
    'pattern' => 'api/app/health',
    'action'  => 'api/AppController::health'
  ),
  array(
    'pattern' => 'api/app/health/(:all?)',
    'action'  => 'api/AppController::health',
    'filter'  => 'auth'
  ),

  // Installation
  array(
    'pattern' => 'api/install',
    'action'  => 'api/InstallationController::run',
    'method'  => 'POST'
  ),

  // Pages
  array(
    'pattern' => 'api/pages/show',
    'action'  => 'api/PagesController::show',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/create',
    'action'  => 'api/PagesController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/update',
    'action'  => 'api/PagesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/delete',
    'action'  => 'api/PagesController::delete',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/sort',
    'action'  => 'api/PagesController::sort',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/hide',
    'action'  => 'api/PagesController::hide',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/templates',
    'action'  => 'api/PagesController::templates',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/change-url',
    'action'  => 'api/PagesController::changeURL',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/form',
    'action'  => 'api/PagesController::form',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/fields',
    'action'  => 'api/PagesController::fields',
    'filter'  => 'auth',
  ),

  // Site
  array(
    'pattern' => 'api/site/metatags',
    'action'  => 'api/SiteController::metatags',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/site/languages',
    'action'  => 'api/SiteController::languages',
    'filter'  => 'auth',
  ),

  // Files
  array(
    'pattern' => 'api/files/show',
    'action'  => 'api/FilesController::show',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/upload',
    'action'  => 'api/FilesController::upload',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/replace',
    'action'  => 'api/FilesController::replace',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/update',
    'action'  => 'api/FilesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/rename',
    'action'  => 'api/FilesController::rename',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/delete',
    'action'  => 'api/FilesController::delete',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/fields',
    'action'  => 'api/FilesController::fields',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/form',
    'action'  => 'api/FilesController::form',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),

  // Users
  array(
    'pattern' => 'api/users',
    'action'  => 'api/UsersController::index',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/create',
    'action'  => 'api/UsersController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/show/(:any)',
    'action'  => 'api/UsersController::show',
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
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/avatar',
    'action'  => 'api/UsersController::avatar',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/avatar',
    'action'  => 'api/UsersController::deleteAvatar',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),

  // helpers
  array(
    'pattern' => 'api/slug',
    'action'  => 'api/HelpersController::slug',
    'filter'  => 'auth',
  ),

);