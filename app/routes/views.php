<?php

// register all available routes
return array(

  // Sandbox
  array(
    'pattern' => 'sandbox', 
    'action'  => 'views/SandboxController::index',
    'filter'  => 'auth',
    'method'  => 'ALL'
  ),

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
    'method'  => 'GET|POST',
    'filter'  => 'auth'
  ),

  // Files
  array(
    'pattern' => array(
      'site(/)file/(:any)/show',
      'pages/(:all)/file/(:any)/show',
    ),
    'action'  => 'views/FilesController::show',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),
  array(
    'pattern' => array(
      'site(/)file/(:any)/context',
      'pages/(:all)/file/(:any)/context',
    ),
    'action'  => 'views/FilesController::context',
    'filter'  => 'auth',
    'method'  => 'GET',
  ),
  array(
    'pattern' => array(
      'site(/)file/(:any)/delete',
      'pages/(:all)/file/(:any)/delete',
    ),
    'action'  => 'views/FilesController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),
  array(
    'pattern' => array(
      'site(/)file/(:any)/replace',
      'pages/(:all)/file/(:any)/replace',
    ),
    'action'  => 'views/FilesController::replace',
    'filter'  => 'auth',
    'method'  => 'POST',
  ),
  array(
    'pattern' => array(
      'site(/)files',
      'pages/(:all)/files',
    ),
    'action'  => 'views/FilesController::index',
    'filter'  => 'auth',
    'method'  => 'POST|GET',
  ),

  // editors
  array(
    'pattern' => array(
      'site(/)field/(:any)/link',
      'pages/(:all)/field/(:any)/link',
    ),
    'action'  => 'views/EditorController::link',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => array(
      'site(/)field/(:any)/email',
      'pages/(:all)/field/(:any)/email',
    ),
    'action'  => 'views/EditorController::email',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // structure editor routes
  array(
    'pattern' => array(
      'site(/)field/(:any)/structure/add',
      'pages/(:all)/field/(:any)/structure/add',
    ),
    'action'  => 'views/StructureController::add',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => array(
      'site(/)field/(:any)/structure/sort',
      'pages/(:all)/field/(:any)/structure/sort',
    ),
    'action'  => 'views/StructureController::sort',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => array(
      'site(/)field/(:any)/structure/(:any)/update',
      'pages/(:all)/field/(:any)/structure/(:any)/update',
    ),
    'action'  => 'views/StructureController::update',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => array(
      'site(/)field/(:any)/structure/(:any)/delete',
      'pages/(:all)/field/(:any)/structure/(:any)/delete',
    ),
    'action'  => 'views/StructureController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Search
  array(
    'pattern' => array(
      'site(/)search',
      'pages/(:all)/search',
    ),
    'action'  => 'views/PagesController::search',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // New Page
  array(
    'pattern' => array(
      'site(/)add/(:any?)',
      'pages/(:all)/add/(:any?)',
    ),
    'action'  => 'views/PagesController::add',
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

  // URL Settings
  array(
    'pattern' => 'pages/(:all)/url',
    'action'  => 'views/PagesController::url',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Toggle visibility
  array(
    'pattern' => 'pages/(:all)/toggle',
    'action'  => 'views/PagesController::toggle',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Delete a page
  array(
    'pattern' => 'pages/(:all)/delete',
    'action'  => 'views/PagesController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

  // Keeping page changes
  array(
    'pattern' => array(
      'site(/)keep',
      'pages/(:all)/keep',
    ),
    'action'  => 'views/PagesController::keep',
    'method'  => 'GET|POST',
    'filter'  => 'auth',
  ),

  // Discarding page changes
  array(
    'pattern' => array(
      'site(/)discard',
      'pages/(:all)/discard',
    ),
    'action'  => 'views/PagesController::discard',
    'method'  => 'GET|POST',
    'filter'  => 'auth',
  ),

  // Page context menu
  array(
    'pattern' => 'pages/(:all)/context',
    'action'  => 'views/PagesController::context',
    'method'  => 'GET',
    'filter'  => 'auth',
  ),

  // Upload a file
  array(
    'pattern' => array(
      'site(/)upload',
      'pages/(:all)/upload',
    ),
    'action'  => 'views/FilesController::upload',
    'filter'  => 'auth',
    'method'  => 'POST'
  ),

  // Subpages
  array(
    'pattern' => array(
      'site(/)subpages',
      'pages/(:all)/subpages',
    ),
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
  array(
    'pattern' => 'users/(:any)/delete',
    'action'  => 'views/UsersController::delete',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),
  array(
    'pattern' => 'users/(:any)/avatar',
    'action'  => 'views/UsersController::avatar',
    'filter'  => 'auth',
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'users/(:any)/avatar/delete',
    'action'  => 'views/UsersController::deleteAvatar',
    'filter'  => 'auth',
    'method'  => 'POST|GET'
  ),

);
