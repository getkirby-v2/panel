<?php 

// register all available routes
return array(

  // Index
  array(
    'pattern' => '/',
    'action'  => 'AppController::index',
    'filter'  => array('auth', 'isInstalled'),
  ),

  // Authentication
  array(
    'pattern' => 'login',
    'action'  => 'AuthController::login',
    'filter'  => 'isInstalled',
  ),
  array(
    'pattern' => 'api/auth/login',
    'action'  => 'AuthController::auth',
    'method'  => 'POST',
  ),
  array(
    'pattern' => 'logout',
    'action'  => 'AuthController::logout',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),

  // Installation
  array(
    'pattern' => 'install',
    'action'  => 'InstallationController::index'
  ),
  array(
    'pattern' => 'api/install',
    'action'  => 'InstallationController::run',
    'method'  => 'POST'
  ),

 
  // Pages
  array(
    'pattern' => 'api/pages/show',
    'action'  => 'PagesController::show',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/create',
    'action'  => 'PagesController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/update',
    'action'  => 'PagesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/delete',
    'action'  => 'PagesController::delete',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/sort',
    'action'  => 'PagesController::sort',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/hide',
    'action'  => 'PagesController::hide',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/templates',
    'action'  => 'PagesController::templates',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/change-url',
    'action'  => 'PagesController::changeURL', 
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/pages/form',
    'action'  => 'PagesController::fields',
    'filter'  => 'auth',
  ),

  // Site
  array(
    'pattern' => 'api/site/metatags',
    'action'  => 'SiteController::metatags',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/site/languages',
    'action'  => 'SiteController::languages',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/site/health',
    'action'  => 'SiteController::health'
  ),

  // Files
  array(
    'pattern' => 'api/files/show',
    'action'  => 'FilesController::show',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/upload',
    'action'  => 'FilesController::upload',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/update',
    'action'  => 'FilesController::update',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/rename',
    'action'  => 'FilesController::rename',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/delete',
    'action'  => 'FilesController::delete',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/files/fields',
    'action'  => 'FilesController::fields',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),

  // Users
  array(
    'pattern' => 'api/users',
    'action'  => 'UsersController::index',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/create',
    'action'  => 'UsersController::create',
    'method'  => 'POST',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/show/(:any)',
    'action'  => 'UsersController::show',
    'filter'  => 'auth',
  ),
  array(
    'pattern' => 'api/users/delete/(:any)',
    'action'  => 'UsersController::delete',
    'method'  => 'DELETE',
    'filter'  => 'auth',
  ),

  // helpers
  array(
    'pattern' => 'api/slug',
    'action'  => 'HelpersController::slug',
    'filter'  => 'auth',
  ),

);