<?php

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// panel roots
root('panel',                 dirname(__DIR__));
root('panel.languages',       root('panel') . DS . 'languages');
root('panel.assets',          root('panel') . DS . 'assets');
root('panel.fields',          root('panel') . DS . 'fields');

// app setup
root('panel.app',             root('panel') . DS . 'app');
root('panel.app.lib',         root('panel.app') . DS . 'lib');
root('panel.app.controllers', root('panel.app') . DS . 'controllers');
root('panel.app.models',      root('panel.app') . DS . 'models');
root('panel.app.layouts',     root('panel.app') . DS . 'layouts');
root('panel.app.views',       root('panel.app') . DS . 'views');
root('panel.app.routes',      root('panel.app') . DS . 'routes');
root('panel.app.snippets',    root('panel.app') . DS . 'snippets');

// autoloader
load(array(

  // mvc
  'app'        => root('panel.app.lib') . DS . 'app.php',
  'view'       => root('panel.app.lib') . DS . 'view.php',
  'controller' => root('panel.app.lib') . DS . 'controller.php',
  'layout'     => root('panel.app.lib') . DS . 'layout.php',
  'snippet'    => root('panel.app.lib') . DS . 'snippet.php',

  // panel stuff
  'api'        => root('panel.app.lib') . DS . 'api.php',
  'pagedata'   => root('panel.app.lib') . DS . 'pagedata.php',

));

// load all helper functions
require(root('panel.app') . DS . 'helpers.php');