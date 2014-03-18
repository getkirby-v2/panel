<?php 

define('DS', DIRECTORY_SEPARATOR);

// load the bootstrapper
include(dirname(__DIR__) . DS . 'kirby' . DS . 'bootstrap.php');

// setup the site object
$site = kirby::setup();
$site->visit('/');

// some config stuff
c::set('root.panel', __DIR__);
c::set('root.blueprints', c::get('root.site') . DS . 'panel' . DS . 'blueprints');
c::set('root.accounts',   c::get('root.site') . DS . 'panel' . DS . 'accounts');

// load helpers
require(__DIR__ . DS . 'helpers.php');

// load models
require(__DIR__ . DS . 'models' . DS . 'user.php');

// load controllers
$authController    = require(__DIR__ . DS . 'controllers' . DS . 'auth.php');
$pagesController   = require(__DIR__ . DS . 'controllers' . DS . 'pages.php');
$siteController    = require(__DIR__ . DS . 'controllers' . DS . 'site.php');
$filesController   = require(__DIR__ . DS . 'controllers' . DS . 'files.php');
$formController    = require(__DIR__ . DS . 'controllers' . DS . 'form.php');
$usersController   = require(__DIR__ . DS . 'controllers' . DS . 'users.php');
$helpersController = require(__DIR__ . DS . 'controllers' . DS . 'helpers.php');

// start routing
$router = new Router();

// register all available routes
$router->register(array(

  // Authentication
  array(
    'pattern' => 'api/auth/login',
    'action'  => $authController['login'],
    'method'  => 'POST',
  ),
  array(
    'pattern' => 'api/auth/logout',
    'action'  => $authController['logout'],
    'method'  => 'POST',
  ),
 
  // Pages
  array(
    'pattern' => 'api/pages/show',
    'action'  => $pagesController['show']
  ),
  array(
    'pattern' => 'api/pages/create',
    'action'  => $pagesController['create'],
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/update',
    'action'  => $pagesController['update'],
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/delete',
    'action'  => $pagesController['delete'],
    'method'  => 'DELETE'
  ),
  array(
    'pattern' => 'api/pages/templates',
    'action'  => $pagesController['templates']
  ),
  array(
    'pattern' => 'api/pages/change-url',
    'action'  => $pagesController['change-url'], 
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/pages/form',
    'action'  => $formController['fields']
  ),

  // Site
  array(
    'pattern' => 'api/site/metatags',
    'action'  => $siteController['metatags']
  ),

  // Files
  array(
    'pattern' => 'api/files/show',
    'action'  => $filesController['show']
  ),
  array(
    'pattern' => 'api/files/upload',
    'action'  => $filesController['upload'],
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/files/delete',
    'action'  => $filesController['delete'],
    'method'  => 'DELETE'
  ),

  // Users
  array(
    'pattern' => 'api/users',
    'action'  => $usersController['index']
  ),
  array(
    'pattern' => 'api/users/create',
    'action'  => $usersController['create'],
    'method'  => 'POST'
  ),
  array(
    'pattern' => 'api/users/show/(:any)',
    'action'  => $usersController['show']
  ),
  array(
    'pattern' => 'api/users/delete/(:any)',
    'action'  => $usersController['delete'],
    'method'  => 'DELETE'
  ),

  // helpers
  array(
    'pattern' => 'api/slug',
    'action'  => $helpersController['slug']
  ),

  // Index
  array(
    'pattern' => '(:all)',
    'action'  => function() {
      require(__DIR__ . DS . 'views' . DS . 'index.html');
    }
  ),

));

// only use the fragments of the path without params
$path  = implode('/', (array)url::fragments(detect::path()));
$route = $router->run($path);

if(!$route) {
  die('Invalid route');
} else {

  $response = call($route->action(), $route->arguments());
  if(is_a($response, 'Response')) echo $response;

}