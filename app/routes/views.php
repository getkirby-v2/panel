<?php

// register all available routes
return array(

  // Index
  array(
    'pattern' => '/',
    'action'  => 'views/AppController::index',
    'filter'  => array('auth', 'isInstalled'),
  ),

  // Error page
  array(
    'pattern' => 'error',
    'action'  => 'views/AppController::error'
  ),

  // Authentication
  array(
    'pattern' => 'login',
    'action'  => 'views/AuthController::login',
    'filter'  => 'isInstalled',
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
    'action'  => 'views/InstallationController::index'
  ),
  array(
    'pattern' => 'views/installation/check',
    'action'  => 'views/InstallationController::check'
  ),
  array(
    'pattern' => 'views/installation/signup',
    'action'  => 'views/InstallationController::signup'
  ),

  // Pages
  array(
    'pattern' => 'views/pages/index',
    'action'  => 'views/PagesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/add',
    'action'  => 'views/PagesController::add',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/publish',
    'action'  => 'views/PagesController::publish',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/delete',
    'action'  => 'views/PagesController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/metatags',
    'action'  => 'views/PagesController::metatags',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/url',
    'action'  => 'views/PagesController::url',
    'filter'  => 'auth'
  ),

  // Children
  array(
    'pattern' => 'views/children/index',
    'action'  => 'views/ChildrenController::index',
    'filter'  => 'auth'
  ),

  // Files
  array(
    'pattern' => 'views/files/index',
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/edit',
    'action'  => 'views/FilesController::edit',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/delete',
    'action'  => 'views/FilesController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/upload',
    'action'  => 'views/FilesController::upload',
    'filter'  => 'auth'
  ),

  // Users
  array(
    'pattern' => 'views/users/index',
    'action'  => 'views/UsersController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/add',
    'action'  => 'views/UsersController::add',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/edit',
    'action'  => 'views/UsersController::edit',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/delete',
    'action'  => 'views/UsersController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/avatar',
    'action'  => 'views/UsersController::avatar',
    'filter'  => 'auth'
  ),

);