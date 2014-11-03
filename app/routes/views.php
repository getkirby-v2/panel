<?php

// register all available routes
return array(

  // Index
  array(
    'pattern' => '/',
    'action'  => 'views/AppController::index',
    'filter'  => array('auth', 'isInstalled'),
  ),

  // Authentication
  array(
    'pattern' => 'login/(:any?)',
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
    'action'  => 'views/InstallationController::index',
    'method'  => 'GET|POST'
  ),

  // Dashboard
  array(
    'pattern' => 'views/dashboard/index',
    'action'  => 'views/DashboardController::index',
    'filter'  => 'auth'
  ),

  // Metatags
  array(
    'pattern' => 'views/metatags/index',
    'action'  => 'views/MetatagsController::index',
    'filter'  => 'auth'
  ),

  // Pages
  array(
    'pattern' => 'views/pages/show/(:all)',
    'action'  => 'views/PagesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => 'views/pages/add/(:all?)',
    'action'  => 'views/PagesController::add',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/pages/delete/(:all)',
    'action'  => 'views/PagesController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/pages/url/(:all)',
    'action'  => 'views/PagesController::url',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/pages/search/(:all?)',
    'action'  => 'views/PagesController::search',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Editor
  array(
    'pattern' => 'views/editor/link/(:all)',
    'action'  => 'views/EditorController::link',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/editor/email/(:all)',
    'action'  => 'views/EditorController::email',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/editor/image/(:all)',
    'action'  => 'views/EditorController::image',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/editor/file/(:all)',
    'action'  => 'views/EditorController::file',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/editor/structure/(:all)/(:any)',
    'action'  => 'views/EditorController::structure',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),

  // Subpages
  array(
    'pattern' => 'views/subpages/index/(:all?)',
    'action'  => 'views/SubpagesController::index',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),

  // Files
  array(
    'pattern' => 'views/files/index/(:all)',
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth'
  ),
  array(
    'pattern' => 'views/files/show/(:all)',
    'action'  => 'views/FilesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),
  array(
    'pattern' => 'views/files/replace/(:all)',
    'action'  => 'views/FilesController::replace',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/files/delete/(:all)',
    'action'  => 'views/FilesController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
  ),
  array(
    'pattern' => 'views/files/upload/(:all)',
    'action'  => 'views/FilesController::upload',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true,
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
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true
  ),
  array(
    'pattern' => 'views/users/edit/(:any)',
    'action'  => 'views/UsersController::edit',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => 'views/users/delete/(:any)',
    'action'  => 'views/UsersController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true
  ),
  array(
    'pattern' => 'views/users/avatar/(:any)',
    'action'  => 'views/UsersController::avatar',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true
  ),
  array(
    'pattern' => 'views/users/delete-avatar/(:any)',
    'action'  => 'views/UsersController::deleteAvatar',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
    'modal'   => true
  ),

  // Errors
  array(
    'pattern' => 'views/errors/index',
    'action'  => 'views/ErrorsController::index',
  ),
  array(
    'pattern' => 'views/errors/modal',
    'action'  => 'views/ErrorsController::modal',
  ),

  array(
    'pattern' => '(:all)',
    'action'  => 'views/ErrorsController::page',
  ),

);