<?php

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// app setup
path('app',             __DIR__);
path('app.controllers', __DIR__ . DS . 'controllers');
path('app.models',      __DIR__ . DS . 'models');
path('app.layouts',     __DIR__ . DS . 'layouts');
path('app.views',       __DIR__ . DS . 'views');
path('app.snippets',    __DIR__ . DS . 'snippets');

// panel roots
path('panel',           dirname(__DIR__));
path('panel.languages', dirname(__DIR__) . DS . 'languages');

// autoloader
load(array(

  // mvc
  'app'        => __DIR__ . DS . 'lib' . DS . 'app.php',
  'view'       => __DIR__ . DS . 'lib' . DS . 'view.php',
  'controller' => __DIR__ . DS . 'lib' . DS . 'controller.php',
  'layout'     => __DIR__ . DS . 'lib' . DS . 'layout.php',
  'snippet'    => __DIR__ . DS . 'lib' . DS . 'snippet.php',

  // panel stuff
  'pagedata'   => __DIR__ . DS . 'lib' . DS . 'pagedata.php',

));

require(__DIR__ . DS . 'helpers.php');