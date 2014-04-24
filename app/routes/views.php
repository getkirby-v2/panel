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
    'pattern' => 'views/installation/check.html',
    'action'  => 'views/InstallationController::check'
  ),
  array(
    'pattern' => 'views/installation/signup.html',
    'action'  => 'views/InstallationController::signup'
  ),

  // Pages
  array(
    'pattern' => 'views/pages/index.html',
    'action'  => 'views/PagesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/add.html',
    'action'  => 'views/PagesController::add',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/publish.html',
    'action'  => 'views/PagesController::publish',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/delete.html',
    'action'  => 'views/PagesController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/metatags.html',
    'action'  => 'views/PagesController::metatags',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/pages/url.html',
    'action'  => 'views/PagesController::url',
    'filter'  => 'auth'
  ),

  // Children
  array(
    'pattern' => 'views/children/index.html',
    'action'  => 'views/ChildrenController::index',
    'filter'  => 'auth'
  ),

  // Files
  array(
    'pattern' => 'views/files/index.html',
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/edit.html',
    'action'  => 'views/FilesController::edit',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/delete.html',
    'action'  => 'views/FilesController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/upload.html',
    'action'  => 'views/FilesController::upload',
    'filter'  => 'auth'
  ),

  // Users
  array(
    'pattern' => 'views/users/index.html',
    'action'  => 'views/UsersController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/add.html',
    'action'  => 'views/UsersController::add',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/edit.html',
    'action'  => 'views/UsersController::edit',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/delete.html',
    'action'  => 'views/UsersController::delete',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/users/avatar.html',
    'action'  => 'views/UsersController::avatar',
    'filter'  => 'auth'
  ),

);