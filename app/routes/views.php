<?php

// register all available routes
return array(

  // Authentication
  array(
    'pattern' => 'login/(:any?)',
    'action'  => 'views/AuthController::login',
    'filter'  => 'isInstalled',
    'method'  => 'GET|POST'
  ),
  array(
    'pattern' => 'logout',
    'action'  => 'views/AuthController::logout',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),

  // Installation
  array(
    'pattern' => 'install',
    'action'  => 'views/InstallationController::index',
    'method'  => 'GET|POST'
  ),

  // Dashboard
  array(
    'pattern' => '/',
    'action'  => 'views/DashboardController::index',
    'filter'  => array('auth', 'isInstalled'),
  ),

  // Options
  array(
    'pattern' => 'options',
    'action'  => 'views/OptionsController::index',
    'filter'  => 'auth'
  ),

  // File
  array(
    'pattern' => 'site/file/(:any)/show',
    'action'  => 'views/FilesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),
  array(
    'pattern' => 'pages/(:all)/file/(:any)/show',
    'action'  => 'views/FilesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),

  // Files
  array(
    'pattern' => 'site/files',
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'pages/(:all)/files',
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth'
  ),

  // Search
  array(
    'pattern' => 'pages/(:all?)/search',
    'action'  => 'views/PagesController::search',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Page
  array(
    'pattern' => 'pages/(:all)/show',
    'action'  => 'views/PagesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Subpages
  array(
    'pattern' => 'site/subpages',
    'action'  => 'views/SubpagesController::index',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => 'pages/(:all)/subpages',
    'action'  => 'views/SubpagesController::index',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Users
  array(
    'pattern' => 'users',
    'action'  => 'views/UsersController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'users/add',
    'action'  => 'views/UsersController::add',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => 'users/(:any)/edit',
    'action'  => 'views/UsersController::edit',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

);
