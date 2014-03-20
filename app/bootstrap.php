<?php

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// app setup 
path('app',             __DIR__);
path('app.controllers', __DIR__ . DS . 'controllers');
path('app.models',      __DIR__ . DS . 'models');
path('app.layouts',     __DIR__ . DS . 'layouts');
path('app.views',       __DIR__ . DS . 'views');

// autoloader
load(array(

  // load library classes
  'app'        => __DIR__ . DS . 'lib' . DS . 'app.php',
  'view'       => __DIR__ . DS . 'lib' . DS . 'view.php',
  'controller' => __DIR__ . DS . 'lib' . DS . 'controller.php',
  'layout'     => __DIR__ . DS . 'lib' . DS . 'layout.php',

));

require(__DIR__ . DS . 'helpers.php');