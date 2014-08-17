<?php

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// panel roots
root('panel',                 dirname(__DIR__));
root('panel.assets',          root('panel') . DS . 'assets');

// app setup
root('panel.app',             root('panel')     . DS . 'app');
root('panel.app.languages',   root('panel.app') . DS . 'languages');
root('panel.app.fields',      root('panel.app') . DS . 'fields');
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
  'api'          => root('panel.app.lib') . DS . 'api.php',
  'pagedata'     => root('panel.app.lib') . DS . 'pagedata.php',
  'installation' => root('panel.app.lib') . DS . 'installation.php',
  'form'         => root('panel.app.lib') . DS . 'form.php',
  'fieldoptions' => root('panel.app.lib') . DS . 'fieldoptions.php',
  'assets'       => root('panel.app.lib') . DS . 'assets.php',
  'history'      => root('panel.app.lib') . DS . 'history.php',

  // blueprint stuff
  'blueprint'         => root('panel.app.lib') . DS . 'blueprint.php',
  'blueprint\\pages'  => root('panel.app.lib') . DS . 'blueprint' . DS . 'pages.php',
  'blueprint\\files'  => root('panel.app.lib') . DS . 'blueprint' . DS . 'files.php',
  'blueprint\\fields' => root('panel.app.lib') . DS . 'blueprint' . DS . 'fields.php',
  'blueprint\\field'  => root('panel.app.lib') . DS . 'blueprint' . DS . 'field.php',

));

// load all helper functions
require(root('panel.app') . DS . 'helpers.php');

// setup the form plugin
form::setup(root('panel.app.fields'));

// panel upload defaults
c::set('panel.upload.accept', function($file) {
  $types = array('image', 'video', 'audio', 'archive', 'document');
  return in_array($file->type(), $types);
});
